<!-- Script untuk Add to Cart - Tambahkan di service.php atau halaman product lainnya -->
<script>
const addToCartBasePath = <?= json_encode(BASE_PATH); ?>;

function addToCartUrl(path) {
    return (addToCartBasePath || '') + '/' + path.replace(/^\/+/, '');
}

function addToCartCandidateUrls(path) {
    const cleanPath = path.replace(/^\/+/, '');
    return [...new Set([
        addToCartUrl(cleanPath),
        '../' + cleanPath,
        cleanPath
    ])];
}

function postAddToCart(formData) {
    const urls = addToCartCandidateUrls('actions/add_to_cart.php');
    let lastError = null;

    return urls.reduce((promise, url) => {
        return promise.catch(() => {
            return fetch(url, {
                method: 'POST',
                body: formData
            }).then(response => {
                return response.text().then(text => {
                    try {
                        return JSON.parse(text);
                    } catch (error) {
                        if (!response.ok) {
                            throw new Error('HTTP ' + response.status);
                        }
                        throw error;
                    }
                });
            }).catch(error => {
                lastError = error;
                throw error;
            });
        });
    }, Promise.reject()).catch(() => {
        throw lastError || new Error('Add to cart request failed');
    });
}

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
                window.location.href = addToCartUrl('public/login.php');
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

    postAddToCart(formData)
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
