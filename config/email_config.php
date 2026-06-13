<?php
/**
 * Email Configuration
 * Konfigurasi untuk pengiriman email via PHPMailer.
 *
 * Default: SendGrid SMTP.
 * Simpan API key di environment variable SENDGRID_API_KEY atau
 * buat file config/email_config.local.php yang mendefinisikan SENDGRID_API_KEY.
 */

if (file_exists(__DIR__ . '/email_config.local.php')) {
    require_once __DIR__ . '/email_config.local.php';
}

function emailEnv($key, $default = '') {
    if (isset($_ENV[$key]) && $_ENV[$key] !== '') {
        return $_ENV[$key];
    }

    if (isset($_SERVER[$key]) && $_SERVER[$key] !== '') {
        return $_SERVER[$key];
    }

    $value = getenv($key);
    return $value !== false && $value !== '' ? $value : $default;
}

function defineEmailConfig($key, $value) {
    if (!defined($key)) {
        define($key, $value);
    }
}

$sendGridApiKey = defined('SENDGRID_API_KEY') ? SENDGRID_API_KEY : emailEnv('SENDGRID_API_KEY');

// SMTP Configuration - SendGrid
defineEmailConfig('SMTP_HOST', emailEnv('SMTP_HOST', 'smtp.sendgrid.net'));
defineEmailConfig('SMTP_PORT', (int) emailEnv('SMTP_PORT', 587));
defineEmailConfig('SMTP_SECURE', emailEnv('SMTP_SECURE', 'tls'));
defineEmailConfig('SMTP_AUTH', true);

// SendGrid memakai username literal "apikey" dan password berisi API key.
defineEmailConfig('SMTP_USERNAME', emailEnv('SMTP_USERNAME', 'apikey'));
defineEmailConfig('SMTP_PASSWORD', emailEnv('SMTP_PASSWORD', $sendGridApiKey));

// Email pengirim harus sudah terverifikasi di SendGrid Sender Authentication.
defineEmailConfig('MAIL_FROM_ADDRESS', emailEnv('MAIL_FROM_ADDRESS', 'admin@si-makeup.mif.myhost.id'));
defineEmailConfig('MAIL_FROM_NAME', emailEnv('MAIL_FROM_NAME', 'Project MUA'));

// Jangan aktifkan debug di layar production.
defineEmailConfig('MAIL_DEBUG', (int) emailEnv('MAIL_DEBUG', 0));

// Aktifkan hanya jika server memang punya mailserver lokal/sendmail.
defineEmailConfig('USE_NATIVE_MAIL_FALLBACK', filter_var(emailEnv('USE_NATIVE_MAIL_FALLBACK', 'false'), FILTER_VALIDATE_BOOLEAN));
