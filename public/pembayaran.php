<?php
session_start();

$query = $_SERVER['QUERY_STRING'] ?? '';
$target = 'isidata.php' . ($query !== '' ? '?' . $query : '');

header('Location: ' . $target);
exit;
?>
