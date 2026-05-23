<!-- Script untuk Add to Cart - Tambahkan di service.php atau halaman product lainnya -->
<script>
function addToCart(namaLayanan, tipeLayanan, harga, foto = null, idLayanan = null) {
    // Check if user is logged in
    if (!<?= isset($_SESSION['id_user']) ? 'true' : 'false' ?>) {
        Swal.fire({
            icon: 'warning',
            title: 'Login Diperlukan',
            text: 'Silakan login terlebih dahulu untuk menambahkan item ke keranjang',
            confirmButtonText: 'Login Sekarang',
            showCancelButton: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/project-mua-final/public/login.php';
            }
        });
        return;
    }

    const formData = new FormData();
    formData.append('nama_layanan', namaLayanan);
    formData.append('tipe_layanan', tipeLayanan);
    if (idLayanan) {
        formData.append('id_layanan', idLayanan);
    }
    if (foto) {
        formData.append('foto', foto);
    }
    formData.append('harga', harga);
    formData.append('kuantitas', 1);

    fetch('/project-mua-final/actions/add_to_cart.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: data.message,
                showConfirmButton: false,
                timer: 1500
            });
            
            // Update cart count di navbar
            if (typeof window.setCartBadgeCount === 'function') {
                window.setCartBadgeCount(data.cart_count);
            }

            if (typeof window.updateCartNavbar === 'function') {
                window.updateCartNavbar();
            } else if (typeof updateCartCount === 'function') {
                updateCartCount();
            }
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: data.message
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan',
            text: 'Tidak dapat menambahkan item ke keranjang'
        });
    });
}
</script>
