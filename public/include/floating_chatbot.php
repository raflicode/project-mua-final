<?php
$fcwUserName = trim((string) ($_SESSION['full_name'] ?? $_SESSION['username'] ?? ''));
$fcwUserName = $fcwUserName !== '' ? $fcwUserName : 'Kak';
$fcwEndpoint = (defined('BASE_PATH') ? BASE_PATH : '') . '/actions/fcw_data.php';
$fcwPublicBase = (defined('BASE_PATH') ? BASE_PATH : '') . '/public';
?>
<style>
    .fcw-root {
        position: fixed;
        right: 22px;
        bottom: 22px;
        z-index: 1055;
        font-family: 'Poppins', Arial, sans-serif;
    }

    .fcw-toggle {
        width: 58px;
        height: 58px;
        border: 0;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #a58459;
        color: #fff;
        box-shadow: 0 14px 34px rgba(59, 48, 40, 0.28);
        font-size: 1.5rem;
    }

    .fcw-panel {
        position: absolute;
        right: 0;
        bottom: 76px;
        width: min(360px, calc(100vw - 32px));
        max-height: min(620px, calc(100vh - 120px));
        display: none;
        overflow: hidden;
        border: 1px solid rgba(165, 132, 89, 0.22);
        border-radius: 18px;
        background: #fffaf4;
        box-shadow: 0 22px 54px rgba(59, 48, 40, 0.2);
    }

    .fcw-root.is-open .fcw-panel {
        display: block;
    }

    .fcw-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 15px 16px;
        background: #7b5d3f;
        color: #fff;
    }

    .fcw-title {
        margin: 0;
        font-size: 0.98rem;
        font-weight: 700;
        color: #fff;
    }

    .fcw-close {
        width: 34px;
        height: 34px;
        border: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.14);
        color: #fff;
    }

    .fcw-body {
        max-height: calc(min(620px, 100vh - 120px) - 64px);
        overflow: auto;
        padding: 16px;
    }

    .fcw-message {
        margin-bottom: 14px;
        padding: 13px 14px;
        border-radius: 14px;
        background: #ffffff;
        color: #3b3028;
        border: 1px solid rgba(165, 132, 89, 0.16);
        line-height: 1.55;
        font-size: 0.9rem;
    }

    .fcw-menu {
        display: grid;
        gap: 8px;
    }

    .fcw-option {
        width: 100%;
        border: 1px solid rgba(165, 132, 89, 0.22);
        border-radius: 12px;
        padding: 10px 12px;
        background: #fff;
        color: #3b3028;
        text-align: left;
        font-weight: 600;
        font-size: 0.88rem;
    }

    .fcw-option:hover {
        border-color: #a58459;
        background: #fff3df;
    }

    .fcw-back {
        margin-top: 10px;
        color: #7b5d3f;
        background: transparent;
    }

    .fcw-small {
        margin: 8px 0 0;
        color: #7b6b5d;
        font-size: 0.78rem;
    }

    @media (max-width: 576px) {
        .fcw-root {
            right: 16px;
            bottom: 16px;
        }
    }
</style>

<div class="fcw-root" id="fcwRoot" data-endpoint="<?= htmlspecialchars($fcwEndpoint, ENT_QUOTES, 'UTF-8'); ?>" data-public-base="<?= htmlspecialchars($fcwPublicBase, ENT_QUOTES, 'UTF-8'); ?>" data-user="<?= htmlspecialchars($fcwUserName, ENT_QUOTES, 'UTF-8'); ?>">
    <div class="fcw-panel" role="dialog" aria-label="Chatbot Yayuk Makeover">
        <div class="fcw-header">
            <h2 class="fcw-title">Yayuk Assistant</h2>
            <button type="button" class="fcw-close" id="fcwClose" aria-label="Tutup"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="fcw-body" id="fcwBody"></div>
    </div>
    <button type="button" class="fcw-toggle" id="fcwToggle" aria-label="Buka chatbot"><i class="bi bi-chat-dots-fill"></i></button>
</div>

<script>
(function () {
    const root = document.getElementById('fcwRoot');
    if (!root) return;

    const endpoint = root.dataset.endpoint;
    const publicBase = (root.dataset.publicBase || '').replace(/\/+$/, '');
    const userName = root.dataset.user || 'Kak';
    const body = document.getElementById('fcwBody');
    const menus = [
        ['packages', 'Lihat Paket'],
        ['booking', 'Cara Booking'],
        ['more', 'Lainnya']
    ];

    function rupiah(value) {
        return 'Rp ' + Number(value || 0).toLocaleString('id-ID');
    }

    function escapeHtml(value) {
        return String(value ?? '').replace(/[&<>"']/g, function (char) {
            return ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[char];
        });
    }

    function publicUrl(path) {
        return publicBase + '/' + String(path || '').replace(/^\/+/, '');
    }

    function menuHtml() {
        return '<div class="fcw-menu">' + menus.map(function (item, index) {
            return '<button type="button" class="fcw-option" data-fcw-action="' + item[0] + '">' + (index + 1) + '. ' + item[1] + '</button>';
        }).join('') + '</div>';
    }

    function renderHome() {
        body.innerHTML =
            '<div class="fcw-message">Halo ' + escapeHtml(userName) + ' 👋<br>Selamat datang di Kami Yayuk Makeover.<br>Ada yang bisa saya bantu?</div>' +
            menuHtml();
    }

    function renderLoading() {
        body.innerHTML = '<div class="fcw-message">Sebentar ya, saya cek data terbaru...</div>';
    }

    function renderBack() {
        return '<button type="button" class="fcw-option fcw-back" data-fcw-action="home">Kembali ke menu</button>';
    }

    function showPackagesMenu() {
        body.innerHTML =
            '<div class="fcw-message">Pilih kategori paket yang ingin dilihat:</div>' +
            '<div class="fcw-menu">' +
            '<button type="button" class="fcw-option" data-fcw-action="pkg-makeup">1. Makeup</button>' +
            '<button type="button" class="fcw-option" data-fcw-action="pkg-kostum">2. Kostum</button>' +
            '<button type="button" class="fcw-option" data-fcw-action="pkg-dekor">3. Dekor</button>' +
            '<button type="button" class="fcw-option" data-fcw-action="pkg-wedding-silver">4. Paket Wedding - Silver</button>' +
            '<button type="button" class="fcw-option" data-fcw-action="pkg-wedding-gold">5. Paket Wedding - Gold</button>' +
            '</div>' + renderBack();
    }

    function showWeddingPackage(kind) {
        // Try to fetch from backend; if not available, show fallback information and link
        renderLoading();
        fetch(endpoint + '?action=package&type=' + encodeURIComponent(kind)).then(function (res) {
            return res.json().catch(function () { return null; });
        }).then(function (data) {
            if (data && Array.isArray(data.items) && data.items.length) {
                const rows = data.items.map(function (item) {
                    return '<button type="button" class="fcw-option">' + escapeHtml(item.nama || item.title || '') + '<br><strong>' + escapeHtml(item.harga || item.price || '') + '</strong></button>';
                }).join('');
                body.innerHTML = '<div class="fcw-message">Paket ' + escapeHtml(kind) + ' tersedia:</div>' + rows + renderBack();
                return;
            }
            // Fallback static info
            const title = kind === 'silver' ? 'Paket Wedding - Silver' : 'Paket Wedding - Gold';
            body.innerHTML = '<div class="fcw-message"><strong>' + escapeHtml(title) + '</strong><br>Silakan buka halaman layanan untuk melihat detail paket atau langsung lakukan booking. Untuk melihat layanan, klik tombol di bawah.</div>' +
                '<div class="fcw-menu">' +
                '<a class="fcw-option" href="' + publicUrl('service.php') + '">Lihat Layanan</a>' +
                '<a class="fcw-option" href="' + publicUrl('booking.php?from=service') + '">Mulai Booking</a>' +
                '</div>' + renderBack();
        }).catch(function () {
            body.innerHTML = '<div class="fcw-message">Maaf, data paket wedding belum bisa dimuat saat ini.</div>' + renderBack();
        });
    }

    function showMoreMenu() {
        body.innerHTML =
            '<div class="fcw-message">Pilihan lainnya:</div>' +
            '<div class="fcw-menu">' +
            '<button type="button" class="fcw-option" data-fcw-action="schedule">Cek Ketersediaan Jadwal</button>' +
            '<button type="button" class="fcw-option" data-fcw-action="estimate">Estimasi Harga</button>' +
            '<a class="fcw-option" href="' + publicUrl('service.php') + '">Lihat Layanan & Kontak</a>' +
            '</div>' + renderBack();
    }

    function fetchJson(url) {
        return fetch(url, { headers: { 'Accept': 'application/json' } }).then(function (res) { return res.json(); });
    }

    function showSchedule() {
        renderLoading();
        fetchJson(endpoint + '?action=schedule').then(function (data) {
            const rows = (data.schedule || []).map(function (slot) {
                const jam = slot.jam && slot.jam.length ? '<br><span class="fcw-small">Jam tersedia: ' + slot.jam.map(escapeHtml).join(', ') + '</span>' : '<br><span class="fcw-small">Jam dapat dipilih saat booking.</span>';
                return '<button type="button" class="fcw-option">' + escapeHtml(slot.label) + ' - sisa ' + escapeHtml(slot.sisa_slot) + ' slot' + jam + '</button>';
            }).join('');
            body.innerHTML = '<div class="fcw-message">Berikut jadwal yang masih tersedia berdasarkan slot limiter.</div>' + (rows || '<div class="fcw-message">Belum ada slot tersedia dalam 30 hari ke depan.</div>') + renderBack();
        }).catch(function () {
            body.innerHTML = '<div class="fcw-message">Maaf, data jadwal belum bisa dimuat.</div>' + renderBack();
        });
    }

    function showCategory(category, title) {
        renderLoading();
        fetchJson(endpoint + '?action=category&category=' + encodeURIComponent(category)).then(function (data) {
            const rows = (data.items || []).map(function (item) {
                const includes = item.include && item.include.length ? '<div class="fcw-small">' + item.include.map(escapeHtml).join(', ') + '</div>' : '';
                return '<button type="button" class="fcw-option">' + escapeHtml(item.nama) + '<br><strong>' + escapeHtml(item.harga) + '</strong>' + includes + '</button>';
            }).join('');
            body.innerHTML = '<div class="fcw-message">' + escapeHtml(title) + ' aktif saat ini:</div>' + (rows || '<div class="fcw-message">Belum ada paket aktif untuk kategori ini.</div>') + renderBack();
        }).catch(function () {
            body.innerHTML = '<div class="fcw-message">Maaf, data paket belum bisa dimuat.</div>' + renderBack();
        });
    }

    function showEstimate() {
        body.innerHTML =
            '<div class="fcw-message">Pilih kategori layanan untuk melihat estimasi harga dari data paket aktif.</div>' +
            '<div class="fcw-menu">' +
            '<button type="button" class="fcw-option" data-fcw-action="estimate-makeup">Makeup</button>' +
            '<button type="button" class="fcw-option" data-fcw-action="estimate-kostum">Kostum</button>' +
            '<button type="button" class="fcw-option" data-fcw-action="estimate-dekor">Dekorasi</button>' +
            '<button type="button" class="fcw-option" data-fcw-action="estimate-paket">Paket Wedding</button>' +
            '</div>' + renderBack();
    }

    function showEstimateCategory(category) {
        renderLoading();
        fetchJson(endpoint + '?action=category&category=' + encodeURIComponent(category)).then(function (data) {
            const items = data.items || [];
            if (!items.length) {
                body.innerHTML = '<div class="fcw-message">Belum ada data harga aktif untuk kategori ini.</div>' + renderBack();
                return;
            }
            const prices = items.map(function (item) { return Number(item.harga_value || 0); }).filter(Boolean);
            const min = Math.min.apply(Math, prices);
            const max = Math.max.apply(Math, prices);
            const rows = items.slice(0, 6).map(function (item) {
                return '<button type="button" class="fcw-option">' + escapeHtml(item.nama) + '<br><strong>Estimasi: ' + escapeHtml(item.harga || rupiah(item.harga_value)) + '</strong></button>';
            }).join('');
            const range = prices.length ? 'Rentang estimasi: <strong>' + rupiah(min) + (max > min ? ' - ' + rupiah(max) : '') + '</strong>.' : 'Harga belum tersedia.';
            body.innerHTML = '<div class="fcw-message">' + range + '<br><span class="fcw-small">Estimasi dapat berubah sesuai pilihan paket dan kebutuhan acara.</span></div>' + rows + renderBack();
        }).catch(function () {
            body.innerHTML = '<div class="fcw-message">Maaf, estimasi belum bisa dimuat.</div>' + renderBack();
        });
    }

    function showBookingGuide() {
        body.innerHTML =
            '<div class="fcw-message"><strong>Cara Booking (alur)</strong><br>' +
            '1. Pastikan Anda sudah login (bila belum, buka halaman Login).<br>' +
            '2. Pilih layanan atau paket di halaman layanan atau gunakan menu <em>Lihat Paket</em> di chat ini.<br>' +
            '3. Setelah memilih layanan, klik tombol Booking untuk masuk ke halaman Review Pesanan.<br>' +
            '4. Jika belum memilih jadwal, klik <em>Cek Ketersediaan Jadwal</em> dan pilih tanggal + jam yang tersedia.<br>' +
            '5. Setelah jadwal dipilih, lanjutkan ke <em>Isi Data Diri</em> untuk memasukkan nama, nomor HP, alamat, dan catatan.<br>' +
            '6. Konfirmasi ketersediaan; admin akan memberikan instruksi pembayaran atau link pembayaran pada riwayat pesanan Anda.<br>' +
            '7. Cek halaman Riwayat Pesanan untuk melihat status booking dan informasi pembayaran.</div>' +
            renderBack();
    }

    function openChat() {
        root.classList.add('is-open');
        document.getElementById('fcwToggle').setAttribute('aria-label', 'Tutup chatbot');
        renderHome();
    }

    function closeChat() {
        root.classList.remove('is-open');
        document.getElementById('fcwToggle').setAttribute('aria-label', 'Buka chatbot');
    }

    document.getElementById('fcwToggle').addEventListener('click', function () {
        if (root.classList.contains('is-open')) {
            closeChat();
            return;
        }

        openChat();
    });

    document.getElementById('fcwClose').addEventListener('click', function () {
        closeChat();
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeChat();
        }
    });

    document.addEventListener('mousedown', function (event) {
        if (root.classList.contains('is-open') && !root.contains(event.target)) {
            closeChat();
        }
    });

    body.addEventListener('click', function (event) {
        const button = event.target.closest('[data-fcw-action]');
        if (!button) return;
        const action = button.dataset.fcwAction;
        if (action === 'home') renderHome();
        if (action === 'packages') showPackagesMenu();
        if (action === 'pkg-makeup') showCategory('makeup', 'Paket makeup');
        if (action === 'pkg-kostum') showCategory('kostum', 'Paket kostum');
        if (action === 'pkg-dekor') showCategory('dekor', 'Paket dekorasi');
        if (action === 'pkg-wedding-silver') showWeddingPackage('silver');
        if (action === 'pkg-wedding-gold') showWeddingPackage('gold');
        if (action === 'schedule') showSchedule();
        if (action === 'estimate') showEstimate();
        if (action === 'estimate-makeup') showEstimateCategory('makeup');
        if (action === 'estimate-kostum') showEstimateCategory('kostum');
        if (action === 'estimate-dekor') showEstimateCategory('dekor');
        if (action === 'estimate-paket') showEstimateCategory('paket');
        if (action === 'booking') showBookingGuide();
        if (action === 'more') showMoreMenu();
    });
})();
</script>
