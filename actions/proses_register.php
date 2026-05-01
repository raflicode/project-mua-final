<?php
require_once '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 1. Cek apakah username atau email sudah ada
    $check = $pdo->prepare("SELECT * FROM user WHERE username = ? OR email = ?");
    $check->execute([$username, $email]);
    
    if ($check->rowCount() > 0) {
        header("Location: ../register.php?error=Username or email already exists");
        exit();
    }

    // 2. Hash Password (WAJIB, jangan simpan teks biasa!)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // 3. Simpan ke database
    try {
        $stmt = $pdo->prepare("INSERT INTO user (full_name, username, email, pass) VALUES (?, ?, ?, ?)");
        $stmt->execute([$full_name, $username, $email, $hashedPassword]);
        
        // Redirect ke login setelah sukses
        header("Location: ../public/login.php?success=Registration complete! Please login.");
    } catch (PDOException $e) {
        header("Location: ../public/register.php?error=System error: " . $e->getMessage());
    }
}