<?php
session_start();
$backHref = 'booking.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Booking MUA Yayuk</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<style>
body {
    background: #ffffff;
    font-family: Arial, Helvetica, sans-serif;
    padding-top: 100px !important;
}

.wrapper {
    width: 100%;
    max-width: 1200px;
    margin: auto;
}

.card-custom {
    border: 1px solid #f0f0f0;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.10);
}

.header-booking {
    background: #b5835a;
    padding: 18px;
    text-align: center;
    font-weight: bold;
    font-size: 22px;
}

.calendar-header {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 10px 15px;
}

.calendar {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 10px;
}

.tgl {
    border: none;
    background: #eeeeee;
    padding: 10px 0;
    border-radius: 8px;
    font-size: 18px;
    transition: 0.2s;
    min-height: 50px;
}

.tgl:hover,
.tgl.active {
    background: #b5835a;
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
    background: #b5835a;
    border-color: #b5835a;
    font-weight: bold;
}

.btn-lanjut {
    background: #b5835a;
    border: none;
    padding: 14px;
    font-weight: bold;
    border-radius: 10px;
}

.btn-lanjut:hover {
    background: #b5835a;
}
</style>
</head>

<body>

<!-- SWEETALERT2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php include 'include/navbar.php'; ?>

<div class="container-fluid mt-5 px-lg-5 wrapper">

<div class="mb-4">
       <a href="<?= htmlspecialchars($backHref, ENT_QUOTES, 'UTF-8'); ?>" class="text-dark fs-3"><i class="bi bi-chevron-left"></i></a>
    </div>

    <div class="card card-custom">
        <div class="header-booking">
            Pilih Ketersediaan Tanggal
        </div>

        <div class="card-body">
            <div class="calendar-header d-flex justify-content-between align-items-center mb-3">
                <button class="btn btn-sm btn-outline-dark" onclick="prevMonth()">&#10094;</button>
                <span class="fw-semibold" id="bulanTahun"></span>
                <button class="btn btn-sm btn-outline-dark" onclick="nextMonth()">&#10095;</button>
            </div>

            <div class="calendar mb-4" id="calendar"></div>

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

                <button id="btnContinue" type="button" class="btn btn-primary btn-lanjut w-100 mt-3">
                    LANJUTKAN BOOKING
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let date = new Date();
let selectedDate = null;
let selectedSlot = null;

function renderCalendar() {
    const calendar = document.getElementById("calendar");
    calendar.innerHTML = "";

    const year = date.getFullYear();
    const month = date.getMonth();

    const bulanNama = [
        "Januari", "Februari", "Maret", "April", "Mei", "Juni",
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];

    document.getElementById("bulanTahun").innerText = bulanNama[month] + " " + year;

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
    selectedDate = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(el.innerText).padStart(2, '0')}`;
    document.getElementById("slotArea").style.display = "block";
    selectedSlot = null;
    document.querySelectorAll('.slot').forEach(s => s.classList.remove('selected'));
    const btnContinue = document.getElementById('btnContinue');
    if (btnContinue) {
        btnContinue.classList.add('btn-secondary');
        btnContinue.classList.remove('btn-primary');
    }
}

function pilihSlot(el) {
    document.querySelectorAll(".slot").forEach(s => s.classList.remove("selected"));
    el.classList.add("selected");
    selectedSlot = el.innerText;
    const btnContinue = document.getElementById('btnContinue');
    if (btnContinue) {
        btnContinue.classList.remove('btn-secondary');
        btnContinue.classList.add('btn-primary');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const btnContinue = document.getElementById('btnContinue');
    if (btnContinue) {
        btnContinue.addEventListener('click', function() {
            if (!selectedDate) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Tanggal Belum Dipilih',
                    text: 'Silakan pilih tanggal terlebih dahulu.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#c19775'
                });
                return;
            }
            if (!selectedSlot) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Slot Waktu Belum Dipilih',
                    text: 'Silakan pilih slot waktu terlebih dahulu.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#c19775'
                });
                return;
            }
            sessionStorage.setItem('selectedSchedule', JSON.stringify({ date: selectedDate, slot: selectedSlot }));
            window.location.href = 'pembayaran.php';
        });
    }
});

renderCalendar();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
