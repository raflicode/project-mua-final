<?php
/**
 * Email Configuration
 * Konfigurasi untuk pengiriman email via PHPMailer
 * 
 * HOSTING: Menggunakan Mail Server Lokal (Localhost)
 * Ini bekerja di hosting karena menggunakan sendmail/postfix bawaan server
 */

// SMTP Configuration - Pakai Mail Server Lokal Hosting
// Ini adalah solusi paling reliable untuk shared hosting
define('SMTP_HOST', 'localhost');
define('SMTP_PORT', 25);
define('SMTP_SECURE', '');  // Kosong untuk localhost
define('SMTP_AUTH', false); // Tidak perlu auth untuk localhost

// Email Credentials - Tidak perlu untuk localhost
define('SMTP_USERNAME', '');
define('SMTP_PASSWORD', '');

// Email Pengirim - Ganti dengan nama domain/email Anda
// Format: no-reply@yourdomain.com atau support@yourdomain.com
define('MAIL_FROM_ADDRESS', 'noreply@projectmua.local');
define('MAIL_FROM_NAME', 'Project MUA');

// Enable Debug Mode
// Set ke 0 di production untuk hide error details
define('MAIL_DEBUG', 2);
