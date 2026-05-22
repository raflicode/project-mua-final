<?php
require_once __DIR__ . '/../../config/auth.php';
require_login(['admin']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Yayuk Makeover</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background: #fdfbf7; /* Diubah ke warna cream lembut */
    font-family: Arial, Helvetica, sans-serif;
}

/* ===== SIDEBAR ===== */
.sidebar {
    width: 260px;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    background: linear-gradient(180deg, #5c4033, #3d2b1f); /* Cokelat Gelap Mewah */
    color: white;
    display: flex;
    flex-direction: column;
    z-index: 100;
    overflow-y: auto;
}

.sidebar-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 20px 25px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    margin-bottom: 10px;
}

.sidebar-brand .brand-icon {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: rgba(212, 175, 55, 0.3); /* Sentuhan Gold */
    border: 1px solid #d4af37;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: #d4af37;
    flex-shrink: 0;
}

.sidebar-brand h5 {
    font-weight: bold;
    font-size: 15px;
    margin: 0;
    line-height: 1.3;
}

.sidebar-brand small {
    font-size: 11px;
    opacity: 0.75;
    display: block;
}

.sidebar-section {
    padding: 6px 20px;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 1px;
    opacity: 0.55;
    font-weight: bold;
    margin-top: 10px;
}

.sidebar a {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 25px;
    color: rgba(255,255,255,0.8);
    text-decoration: none;
    font-size: 14px;
    transition: background 0.2s, color 0.2s;
    border-radius: 0;
}

.sidebar a i {
    font-size: 17px;
    width: 20px;
    flex-shrink: 0;
}

.sidebar a:hover,
.sidebar a.active {
    background: rgba(212, 175, 55, 0.2); /* Hover kecokelatan/emas */
    color: #ffd700;
    border-radius: 10px;
    margin: 0 10px;
    padding: 12px 15px;
}

.sidebar-footer {
    margin-top: auto;
    padding: 15px 25px;
    border-top: 1px solid rgba(255,255,255,0.1);
    font-size: 12px;
    opacity: 0.5;
    text-align: center;
}

/* ===== CONTENT ===== */
.content {
    margin-left: 260px;
    padding: 25px;
    min-height: 100vh;
}

/* ===== TOPBAR ===== */
.topbar {
    background: white;
    padding: 15px 20px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(92, 64, 51, 0.05);
    border: 1px solid #f0e6df;
}

.topbar .form-control:focus {
    border-color: #8b5a2b;
    box-shadow: 0 0 0 0.25px rgba(139, 90, 43, 0.25);
}

/* ===== WELCOME ===== */
.welcome {
    background: linear-gradient(135deg, #8b5a2b, #b8860b); /* Gradasi Cokelat Hangat ke Emas Tua */
    color: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 5px 15px rgba(139, 90, 43, 0.15);
}

/* ===== CARD ===== */
.card-custom {
    border: 1px solid #f0e6df;
    border-radius: 18px;
    box-shadow: 0 8px 18px rgba(92, 64, 51, 0.04);
    background: #ffffff;
}

.btn-brown {
    background-color: #8b5a2b;
    border-color: #8b5a2b;
    color: #fff;
}

.btn-brown:hover {
    background-color: #6f4721;
    border-color: #6f4721;
    color: #fff;
}

canvas {
    max-height: 350px;
}
</style>
</head>

<body>

<?php
$page = 'dashboard';
include 'include/sidebar.php';
?>

<!-- ===== CONTENT ===== -->
<div class="content">

    <!-- Topbar -->
    <div class="topbar d-flex justify-content-between align-items-center mb-4">
        <input type="text" class="form-control w-50" placeholder="Search...">
        <div class="fw-bold" style="color: #5c4033;">
            <i class="bi bi-person-circle fs-5 me-1"></i> Yayuk MakeOver
        </div>
    </div>

    <!-- Welcome -->
    <div class="welcome mb-4">
        <h3>Hello, Yayuk MakeOver</h3>
        <p class="mb-0">Selamat datang kembali di dashboard Yayuk Makeover.</p>
    </div>

    <!-- Chart -->
    <div class="row g-4">

        <!-- Multi Axis Chart -->
        <div class="col-lg-8">
            <div class="card card-custom p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0" style="color: #5c4033;">Grafik Booking &amp; Pendapatan</h5>
                    <button class="btn btn-brown btn-sm" onclick="randomizeData()">
                        Randomize
                    </button>
                </div>
                <canvas id="multiAxisChart"></canvas>
            </div>
        </div>

        <!-- Doughnut -->
        <div class="col-lg-4">
            <div class="card card-custom p-4">
                <h5 class="mb-3" style="color: #5c4033;">Jenis Booking</h5>
                <canvas id="pieChart"></canvas>
            </div>
        </div>

    </div>

</div>

<script>
/* ========= MULTI AXIS CHART ========= */

const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul'];

const chartData = {
    labels: labels,
    datasets: [
        {
            label: 'Booking',
            data: [10, 25, 15, 35, 28, 40, 32],
            borderColor: '#a0522d', /* Sienna / Cokelat Terrakota */
            backgroundColor: 'rgba(160, 82, 45, 0.2)',
            tension: 0.4,
            yAxisID: 'y'
        },
        {
            label: 'Pendapatan (Juta)',
            data: [4, 6, 5, 8, 7, 10, 9],
            borderColor: '#cd853f', /* Peru / Cokelat Muda Keemasan */
            backgroundColor: 'rgba(205, 133, 63, 0.2)',
            tension: 0.4,
            yAxisID: 'y1'
        }
    ]
};

const myChart = new Chart(document.getElementById('multiAxisChart'), {
    type: 'line',
    data: chartData,
    options: {
        responsive: true,
        interaction: {
            mode: 'index',
            intersect: false
        },
        stacked: false,
        plugins: {
            title: {
                display: false
            }
        },
        scales: {
            y: {
                type: 'linear',
                display: true,
                position: 'left'
            },
            y1: {
                type: 'linear',
                display: true,
                position: 'right',
                grid: {
                    drawOnChartArea: false
                }
            }
        }
    }
});

function randomizeData() {
    myChart.data.datasets.forEach(function(dataset) {
        dataset.data = dataset.data.map(function() {
            return Math.floor(Math.random() * 100);
        });
    });
    myChart.update();
}

/* ========= PIE CHART ========= */

new Chart(document.getElementById('pieChart'), {
    type: 'doughnut',
    data: {
        labels: ['Makeup Wedding', 'Dekor', 'Kostum'],
        datasets: [{
            data: [40, 35, 25],
            backgroundColor: ['#5c4033', '#8b5a2b', '#d4af37'] /* Deep Brown, Warm Brown, Gold */
        }]
    },
    options: {
        responsive: true
    }
});
</script>

</body>
</html>
