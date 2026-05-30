<?php
/**
 * Backend Logic untuk Index Page
 * File ini menangani semua logika backend untuk halaman index.php
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../config/auth.php';

if (isset($_SESSION['id_user']) && normalize_role($_SESSION['role'] ?? '') === 'admin') {
    redirect_to_role_home('admin');
}

// Fungsi untuk menampilkan pesan sukses menggunakan SweetAlert
function getSuccessAlert() {
    if (isset($_GET['success'])) {
        $successMessage = htmlspecialchars($_GET['success'], ENT_QUOTES, 'UTF-8');
        return "
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{$successMessage}',
                timer: 2000,
                showConfirmButton: false
            });
            if (window.history.replaceState) {
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        </script>
        ";
    }
    return '';
}
