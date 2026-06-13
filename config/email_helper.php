<?php
/**
 * Email Helper Functions
 * Fungsi helper untuk mengirim email dengan PHPMailer
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/email_config.php';

/**
 * Mengirim email HTML dengan template yang sudah ditentukan
 * 
 * @param string $to Email penerima
 * @param string $subject Subject email
 * @param string $htmlBody HTML content email
 * @param string $plainBody Plain text content email (opsional)
 * @return array ['success' => bool, 'message' => string, 'error' => string|null]
 */
function sendEmail($to, $subject, $htmlBody, $plainBody = null) {
    if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
        return [
            'success' => false,
            'message' => 'Email penerima tidak valid',
            'error' => 'Email penerima tidak valid'
        ];
    }

    if (SMTP_AUTH && trim((string) SMTP_PASSWORD) === '') {
        $errorMsg = 'Konfigurasi email belum lengkap. SENDGRID_API_KEY belum diatur.';
        error_log($errorMsg);

        return [
            'success' => false,
            'message' => 'Konfigurasi email belum lengkap',
            'error' => $errorMsg
        ];
    }

    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->SMTPDebug = MAIL_DEBUG;
        $mail->Debugoutput = function($str, $level) {
            error_log("[PHPMailer debug level $level] $str");
        };

        $mail->Host = SMTP_HOST;
        
        // Hanya set auth jika dibutuhkan (bukan untuk localhost)
        if (SMTP_AUTH) {
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USERNAME;
            $mail->Password = SMTP_PASSWORD;
        }

        // Hanya set secure jika ada value (bukan untuk localhost)
        if (!empty(SMTP_SECURE)) {
            $mail->SMTPSecure = SMTP_SECURE;
        }

        $mail->Port = SMTP_PORT;
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';

        // Sender & Recipient
        $mail->setFrom(MAIL_FROM_ADDRESS, MAIL_FROM_NAME);
        $mail->addReplyTo(MAIL_FROM_ADDRESS, MAIL_FROM_NAME);
        $mail->addAddress($to);

        // Email Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $htmlBody;

        // Plain text alternative (untuk kompatibilitas email clients)
        if ($plainBody) {
            $mail->AltBody = $plainBody;
        }

        // Kirim
        $mail->send();

        return [
            'success' => true,
            'message' => 'Email berhasil dikirim',
            'error' => null
        ];

    } catch (Exception $e) {
        $errorMsg = "PHPMailer Error: " . $e->getMessage() . " | ErrorInfo: " . $mail->ErrorInfo;
        error_log($errorMsg);

        if (defined('USE_NATIVE_MAIL_FALLBACK') && USE_NATIVE_MAIL_FALLBACK) {
            return sendEmailWithNativeMail($to, $subject, $htmlBody, $plainBody, $errorMsg);
        }

        return [
            'success' => false,
            'message' => 'Gagal mengirim email via SMTP',
            'error' => $errorMsg
        ];
    }
}

function sendEmailWithNativeMail($to, $subject, $htmlBody, $plainBody = null, $previousError = null) {
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/alternative; boundary=\"==Multipart_Boundary_" . md5(time()) . "\"\r\n";
    $headers .= "From: " . MAIL_FROM_NAME . " <" . MAIL_FROM_ADDRESS . ">\r\n";
    $headers .= "Reply-To: " . MAIL_FROM_ADDRESS . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
    $headers .= "X-Priority: 3\r\n";
    $headers .= "Return-Path: " . MAIL_FROM_ADDRESS . "\r\n";

    $encodedSubject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
    $boundary = "==Multipart_Boundary_" . md5(time());

    $body = "--$boundary\r\n";
    $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $body .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
    $body .= ($plainBody ?: strip_tags(html_entity_decode($htmlBody))) . "\r\n";
    $body .= "--$boundary\r\n";
    $body .= "Content-Type: text/html; charset=UTF-8\r\n";
    $body .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
    $body .= $htmlBody . "\r\n";
    $body .= "--$boundary--\r\n";

    $mailSent = @mail($to, $encodedSubject, $body, $headers);

    if ($mailSent) {
        error_log("Fallback mail() berhasil mengirim ke $to");
        return [
            'success' => true,
            'message' => 'Email berhasil dikirim (fallback mail())',
            'error' => null
        ];
    }

    $errorMsg = "PHPMailer Error: " . $previousError . " | PHP mail() function gagal mengirim ke $to";
    error_log($errorMsg);

    return [
        'success' => false,
        'message' => 'Gagal mengirim email',
        'error' => $errorMsg
    ];
}

/**
 * Generate HTML template untuk email OTP
 * 
 * @param string $otp Kode OTP
 * @param int $validityMinutes Berapa menit OTP valid (default 10)
 * @return string HTML email template
 */
function getOtpEmailTemplate($otp, $validityMinutes = 10) {
    return "
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f5f5f5; }
            .container { max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); overflow: hidden; }
            .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px 20px; text-align: center; }
            .header h1 { font-size: 24px; margin-bottom: 5px; }
            .header p { font-size: 14px; opacity: 0.9; }
            .content { padding: 30px 20px; }
            .content p { color: #333; line-height: 1.6; margin-bottom: 15px; }
            .otp-section { background-color: #f9f9f9; border-left: 4px solid #667eea; padding: 20px; margin: 20px 0; border-radius: 4px; }
            .otp-label { color: #666; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; }
            .otp-code { font-size: 36px; font-weight: bold; color: #667eea; letter-spacing: 8px; font-family: 'Courier New', monospace; text-align: center; }
            .validity { color: #999; font-size: 12px; text-align: center; margin-top: 10px; }
            .warning { background-color: #fff3cd; border: 1px solid #ffc107; color: #856404; padding: 12px; border-radius: 4px; margin: 15px 0; font-size: 13px; }
            .footer { background-color: #f9f9f9; border-top: 1px solid #eee; padding: 20px; text-align: center; font-size: 12px; color: #999; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>Verifikasi Akun</h1>
                <p>Project MUA</p>
            </div>
            <div class='content'>
                <p>Halo,</p>
                <p>Kami menerima permintaan untuk verifikasi akun Anda. Gunakan kode OTP di bawah ini untuk melanjutkan proses verifikasi:</p>
                
                <div class='otp-section'>
                    <div class='otp-label'>Kode OTP Anda</div>
                    <div class='otp-code'>$otp</div>
                    <div class='validity'>Kode valid selama $validityMinutes menit</div>
                </div>

                <div class='warning'>
                    <strong>⚠️ Penting:</strong> Jangan bagikan kode ini kepada siapapun. Tim kami tidak akan pernah meminta kode OTP Anda melalui email atau pesan lain.
                </div>

                <p>Jika Anda tidak melakukan permintaan ini, silakan abaikan email ini atau hubungi kami segera.</p>
                
                <p>Terima kasih,<br><strong>Tim Project MUA</strong></p>
            </div>
            <div class='footer'>
                <p>Email ini dikirim otomatis. Silakan jangan reply ke email ini.</p>
                <p>&copy; 2026 Project MUA. All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>
    ";
}

/**
 * Generate plain text untuk email OTP
 * 
 * @param string $otp Kode OTP
 * @param int $validityMinutes Berapa menit OTP valid (default 10)
 * @return string Plain text email
 */
function getOtpPlainText($otp, $validityMinutes = 10) {
    return "VERIFIKASI AKUN - PROJECT MUA\n\n" .
           "Kode OTP Anda: $otp\n\n" .
           "Kode valid selama $validityMinutes menit.\n\n" .
           "PENTING: Jangan bagikan kode ini kepada siapapun.\n\n" .
           "Jika Anda tidak melakukan permintaan ini, abaikan email ini.\n\n" .
           "---\n" .
           "Pesan ini dikirim otomatis, jangan reply.\n" .
           "Tim Project MUA";
}
?>
