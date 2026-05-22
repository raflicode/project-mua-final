<?php

function getBookingData(): array {
    $fromPage = filter_input(INPUT_GET, 'from', FILTER_SANITIZE_STRING);

    if ($fromPage) {
        $_SESSION['booking_from'] = $fromPage;
    }

    $bookingFrom = $_SESSION['booking_from'] ?? 'service';
    $allowedBack = [
        'makeup' => 'makeup.php',
        'dekor' => 'dekor.php',
        'kostum' => 'kostum.php'
    ];

    $backHref = $allowedBack[$bookingFrom] ?? 'service.php';
    $namaProduk = filter_input(INPUT_GET, 'nama', FILTER_SANITIZE_STRING);
    $hargaProduk = filter_input(INPUT_GET, 'harga', FILTER_VALIDATE_INT);
    $fotoProduk = filter_input(INPUT_GET, 'foto', FILTER_SANITIZE_SPECIAL_CHARS);

    $defaultFoto = '../assets/foto_makeup.jpeg';
    if ($bookingFrom === 'dekor') {
        $defaultFoto = '../assets/foto_dekor.jpeg';
    } elseif ($bookingFrom === 'kostum') {
        $defaultFoto = '../assets/foto_kostum.jpeg';
    }

    $currentItem = null;
    if ($namaProduk || $hargaProduk || $fotoProduk) {
        $currentItem = [
            'nama' => $namaProduk ?: 'Makeup Graduation',
            'harga' => $hargaProduk ?: 800000,
            'qty' => 1,
            'foto' => $fotoProduk ?: $defaultFoto
        ];
        $_SESSION['booking_item'] = $currentItem;
    } elseif (isset($_SESSION['booking_item'])) {
        $currentItem = $_SESSION['booking_item'];
    }

    if (!$currentItem) {
        $currentItem = [
            'nama' => 'Makeup Graduation',
            'harga' => 800000,
            'qty' => 1,
            'foto' => $defaultFoto
        ];
        $_SESSION['booking_item'] = $currentItem;
    }

    $checkoutItems = [$currentItem];

    return compact('bookingFrom', 'backHref', 'namaProduk', 'hargaProduk', 'fotoProduk', 'checkoutItems');
}
