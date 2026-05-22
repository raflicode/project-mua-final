<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yayuk Makeover - Laporan </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        
        /* Mengubah warna dasar body menjadi krem sangat muda sesuai gambar */
        body {
            background-color: #f9f6f0;
        }

        .main-content {
            margin-left: 260px; /* Samakan dengan lebar sidebar */
            min-height: 100vh;
        }

        /* --- GRADIENT WARNA COKELAT TUA SESUAI GAMBAR --- */
        .warnacustom {
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
        }

        /* --- CUSTOM BUTTON TEMA COKELAT --- */
        .btn-custom-cokelat {
            color: #513c2c;
            border-color: #513c2c;
            border-radius: 50rem;
        }
        .btn-custom-cokelat:hover {
            background-color: #513c2c;
            color: #ffffff;
            border-color: #513c2c;
        }

        .form-select-custom {
            border-radius: 50rem;
            border-color: #513c2c;
            color: #513c2c;
            background-color: #white;
        }

        /* --- KARTU STATISTIK DENGAN BORDER COKELAT & HIJAU DAUN --- */
        .card-stat {
            border: none;
            border-left: 5px solid;
            transition: transform 0.2s;
            background-color: #ffffff;
        }
        .card-stat:hover {
            transform: translateY(-5px);
        }
        .border-pendapatan { border-left-color: #513c2c; }
        .border-pesanan { border-left-color: #586842; } /* Hijau muted seperti badge lunas di gambar */
        .border-pending { border-left-color: #b58c63; } /* Cokelat muda moka */

        .text-cokelat-tua {
            color: #513c2c !important;
        }
        .bg-opacity-cokelat {
            background-color: rgba(81, 60, 44, 0.1) !important;
        }
        .bg-opacity-hijau {
            background-color: rgba(88, 104, 66, 0.1) !important;
        }
        .bg-opacity-moka {
            background-color: rgba(181, 140, 99, 0.1) !important;
        }
    </style>
</head>

<link href="../assets/admin-brown.css" rel="stylesheet">

<body>

<div class="d-flex">

    <?php include 'include/sidebar.php'; ?>

    <div class="flex-grow-1 p-4 main-content">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="input-group w-50"></div>

            <div class="d-flex align-items-center bg-white px-3 py-2 rounded-pill shadow-sm">
                <img src="https://ui-avatars.com/api/?name=Hotman+Paris&background=random" class="rounded-circle me-2" width="30">
                <div class="me-3 small">
                    <div class="fw-bold text-dark">Hotman Paris</div>
                    <div class="text-muted" style="font-size:12px;">Admin 1</div>
                </div>
                <i class="bi bi-chevron-down text-dark"></i>
            </div>
        </div>

        <h4 class="fw-bold text-primary mb-4">
            <i class="bi bi-cash-stack me-2"></i> Laporan
        </h4>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold warnacustom">
                <i class="bi bi-bar-chart-line-fill me-2"></i> Laporan & Analisis Bisnis
            </h4>

            <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold warnacustom">
        <i class="bi bi-bar-chart-line-fill me-2"></i> Laporan & Analisis Bisnis
    </h4>

    <div class="d-flex gap-2 align-items-center">
        <div class="position-relative">
            <input type="date" class="form-control form-select-custom shadow-sm" style="width: 220px;" value="2026-05-20">
        </div>

        <button class="btn btn-custom-cokelat shadow-sm ms-2">
            <i class="bi bi-download me-2"></i> Cetak PDF
        </button>
    </div>
</div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card card-stat border-pendapatan shadow-sm rounded-4 p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small fw-bold text-uppercase">Total Omzet (Lunas)</div>
                            <h3 class="fw-bold text-cokelat-tua my-1">Rp 11.600.000</h3>
                            <small class="fw-bold" style="color: #586842;"><i class="bi bi-arrow-up-short"></i> +12% Bulan ini</small>
                        </div>
                        <div class="bg-opacity-cokelat p-3 rounded-circle text-cokelat-tua">
                            <i class="bi bi-wallet2 fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-stat border-pesanan shadow-sm rounded-4 p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small fw-bold text-uppercase">Pesanan Selesai</div>
                            <h3 class="fw-bold my-1" style="color: #586842;">42 Pesanan</h3>
                            <small class="text-muted">Target kuota: 50</small>
                        </div>
                        <div class="bg-opacity-hijau p-3 rounded-circle" style="color: #586842;">
                            <i class="bi bi-bag-check fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-stat border-pending shadow-sm rounded-4 p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small fw-bold text-uppercase">Pending / DP Only</div>
                            <h3 class="fw-bold my-1" style="color: #b58c63;">Rp 3.700.000</h3>
                            <small class="fw-bold" style="color: #b58c63;">3 Belum melunasi</small>
                        </div>
                        <div class="bg-opacity-moka p-3 rounded-circle" style="color: #b58c63;">
                            <i class="bi bi-hourglass-split fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="card shadow-sm rounded-4 p-4 bg-white h-100">
                    <h5 class="fw-bold mb-3 text-dark">Grafik Pendapatan Bulanan</h5>
                    <div style="position: relative; height:300px;">
                        <canvas id="chartPendapatan"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm rounded-4 p-4 bg-white h-100">
                    <h5 class="fw-bold mb-3 text-dark">Kategori MUA Terlaris</h5>
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0">
                            <thead>
                                <tr class="text-muted small">
                                    <th>Kategori</th>
                                    <th class="text-end">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><i class="bi bi-circle-fill me-2 small" style="color: #513c2c;"></i> Makeup Artist</td>
                                    <td class="text-end fw-bold text-dark">18 kali</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-circle-fill me-2 small" style="color: #586842;"></i> Makeup Party</td>
                                    <td class="text-end fw-bold text-dark">12 kali</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-circle-fill me-2 small" style="color: #b58c63;"></i> Kostum / Sewa</td>
                                    <td class="text-end fw-bold text-dark">8 kali</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-circle-fill me-2 small text-danger"></i> Decoration</td>
                                    <td class="text-end fw-bold text-dark">4 kali</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const ctx = document.getElementById('chartPendapatan').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep'],
            datasets: [{
                label: 'Omzet Penjualan (Rupiah)',
                data: [3000000, 4500000, 2500000, 5000000, 7800000, 6000000, 8500000, 9000000, 11600000],
                // Menggunakan hex warna cokelat tua #513c2c dengan opasitas
                backgroundColor: 'rgba(81, 60, 44, 0.85)', 
                borderColor: '#513c2c',
                borderWidth: 1,
                borderRadius: 8 
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.04)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
</body>
</html>