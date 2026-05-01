<?php
session_start();
require_once '../config/koneksi.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $pass = $_POST['pass'];

    // 1. Prepared Statement untuk menghindari SQL Injection
    $stmt = $pdo->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($pass, $user['pass'])) {

        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['username'] = $user['username'];

        header("Location: ../index.php");
        exit();

    } else {
        header("Location: /project-mua/public/login.php?error=Login gagal");
        exit();
    }
}