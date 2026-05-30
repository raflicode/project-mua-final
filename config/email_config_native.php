<?php
/**
 * Email Configuration - Menggunakan PHP Native mail()
 * 
 * Solusi paling reliable untuk shared hosting
 * PHP mail() menggunakan sendmail/postfix di server
 */

// Email Pengirim
define('MAIL_FROM_ADDRESS', 'admin@si-makeup.mif.myhost.id');
define('MAIL_FROM_NAME', 'Project MUA');

// Gunakan native mail() bukan SMTP
define('USE_NATIVE_MAIL', true);
