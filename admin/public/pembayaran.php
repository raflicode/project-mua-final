<?php
require_once __DIR__ . '/../../config/auth.php';
require_login(['admin']);
header('Location: dashboard.php#laporan-pembayaran');
exit;
