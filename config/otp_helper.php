<?php

const OTP_PURPOSE_PASSWORD_RESET = 'password_reset';
const OTP_PURPOSE_REGISTER = 'register';
const OTP_EXPIRY_MINUTES = 5;
const OTP_COOLDOWN_SECONDS = 60;
const OTP_MAX_REQUESTS_PER_HOUR = 5;
const OTP_MAX_VERIFY_ATTEMPTS = 5;

function normalizeOtpEmail($email) {
    return strtolower(trim((string) $email));
}

function generateOtpCode() {
    return (string) random_int(100000, 999999);
}

function getOtpFromPost($digits = 6) {
    $otp = '';
    for ($i = 1; $i <= $digits; $i++) {
        $otp .= $_POST['otp' . $i] ?? '';
    }

    return preg_replace('/\D/', '', $otp);
}

function createOtpRequest(PDO $pdo, $email, $purpose, $ipAddress = null, $userAgent = null) {
    $email = normalizeOtpEmail($email);

    $lastStmt = $pdo->prepare("
        SELECT requested_at
        FROM email_otp_requests
        WHERE email = ? AND purpose = ?
        ORDER BY requested_at DESC
        LIMIT 1
    ");
    $lastStmt->execute([$email, $purpose]);
    $lastRequest = $lastStmt->fetch();

    if ($lastRequest) {
        $lastTime = strtotime($lastRequest['requested_at']);
        $remaining = OTP_COOLDOWN_SECONDS - (time() - $lastTime);
        if ($remaining > 0) {
            return [
                'success' => false,
                'error' => 'Tunggu ' . $remaining . ' detik sebelum meminta OTP lagi.'
            ];
        }
    }

    $countStmt = $pdo->prepare("
        SELECT COUNT(*)
        FROM email_otp_requests
        WHERE email = ?
          AND purpose = ?
          AND requested_at >= (NOW() - INTERVAL 1 HOUR)
    ");
    $countStmt->execute([$email, $purpose]);

    if ((int) $countStmt->fetchColumn() >= OTP_MAX_REQUESTS_PER_HOUR) {
        return [
            'success' => false,
            'error' => 'Batas maksimal 5 permintaan OTP per jam sudah tercapai. Coba lagi nanti.'
        ];
    }

    $otp = generateOtpCode();
    $otpHash = password_hash($otp, PASSWORD_DEFAULT);

    $insertStmt = $pdo->prepare("
        INSERT INTO email_otp_requests
            (email, purpose, otp_hash, requested_at, expires_at, request_ip, user_agent)
        VALUES
            (?, ?, ?, NOW(), DATE_ADD(NOW(), INTERVAL ? MINUTE), ?, ?)
    ");
    $insertStmt->execute([
        $email,
        $purpose,
        $otpHash,
        OTP_EXPIRY_MINUTES,
        $ipAddress,
        $userAgent ? substr($userAgent, 0, 255) : null
    ]);

    return [
        'success' => true,
        'id' => (int) $pdo->lastInsertId(),
        'otp' => $otp,
        'email' => $email,
        'expires_minutes' => OTP_EXPIRY_MINUTES
    ];
}

function cancelOtpRequest(PDO $pdo, $requestId) {
    $stmt = $pdo->prepare("DELETE FROM email_otp_requests WHERE id = ? AND verified_at IS NULL");
    $stmt->execute([(int) $requestId]);
}

function verifyOtpRequest(PDO $pdo, $email, $purpose, $otp) {
    $email = normalizeOtpEmail($email);
    $otp = preg_replace('/\D/', '', (string) $otp);

    if (!preg_match('/^\d{6}$/', $otp)) {
        return ['success' => false, 'error' => 'Format OTP tidak valid. Masukkan 6 digit angka.'];
    }

    $stmt = $pdo->prepare("
        SELECT *
        FROM email_otp_requests
        WHERE email = ?
          AND purpose = ?
          AND verified_at IS NULL
        ORDER BY requested_at DESC
        LIMIT 1
    ");
    $stmt->execute([$email, $purpose]);
    $request = $stmt->fetch();

    if (!$request) {
        return ['success' => false, 'error' => 'OTP tidak ditemukan. Silakan minta kode OTP baru.'];
    }

    if ((int) $request['attempts'] >= OTP_MAX_VERIFY_ATTEMPTS) {
        return ['success' => false, 'error' => 'OTP diblokir karena terlalu banyak percobaan. Silakan minta kode OTP baru.'];
    }

    if (strtotime($request['expires_at']) < time()) {
        return ['success' => false, 'error' => 'OTP sudah kedaluwarsa. Silakan minta kode OTP baru.'];
    }

    if (!password_verify($otp, $request['otp_hash'])) {
        $updateAttempts = $pdo->prepare("UPDATE email_otp_requests SET attempts = attempts + 1 WHERE id = ?");
        $updateAttempts->execute([$request['id']]);

        return ['success' => false, 'error' => 'OTP salah. Periksa kembali 6 digit kode yang dikirim ke email Anda.'];
    }

    $verifyStmt = $pdo->prepare("UPDATE email_otp_requests SET verified_at = NOW() WHERE id = ?");
    $verifyStmt->execute([$request['id']]);

    return ['success' => true, 'email' => $email];
}
