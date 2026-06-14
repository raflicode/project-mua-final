<!-- Load Leaflet CSS & Font (Jika belum ada di header) -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,600;1,400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    body { font-family: 'Poppins', sans-serif; margin: 0; }
    
    /* Peta Full Width tanpa radius */
    #map-yayuk { 
        height: 300px; 
        width: 100%; 
        border: none;
    }

    /* Footer Styling sesuai Gambar 2 */
    .custom-footer {
        background:
            linear-gradient(135deg, rgba(123, 93, 63, 0.98), rgba(165, 132, 89, 0.96)),
            #A58459;
        color: white;
        padding: 60px 0 20px 0;
    }

    .footer-column h5 {
        font-weight: 600;
        margin-bottom: 25px;
    }

    .brand-footer {
        font-family: 'Playfair Display', serif;
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 20px;
    }

    .brand-footer span {
        color: #FED03A;
        font-style: italic;
        font-weight: 300;
    }

    .footer-text {
        font-size: 14px;
        line-height: 1.8;
        opacity: 0.9;
        margin-bottom: 25px;
    }

    .footer-link-list {
        list-style: none;
        padding: 0;
    }

    .footer-link-list li {
        margin-bottom: 10px;
        font-size: 14px;
        opacity: 0.9;
    }

    .contact-info {
        font-size: 14px;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .social-icons {
        display: flex;
        gap: 20px;
        font-size: 20px;
        margin-top: 20px;
    }

    .social-icons a { color: white; text-decoration: none; }
    .social-icons a:hover { color: #FED03A; transform: translateY(-2px); }

    .footer-bottom {
        border-top: 1px solid rgba(255,255,255,0.2);
        margin-top: 40px;
        padding-top: 20px;
        font-size: 12px;
        opacity: 0.7;
    }
</style>

<!-- Peta Full Width -->
<div id="map-yayuk"></div>

<!-- Footer 3 Kolom -->
<footer class="custom-footer">
    <div class="container">
        <div class="row">
            <!-- Kolom 1: About -->
            <div class="col-md-5 footer-column">
                <div class="brand-footer">Yayuk <span>Makeover</span></div>
                <p class="footer-text">
                    Kami adalah tim profesional yang siap mengabadikan momen terindah dalam hidup Anda.
                </p>
                <div class="contact-info">
                    <i class="bi bi-telephone-fill"></i> +62 813-3327-3119
                </div>
                <div class="contact-info">
                    <i class="bi bi-envelope-fill"></i> Yayuk@gmail.com
                </div>
            </div>

            <!-- Kolom 2: Layanan -->
            <div class="col-md-3 footer-column">
                <h5>Layanan Kami</h5>
                <ul class="footer-link-list">
                    <li><a href="public/makeup.php" style="color: white; text-decoration: none;">Makeup</a></li>
                    <li><a href="public/kostum.php" style="color: white; text-decoration: none;">Kostum</a></li>
                    <li><a href="public/dekor.php" style="color: white; text-decoration: none;">Dekor</a></li>
                </ul>
            </div>

            <!-- Kolom 3: Tautan Cepat -->
            <div class="col-md-4 footer-column">
                <h5>Tautan Cepat</h5>
                <ul class="footer-link-list">
                    <li><a href="public/gallery_makeup.php" style="color: white; text-decoration: none;">Gallery Makeup</a></li>
                    <li><a href="public/gallery_kostum.php" style="color: white; text-decoration: none;">Gallery Kostum</a></li>
                    <li><a href="public/gallery_dekor.php" style="color: white; text-decoration: none;">Gallery Dekor</a></li>
                </ul>
                <div class="social-icons">
                    <a href="https://www.facebook.com/yayux.ernawati" target="_blank"><i class="bi bi-facebook"></i></a>
                    <a href="https://www.instagram.com/yayukmakeover_jbr?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==w" target="_blank"><i class="bi bi-instagram"></i></a>
                </div>
            </div>
        </div>

        <!-- Bagian Alamat Dinamis dari API -->
        <div class="row mt-4">
            <div class="col-12">
                <p style="font-size: 13px; opacity: 0.8;">
                    <span id="alamat-api">Mengambil alamat...</span>
                </p>
            </div>
        </div>

        <div class="footer-bottom text-center">
            &copy; Not Found 2026
        </div>
    </div>
</footer>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const lat = -8.2036168;
    const lon = 113.6979823;
    
    // Link Google Maps Berdasarkan Koordinat
    const gMapsUrl = `https://www.google.com/maps?q=${lat},${lon}`;

    // Inisialisasi Peta
    var map = L.map('map-yayuk', { 
        scrollWheelZoom: false 
    }).setView([lat, lon], 17);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    // Tambahkan Marker yang bisa diklik
    var marker = L.marker([lat, lon]).addTo(map);

    // Buat Popup dengan Tombol "Buka di Google Maps"
    const popupContent = `
        <div style="text-align: center;">
            <b style="font-size: 14px;">Yayuk Makeover</b><br>
            <p style="margin: 5px 0; font-size: 12px;">Klik tombol di bawah untuk navigasi</p>
            <a href="${gMapsUrl}" target="_blank" 
               style="display: inline-block; background-color: #4285F4; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none; font-weight: bold; margin-top: 5px;">
               <i class="bi bi-google"></i> Buka Google Maps
            </a>
        </div>
    `;

    marker.bindPopup(popupContent);

    // Buka Google Maps langsung saat marker diklik
    marker.on('click', function() {
        window.open(gMapsUrl, '_blank');
    });

    // API Nominatim untuk Teks Alamat (Tetap Ada)
    fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lon}&format=json`, {
        headers: { 'User-Agent': 'YayukMakeoverApp/1.0' }
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById('alamat-api').innerHTML = `
            <a href="${gMapsUrl}" target="_blank" style="color: white; text-decoration: none;">
                <i class="bi bi-geo-alt-fill"></i> ${data.display_name}
            </a>
        `;
        setTimeout(() => { map.invalidateSize(); }, 500);
    })
    .catch(() => {
        document.getElementById('alamat-api').innerHTML = `
            <a href="${gMapsUrl}" target="_blank" style="color: white; text-decoration: none;">
                <i class="bi bi-geo-alt-fill"></i> Yayuk Makeover
            </a>
        `;
        setTimeout(() => { map.invalidateSize(); }, 500);
    });
</script>
