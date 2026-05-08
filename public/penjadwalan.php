<?php
// penjadwalan.php
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Booking MUA Yayuk</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            /* Background diubah menjadi putih */
            background: #ffffff;
            font-family: Arial, Helvetica, sans-serif;
        }

        .wrapper {
            max-width: 420px;
            margin: auto;
        }

        .card-custom {
            /* Menambahkan border halus agar kartu tetap terlihat di background putih */
            border: 1px solid #f0f0f0; 
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
        }

        .header-booking {
            background: #f1c40f;
            padding: 18px;
            text-align: center;
            font-weight: bold;
            font-size: 18px;
        }

        .calendar-header {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 10px 15px;
        }

        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 8px;
        }

        .tgl {
            border: none;
            background: #f1f1f1;
            padding: 10px 0;
            border-radius: 8px;
            font-size: 14px;
            transition: 0.2s;
        }

        .tgl:hover,
        .tgl.active {
            background: #f1c40f;
        }

        .slot {
            background: #f8f9fa;
            border: 1px solid #eee;
            padding: 14px;
            border-radius: 10px;
            cursor: pointer;
            margin-bottom: 10px;
            transition: 0.2s;
        }

        .slot.selected {
            background: #f1c40f;
            border-color: #f1c40f;
            font-weight: bold;
        }

        .btn-lanjut {
            background: #5b7bd5;
            border: none;
            padding: 14px;
            font-weight: bold;
            border-radius: 10px;
        }

        .btn-lanjut:hover {
            background: #4568c7;
        }
    </style>
</head>

<body>

<!-- Bagian include navbar telah dihapus untuk menghilangkan menu samping -->

<div class="container py-5 wrapper">

    <div class="card card-custom">

        <div class="header-booking">
            Pilih Ketersediaan Tanggal
        </div>

        <div class="card-body">

            <!-- Header Bulan -->
            <div class="calendar-header d-flex justify-content-between align-items-center mb-3">
                <button class="btn btn-sm btn-outline-dark" onclick="prevMonth()">❮</button>
                <span class="fw-semibold" id="bulanTahun"></span>
                <button class="btn btn-sm btn-outline-dark" onclick="nextMonth()">❯</button>
            </div>

            <!-- Kalender -->
            <div class="calendar mb-4" id="calendar"></div>

            <!-- Slot -->
            <div id="slotArea" style="display:none;">

                <h5 class="mb-3 fw-bold">Pilih Slot Waktu</h5>

                <div class="slot" onclick="pilihSlot(this)">
                    Pagi (07:00 - 10:00)
                </div>

                <div class="slot" onclick="pilihSlot(this)">
                    Siang (11:00 - 13:00)
                </div>

                <div class="slot" onclick="pilihSlot(this)">
                    Sore (15:00 - 18:00)
                </div>

                <a href="pembayaran.php" class="btn btn-primary btn-lanjut w-100 mt-3">
                    LANJUTKAN BOOKING →
                </a>

            </div>

        </div>
    </div>

</div>

<script>
let date = new Date();

// Render Kalender
function renderCalendar() {
    const calendar = document.getElementById("calendar");
    calendar.innerHTML = "";

    const year = date.getFullYear();
    const month = date.getMonth();

    const bulanNama = [
        "Januari","Februari","Maret","April","Mei","Juni",
        "Juli","Agustus","September","Oktober","November","Desember"
    ];

    document.getElementById("bulanTahun").innerText =
        bulanNama[month] + " " + year;

    const firstDay = new Date(year, month, 1).getDay();
    const totalDays = new Date(year, month + 1, 0).getDate();

    for (let i = 0; i < firstDay; i++) {
        calendar.innerHTML += `<div></div>`;
    }

    for (let i = 1; i <= totalDays; i++) {
        calendar.innerHTML += `
            <button class="tgl" onclick="pilihTanggal(this)">
                ${i}
            </button>
        `;
    }
}

function prevMonth() {
    date.setMonth(date.getMonth() - 1);
    renderCalendar();
}

function nextMonth() {
    date.setMonth(date.getMonth() + 1);
    renderCalendar();
}

function pilihTanggal(el) {
    document.querySelectorAll(".tgl").forEach(t => t.classList.remove("active"));
    el.classList.add("active");
    document.getElementById("slotArea").style.display = "block";
}

function pilihSlot(el) {
    document.querySelectorAll(".slot").forEach(s => s.classList.remove("selected"));
    el.classList.add("selected");
}

renderCalendar();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>