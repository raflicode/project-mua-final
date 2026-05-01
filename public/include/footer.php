<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>

<footer class="py-4 border-top">
    
    <!-- 🔥 MAP DI SINI -->
    <div id="map" style="height:200px; margin-bottom:20px;"></div>

    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
        <p class="text-muted small mb-0">&copy; not found 2026</p>
        <div class="social-icons">
            <a href="#" class="text-muted me-3"><i class="bi bi-facebook"></i></a>
            <a href="#" class="text-muted me-3"><i class="bi bi-instagram"></i></a>
            <a href="#" class="text-muted"><i class="bi bi-twitter-x"></i></a>
        </div>
    </div>
</footer>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
  var lat = <?= $lat ?>;
  var lng = <?= $lng ?>;

  var map = L.map('map').setView([lat, lng], 13);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap'
  }).addTo(map);

  L.marker([lat, lng]).addTo(map)
    .bindPopup("Lokasi 😎")
    .openPopup();
</script>