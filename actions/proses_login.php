<?php
session_start();
require_once '../config/koneksi.php'; // Pastikan $pdo ada di sini

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $pass = $_POST['pass'];

    // 1. Prepared Statement untuk menghindari SQL Injection
    $stmt = $pdo->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user) {
        // 2. Verifikasi Password (lebih aman daripada MD5/Plaintext)
        if (password_verify($pass, $user['pass'])) {
            // Login Sukses
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            
            header("Location: ../../project-mua/dasboard.php");
            exit();
        } else {
            // Password Salah
            header("Location: ../public/login.php?error=Wrong password");
        }
    } else {
        // Username tidak ditemukan
        header("Location: ../login.php?error=User not found");
    }
}