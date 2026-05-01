<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Yayuk Makeover</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<!-- Chart JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    background:#f4f6f9;
    font-family:Arial, Helvetica, sans-serif;
}

/* Sidebar */
.sidebar{
    width:260px;
    height:100vh;
    position:fixed;
    background:linear-gradient(180deg,#4e73df,#224abe);
    color:white;
    padding-top:20px;
}

.sidebar h4{
    text-align:center;
    font-weight:bold;
    margin-bottom:30px;
}

.sidebar a{
    display:block;
    padding:14px 25px;
    color:white;
    text-decoration:none;
    transition:0.3s;
}

.sidebar a:hover,
.sidebar a.active{
    background:rgba(255,255,255,0.15);
    border-radius:10px;
}

/* Content */
.content{
    margin-left:270px;
    padding:25px;
}

/* Topbar */
.topbar{
    background:white;
    padding:15px 20px;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}

/* Welcome */
.welcome{
    background:linear-gradient(135deg,#1e5c93,#3c91e6);
    color:white;
    border-radius:15px;
    padding:25px;
}

/* Card */
.card-custom{
    border:none;
    border-radius:18px;
    box-shadow:0 8px 18px rgba(0,0,0,0.08);
}

/* Chart */
canvas{
    max-height:350px;
}
</style>
</head>

<body>

<!-- Sidebar -->


<?php include 'public/include/sidebar.php'; ?>

<!-- Content -->
<div class="content">

    <!-- Topbar -->
    <div class="topbar d-flex justify-content-between align-items-center mb-4">
        <input type="text" class="form-control w-50" placeholder="Search...">

        <div class="fw-bold">
            <i class="bi bi-person-circle fs-5"></i> Hotman Paris
        </div>
    </div>

    <!-- Welcome -->
    <div class="welcome mb-4">
        <h3>Hello, Hotman Paris 👋</h3> //
        <p class="mb-0">Selamat datang kembali di dashboard Yayuk Makeover.</p>
    </div>

    <!-- Statistik -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card card-custom p-4">
                <h6>Total Pesanan</h6>
                <h2>49</h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-custom p-4">
                <h6>Total Pengunjung</h6>
                <h2>177</h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-custom p-4">
                <h6>Pendapatan</h6>
                <h2>Rp 4.317.000</h2>
            </div>
        </div>
    </div>

    <!-- Chart -->
    <div class="row g-4">

        <!-- Multi Axis Chart -->
        <div class="col-lg-8">
            <div class="card card-custom p-4">
                <div class="d-flex justify-content-between mb-3">
                    <h5>Grafik Booking & Pendapatan</h5>
                    <button class="btn btn-primary btn-sm" onclick="randomizeData()">
                        Randomize
                    </button>
                </div>
                <canvas id="multiAxisChart"></canvas>
            </div>
        </div>

        <!-- Doughnut -->
        <div class="col-lg-4">
            <div class="card card-custom p-4">
                <h5 class="mb-3">Jenis Booking</h5>
                <canvas id="pieChart"></canvas>
            </div>
        </div>

    </div>

</div>

<script>
/* ========= MULTI AXIS CHART ========= */

const labels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul'];

const data = {
    labels: labels,
    datasets: [
        {
            label: 'Booking',
            data: [10, 25, 15, 35, 28, 40, 32],
            borderColor: 'red',
            backgroundColor: 'rgba(255,0,0,0.3)',
            tension: 0.4,
            yAxisID: 'y'
        },
        {
            label: 'Pendapatan (Juta)',
            data: [4, 6, 5, 8, 7, 10, 9],
            borderColor: 'blue',
            backgroundColor: 'rgba(0,0,255,0.3)',
            tension: 0.4,
            yAxisID: 'y1'
        }
    ]
};

const config = {
    type: 'line',
    data: data,
    options: {
        responsive: true,
        interaction: {
            mode: 'index',
            intersect: false
        },
        stacked: false,
        plugins: {
            title: {
                display: true,
                text: 'Chart.js Line Chart - Multi Axis'
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
};

const myChart = new Chart(
    document.getElementById('multiAxisChart'),
    config
);

/* Randomize Button */
function randomizeData(){
    myChart.data.datasets.forEach(dataset => {
        dataset.data = dataset.data.map(() =>
            Math.floor(Math.random() * 100)
        );
    });
    myChart.update();
}

/* ========= PIE CHART ========= */

new Chart(document.getElementById("pieChart"), {
    type: 'doughnut',
    data: {
        labels: ['Makeup Wedding','Dekor','Kostum'],
        datasets: [{
            data: [40,35,25],
            backgroundColor:[
                '#4e73df',
                '#1cc88a',
                '#f6c23e'
            ]
        }]
    },
    options:{
        responsive:true
    }
});
</script>

</body>
</html>