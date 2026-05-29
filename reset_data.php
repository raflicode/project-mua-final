<?php
// Reset Data Script - Hanya untuk testing, DELETE setelah selesai testing!
session_start();
require_once __DIR__ . '/config/koneksi.php';

// Check if already reset
if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
    try {
        $pdo->beginTransaction();

        // Disable foreign key checks
        $pdo->exec('SET FOREIGN_KEY_CHECKS=0');

        // Clear data but keep structure
        $pdo->exec('TRUNCATE TABLE booking_detail');
        $pdo->exec('TRUNCATE TABLE booking');
        $pdo->exec('TRUNCATE TABLE pembayaran');

        // Clear only client users, keep admin
        $pdo->exec('DELETE FROM user WHERE role != "admin"');

        // Keep layanan data intact
        // $pdo->exec('TRUNCATE TABLE layanan'); // Uncomment jika mau reset layanan juga

        // Re-enable foreign key checks
        $pdo->exec('SET FOREIGN_KEY_CHECKS=1');

        $pdo->commit();

        // Clear sessions
        session_destroy();

        // Clear all cookies
        foreach ($_COOKIE as $name => $value) {
            setcookie($name, '', time() - 3600, '/');
        }

        $success = true;
    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        $error = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Data - Testing Only</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }
        .reset-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            max-width: 500px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .reset-card h1 {
            color: #333;
            margin-bottom: 20px;
            font-weight: 700;
        }
        .reset-card p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .warning {
            background: #fff3cd;
            border: 1px solid #ffc107;
            color: #856404;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 500;
        }
        .btn-group-custom {
            display: flex;
            gap: 10px;
        }
        .success-msg {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .error-msg {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="reset-card">
        <?php if (isset($success) && $success): ?>
            <div class="success-msg">
                <h4 class="mb-3">✅ Data Berhasil Direset!</h4>
                <p class="mb-0">Semua data booking, pembayaran, dan client user telah dihapus.</p>
                <p class="mb-0">Layanan dan admin account tetap tersimpan.</p>
                <hr>
                <p class="mb-0 small">Redirect ke home dalam 3 detik...</p>
            </div>
            <script>
                setTimeout(() => {
                    window.location.href = 'index.php';
                }, 3000);
            </script>
        <?php elseif (isset($error)): ?>
            <div class="error-msg">
                <h4 class="mb-3">❌ Error!</h4>
                <p class="mb-0"><?= htmlspecialchars($error) ?></p>
            </div>
        <?php else: ?>
            <h1>⚠️ Reset Database</h1>
            <p>Ini akan menghapus semua data untuk testing ulang:</p>
            
            <div class="warning">
                <strong>⚡ Data yang akan dihapus:</strong>
                <ul class="mb-0 mt-2">
                    <li>Semua booking</li>
                    <li>Semua pembayaran</li>
                    <li>Semua client user</li>
                    <li>Detail booking</li>
                </ul>
            </div>

            <div class="alert alert-info mb-3">
                <strong>✅ Data yang tetap:</strong>
                <ul class="mb-0 mt-2">
                    <li>Admin account</li>
                    <li>Semua layanan & paket</li>
                </ul>
            </div>

            <div class="btn-group-custom">
                <a href="index.php" class="btn btn-secondary btn-lg" style="flex: 1;">Batal</a>
                <a href="reset_data.php?confirm=yes" class="btn btn-danger btn-lg" style="flex: 1;" onclick="return confirm('Yakin ingin reset? Semua data booking dan user client akan hilang!')">Reset Data</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
