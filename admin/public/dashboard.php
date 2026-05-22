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
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link href="../assets/admin-brown.css" rel="stylesheet">
<link href="../assets/admin-layout.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
.welcome {
    background: linear-gradient(135deg, var(--brown-dark), var(--brown));
    color: var(--cream);
    border-radius: 20px;
    padding: 25px;
    box-shadow: 0 5px 15px rgba(139, 90, 43, 0.15);
}

.card-custom {
    padding: 24px;
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

<div class="main">
    <?php
    $page_title = 'Dashboard';
    $breadcrumb = 'Admin / Dashboard';
    include 'include/header.php';
    ?>

    <div class="content">

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
