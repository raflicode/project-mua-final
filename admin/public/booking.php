<?php
require_once __DIR__ . '/../../config/auth.php';
require_login(['admin']);
require_once __DIR__ . '/../../config/koneksi.php';

function tableHasColumn(PDO $pdo, string $table, string $column): bool
{
    return isset(tableColumns($pdo, $table)[$column]);
}

function tableColumns(PDO $pdo, string $table, bool $refresh = false): array
{
    static $cache = [];

    if (!$refresh && isset($cache[$table])) {
        return $cache[$table];
    }

    $columns = [];
    $stmt = $pdo->query("SHOW COLUMNS FROM `$table`");
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $columns[$row['Field']] = true;
    }

    $cache[$table] = $columns;
    return $columns;
}

function ensureBookingAdminColumns(PDO $pdo): void
{
    if (!tableHasColumn($pdo, 'booking', 'konfirmasi_akhir_token')) {
        $pdo->exec("ALTER TABLE booking ADD konfirmasi_akhir_token varchar(64) DEFAULT NULL AFTER status_booking");
    }

    if (!tableHasColumn($pdo, 'booking', 'bukti_pembayaran')) {
        $pdo->exec("ALTER TABLE booking ADD bukti_pembayaran varchar(255) DEFAULT NULL AFTER konfirmasi_akhir_token");
    }

    if (!tableHasColumn($pdo, 'booking', 'tanggal_upload')) {
        $pdo->exec("ALTER TABLE booking ADD tanggal_upload datetime DEFAULT NULL AFTER bukti_pembayaran");
    }

    $pdo->exec("ALTER TABLE booking MODIFY status_booking enum('pending','menunggu_pembayaran','menunggu_konfirmasi','pesanan_dibuat','lunas','dibayar','diproses','selesai','dibatalkan') DEFAULT 'pending'");
    $pdo->exec("UPDATE booking SET status_booking = 'lunas' WHERE status_booking IN ('menunggu_konfirmasi','pesanan_dibuat','dibayar','diproses','selesai')");
    $pdo->exec("DELETE FROM booking WHERE status_booking = 'dibatalkan'");
    $pdo->exec("ALTER TABLE booking MODIFY status_booking enum('pending','menunggu_pembayaran','lunas') DEFAULT 'pending'");
}

function paymentLink(string $token): string
{
    return 'payment.php?token=' . rawurlencode($token);
}

function redirectBooking(string $message = '', string $type = 'success'): void
{
    if ($message !== '') {
        $_SESSION['booking_admin_flash'] = ['message' => $message, 'type' => $type];
    }

    header('Location: booking.php');
    exit;
}

try {
    ensureBookingAdminColumns($pdo);
    tableColumns($pdo, 'booking', true);
} catch (Throwable $e) {
    $_SESSION['booking_admin_flash'] = [
        'message' => 'Gagal menyiapkan kolom booking: ' . $e->getMessage(),
        'type' => 'danger'
    ];
}

$paymentColumns = tableColumns($pdo, 'pembayaran');
$proofColumn = isset($paymentColumns['bukti_transfer']) ? 'bukti_transfer' : (isset($paymentColumns['bukti_pembayaran']) ? 'bukti_pembayaran' : null);
$uploadColumn = isset($paymentColumns['tgl_upload']) ? 'tgl_upload' : (isset($paymentColumns['tanggal_upload']) ? 'tanggal_upload' : (isset($paymentColumns['created_at']) ? 'created_at' : null));
$paymentStatusColumn = isset($paymentColumns['status_verifikasi']) ? 'status_verifikasi' : (isset($paymentColumns['status']) ? 'status' : null);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $idBooking = (int) ($_POST['id_booking'] ?? 0);

    if ($idBooking <= 0) {
        redirectBooking('Booking tidak valid.', 'danger');
    }

    try {
        if ($action === 'terima_pesanan') {
            $token = bin2hex(random_bytes(24));
            $stmt = $pdo->prepare("UPDATE booking SET status_booking = 'menunggu_pembayaran', konfirmasi_akhir_token = ? WHERE id_booking = ? AND status_booking = 'pending'");
            $stmt->execute([$token, $idBooking]);
            redirectBooking('Pesanan diterima dan link pembayaran berhasil dibuat.');
        }

        if ($action === 'tolak_pesanan') {
            $stmt = $pdo->prepare("DELETE FROM booking WHERE id_booking = ? AND status_booking = 'pending'");
            $stmt->execute([$idBooking]);
            redirectBooking('Pesanan ditolak dan dihapus dari daftar.');
        }

        if ($action === 'konfirmasi_pembayaran') {
            if ($paymentStatusColumn) {
                $pay = $pdo->prepare("UPDATE pembayaran SET `$paymentStatusColumn` = 'diterima' WHERE id_booking = ?");
                $pay->execute([$idBooking]);
            }
            redirectBooking('Pembayaran dikonfirmasi. Booking sudah diverifikasi.');
        }

        if ($action === 'tolak_pembayaran') {
            $stmt = $pdo->prepare("DELETE FROM booking WHERE id_booking = ? AND status_booking = 'lunas'");
            $stmt->execute([$idBooking]);
            redirectBooking('Pembayaran ditolak dan booking dihapus dari daftar.');
        }

        redirectBooking('Aksi tidak dikenali.', 'danger');
    } catch (Throwable $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        redirectBooking('Gagal memproses aksi: ' . $e->getMessage(), 'danger');
    }
}

if ($proofColumn && $uploadColumn && $paymentStatusColumn && tableHasColumn($pdo, 'booking', 'bukti_pembayaran') && tableHasColumn($pdo, 'booking', 'tanggal_upload')) {
    $syncStmt = $pdo->prepare("
        UPDATE booking b
        JOIN pembayaran p ON p.id_booking = b.id_booking
        SET b.status_booking = 'lunas',
            b.bukti_pembayaran = COALESCE(b.bukti_pembayaran, p.`$proofColumn`),
            b.tanggal_upload = COALESCE(b.tanggal_upload, p.`$uploadColumn`)
        WHERE b.status_booking = 'menunggu_pembayaran'
          AND p.`$proofColumn` IS NOT NULL
          AND p.`$proofColumn` <> ''
          AND p.`$paymentStatusColumn` = 'pending'
    ");
    $syncStmt->execute();
}

$bookingProofSelect = tableHasColumn($pdo, 'booking', 'bukti_pembayaran') ? 'b.bukti_pembayaran' : 'NULL';
$bookingUploadSelect = tableHasColumn($pdo, 'booking', 'tanggal_upload') ? 'b.tanggal_upload' : 'NULL';
$bookingTokenSelect = tableHasColumn($pdo, 'booking', 'konfirmasi_akhir_token') ? 'b.konfirmasi_akhir_token' : 'NULL';
$paymentProofSelect = $proofColumn ? "p.`$proofColumn`" : 'NULL';
$paymentUploadSelect = $uploadColumn ? "p.`$uploadColumn`" : 'NULL';
$paymentStatusSelect = $paymentStatusColumn ? "p.`$paymentStatusColumn`" : 'NULL';
$userNameSelect = tableHasColumn($pdo, 'user', 'full_name') ? 'u.full_name' : (tableHasColumn($pdo, 'user', 'nama_lengkap') ? 'u.nama_lengkap' : 'NULL');
$userPhoneSelect = tableHasColumn($pdo, 'user', 'no_telp') ? 'u.no_telp' : (tableHasColumn($pdo, 'user', 'hp') ? 'u.hp' : 'NULL');

$bookingStmt = $pdo->query("
    SELECT
        b.id_booking,
        b.tgl_booking,
        b.status_booking,
        b.catatan,
        b.total_harga,
        $bookingTokenSelect AS konfirmasi_akhir_token,
        COALESCE($bookingProofSelect, $paymentProofSelect) AS bukti_pembayaran,
        COALESCE($bookingUploadSelect, $paymentUploadSelect) AS tanggal_upload,
        $paymentStatusSelect AS status_pembayaran,
        $userNameSelect AS full_name,
        u.username,
        $userPhoneSelect AS no_telp,
        layanan_booking.nama_layanan
    FROM booking b
    LEFT JOIN user u ON u.id_user = b.id_user
    LEFT JOIN (
        SELECT
            bd.id_booking,
            GROUP_CONCAT(DISTINCT l.nama_layanan ORDER BY l.nama_layanan SEPARATOR ', ') AS nama_layanan
        FROM booking_detail bd
        LEFT JOIN layanan l ON l.id_layanan = bd.id_layanan
        GROUP BY bd.id_booking
    ) layanan_booking ON layanan_booking.id_booking = b.id_booking
    LEFT JOIN (
        SELECT p1.*
        FROM pembayaran p1
        INNER JOIN (
            SELECT id_booking, MAX(id_pembayaran) AS id_pembayaran
            FROM pembayaran
            GROUP BY id_booking
        ) latest_p ON latest_p.id_pembayaran = p1.id_pembayaran
    ) p ON p.id_booking = b.id_booking
    WHERE b.status_booking IN ('pending','menunggu_pembayaran','lunas')
    ORDER BY b.tgl_booking DESC
");

$bookingRows = [];
foreach ($bookingStmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
    $paket = $row['nama_layanan'] ?: 'Layanan Booking';
    $paketLower = strtolower($paket);
    $kategori = 'makeup';
    if (strpos($paketLower, 'dekor') !== false) {
        $kategori = 'dekor';
    } elseif (strpos($paketLower, 'kostum') !== false) {
        $kategori = 'kostum';
    }

    $token = $row['konfirmasi_akhir_token'] ?? '';
    $bukti = $row['bukti_pembayaran'] ?? '';

    $bookingRows[] = [
        'id' => (int) $row['id_booking'],
        'paket' => $paket,
        'kategori' => $kategori,
        'customer' => $row['full_name'] ?: ($row['username'] ?: 'Client'),
        'tgl' => $row['tgl_booking'] ? date('d F Y', strtotime($row['tgl_booking'])) : '-',
        'status' => $row['status_booking'] ?: 'pending',
        'alamat' => $row['catatan'] ?: '-',
        'telp' => $row['no_telp'] ?: '-',
        'token' => $token,
        'payment_link' => $token ? paymentLink($token) : '',
        'bukti_pembayaran' => $bukti,
        'bukti_url' => $bukti ? '../../assets/bukti_pembayaran/' . rawurlencode($bukti) : '',
        'tanggal_upload' => $row['tanggal_upload'] ? date('d F Y H:i', strtotime($row['tanggal_upload'])) : '',
        'status_pembayaran' => $row['status_pembayaran'] ?: '',
    ];
}

$flash = $_SESSION['booking_admin_flash'] ?? null;
unset($_SESSION['booking_admin_flash']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Booking | Yayuk Makeover</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --cream:       #F5F0E8;
            --cream-dark:  #EDE5D8;
            --cream-deep:  #E0D5C5;
            --brown-light: #C4A882;
            --brown:       #8B6B4A;
            --brown-dark:  #5C3D1E;
            --brown-deep:  #3B2410;
            --text-main:   #2C1A0E;
            --text-muted:  #7A6352;
            --white:       #FFFDF9;
            --accent:      #D4956A;
            --accent-soft: #F0DBC8;
            --sidebar-w:   260px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--cream);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: var(--brown-dark);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
        }

        .sidebar-logo {
            padding: 28px 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .sidebar-logo .brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--cream);
            line-height: 1.2;
        }

        .sidebar-logo .brand span {
            color: var(--brown-light);
        }

        .sidebar-logo .sub {
            font-size: 0.7rem;
            color: var(--brown-light);
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 16px 0;
        }

        .nav-label {
            font-size: 0.65rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.3);
            padding: 12px 24px 6px;
            font-weight: 500;
        }

        .nav-item a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 24px;
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 400;
            border-left: 3px solid transparent;
            transition: all 0.2s;
        }

        .nav-item a:hover {
            color: var(--cream);
            background: rgba(255,255,255,0.06);
        }

        .nav-item a.active {
            color: var(--cream);
            background: rgba(196,168,130,0.15);
            border-left-color: var(--brown-light);
            font-weight: 500;
        }

        .nav-item a i {
            font-size: 1rem;
            width: 18px;
            text-align: center;
        }

        .sidebar-footer {
            padding: 16px 24px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            color: rgba(255,255,255,0.5);
            text-decoration: none;
            font-size: 0.85rem;
            transition: color 0.2s;
        }

        .logout-btn:hover { color: #e07b6e; }

        /* ===== MAIN CONTENT ===== */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ===== TOPBAR ===== */
        .topbar {
            background: var(--white);
            border-bottom: 1px solid var(--cream-deep);
            padding: 14px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .topbar-left .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--brown-dark);
        }

        .topbar-left .breadcrumb-nav {
            font-size: 0.78rem;
            color: var(--text-muted);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .search-box {
            display: flex;
            align-items: center;
            background: var(--cream);
            border: 1px solid var(--cream-deep);
            border-radius: 10px;
            padding: 7px 14px;
            gap: 8px;
        }

        .search-box input {
            border: none;
            background: transparent;
            font-size: 0.82rem;
            color: var(--text-main);
            outline: none;
            width: 180px;
            font-family: 'DM Sans', sans-serif;
        }

        .search-box input::placeholder { color: var(--text-muted); }
        .search-box i { color: var(--text-muted); font-size: 0.9rem; }

        .admin-badge {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--cream);
            border: 1px solid var(--cream-deep);
            border-radius: 10px;
            padding: 6px 14px 6px 8px;
        }

        .admin-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: var(--brown);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--cream);
            font-size: 0.75rem;
            font-weight: 600;
        }

        .admin-name {
            font-size: 0.82rem;
            font-weight: 500;
            color: var(--text-main);
        }

        /* ===== PAGE CONTENT ===== */
        .content {
            padding: 24px;
            flex: 1;
            max-width: 100%;
            overflow-x: hidden;
        }

        .content-header {
            margin-bottom: 28px;
        }

        .content-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            font-weight: 600;
            color: var(--brown-dark);
            margin-bottom: 4px;
        }

        .content-header p {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        /* ===== QUICK ACCESS FOLDERS ===== */
        .section-label {
            font-size: 0.68rem;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 14px;
        }

        .folders-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 24px;
            max-width: 100%;
        }

        .folder-card {
            background: var(--white);
            border: 1.5px solid var(--cream-deep);
            border-radius: 14px;
            padding: 14px 16px;
            cursor: pointer;
            transition: all 0.22s;
            text-decoration: none;
            display: flex;
            align-items: center;
            flex-direction: row;
            gap: 12px;
            position: relative;
            overflow: hidden;
        }

        .folder-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: var(--brown-light);
            opacity: 0;
            transition: opacity 0.2s;
        }

        .folder-card:hover {
            border-color: var(--brown-light);
            box-shadow: 0 8px 24px rgba(139,107,74,0.12);
            transform: translateY(-2px);
        }

        .folder-card:hover::before,
        .folder-card.active::before { opacity: 1; }

        .folder-card.active {
            border-color: var(--brown);
            background: var(--accent-soft);
        }

        .folder-icon {
            width: 42px;
            height: 35px;
            position: relative;
            flex: 0 0 auto;
        }

        .folder-icon svg { width: 42px; height: 35px; }

        .folder-name {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--brown-dark);
        }

        .folder-count {
            font-size: 0.72rem;
            color: var(--text-muted);
            margin-top: -8px;
        }

        /* ===== TABLE SECTION ===== */
        .table-section {
            background: var(--white);
            border-radius: 20px;
            border: 1.5px solid var(--cream-deep);
            overflow: hidden;
            max-width: 100%;
        }

        .table-header {
            padding: 14px 18px;
            border-bottom: 1px solid var(--cream-deep);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--cream);
            gap: 12px;
        }

        .table-header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .table-header-left h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1rem;
            font-weight: 600;
            color: var(--brown-dark);
        }

        .table-header-left .count-badge {
            background: var(--brown);
            color: var(--cream);
            font-size: 0.7rem;
            font-weight: 600;
            padding: 2px 10px;
            border-radius: 20px;
        }

        .filter-tabs {
            display: flex;
            gap: 6px;
            overflow-x: auto;
            max-width: 100%;
            padding-bottom: 2px;
        }

        .filter-tab {
            padding: 6px 10px;
            border-radius: 8px;
            font-size: 0.74rem;
            font-weight: 500;
            cursor: pointer;
            border: 1px solid var(--cream-deep);
            background: var(--white);
            color: var(--text-muted);
            transition: all 0.2s;
            white-space: nowrap;
        }

        .filter-tab.active, .filter-tab:hover {
            background: var(--brown);
            color: var(--cream);
            border-color: var(--brown);
        }

        /* TABLE */
        .booking-table {
            width: 100%;
            min-width: 980px;
            border-collapse: collapse;
        }

        .table-scroll {
            width: 100%;
            max-width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .booking-table thead th {
            padding: 10px 12px;
            font-size: 0.68rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            color: var(--text-muted);
            background: var(--cream);
            border-bottom: 1px solid var(--cream-deep);
            text-align: left;
            white-space: nowrap;
        }

        .booking-table tbody tr {
            border-bottom: 1px solid var(--cream-dark);
            transition: background 0.15s;
        }

        .booking-table tbody tr:last-child { border-bottom: none; }

        .booking-table tbody tr:hover { background: var(--cream); }

        .booking-table tbody td {
            padding: 10px 12px;
            font-size: 0.78rem;
            color: var(--text-main);
            vertical-align: middle;
        }

        .paket-cell {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .paket-name {
            font-weight: 600;
            color: var(--brown-dark);
            font-size: 0.78rem;
        }

        .paket-type {
            font-size: 0.72rem;
            color: var(--text-muted);
        }

        .customer-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .cust-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--accent-soft);
            border: 1.5px solid var(--brown-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--brown);
            flex-shrink: 0;
        }

        /* STATUS BADGE */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .status-badge::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .status-lunas {
            background: #EDF7ED;
            color: #2E7D32;
        }
        .status-lunas::before { background: #43A047; }

        .status-proses {
            background: #FFF8E1;
            color: #E65100;
        }
        .status-proses::before { background: #FF8F00; }

        .status-dp {
            background: #E8F4FD;
            color: #1565C0;
        }
        .status-dp::before { background: #1E88E5; }

        .status-batal {
            background: #FDECEA;
            color: #C62828;
        }
        .status-batal::before { background: #E53935; }

        .status-pending,
        .status-menunggu_pembayaran {
            background: #FFF8E1;
            color: #E65100;
        }
        .status-pending::before,
        .status-menunggu_pembayaran::before { background: #FF8F00; }

        /* ACTION BTNS */
        .action-btns {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .btn-action {
            min-height: 30px;
            border-radius: 8px;
            border: 1px solid var(--cream-deep);
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            cursor: pointer;
            font-size: 0.74rem;
            color: var(--text-muted);
            transition: all 0.2s;
            text-decoration: none;
            padding: 6px 8px;
            white-space: nowrap;
        }

        .btn-action.icon-only {
            width: 30px;
            padding: 0;
        }

        .btn-action:hover {
            background: var(--brown);
            color: var(--cream);
            border-color: var(--brown);
        }

        .btn-action.accept {
            color: #2E7D32;
        }

        .btn-action.reject {
            color: #C62828;
        }

        .btn-action.copy {
            color: #1565C0;
        }

        .muted-action {
            color: var(--text-muted);
            font-size: 0.74rem;
            white-space: nowrap;
        }

        .copy-toast {
            position: fixed;
            right: 24px;
            bottom: 24px;
            z-index: 9999;
            background: var(--brown-dark);
            color: var(--cream);
            border-radius: 12px;
            padding: 10px 14px;
            box-shadow: 0 10px 30px rgba(44, 26, 14, 0.22);
            font-size: 0.82rem;
            opacity: 0;
            transform: translateY(10px);
            pointer-events: none;
            transition: opacity 0.22s ease, transform 0.22s ease;
        }

        .copy-toast.show {
            opacity: 1;
            transform: translateY(0);
        }

        .payment-proof-img {
            max-width: 100%;
            border-radius: 14px;
            border: 1px solid var(--cream-deep);
        }

        /* EMPTY STATE */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 3rem;
            opacity: 0.3;
            margin-bottom: 12px;
            display: block;
        }

        .empty-state p {
            font-size: 0.88rem;
        }

        /* PAGINATION */
        .table-footer {
            padding: 14px 24px;
            border-top: 1px solid var(--cream-deep);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--cream);
        }

        .table-footer .info {
            font-size: 0.78rem;
            color: var(--text-muted);
        }

        .pagination-btns {
            display: flex;
            gap: 6px;
        }

        .pg-btn {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            border: 1px solid var(--cream-deep);
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--text-muted);
            transition: all 0.2s;
        }

        .pg-btn.active, .pg-btn:hover {
            background: var(--brown);
            color: var(--cream);
            border-color: var(--brown);
        }

        @media (max-width: 1199px) {
            .folders-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                max-width: 100%;
            }

            .booking-table {
                width: 100%;
                min-width: 920px;
                table-layout: auto;
            }

            .booking-table thead th,
            .booking-table tbody td {
                white-space: nowrap;
            }
        }

        @media (max-width: 991px) {
            body {
                display: block;
            }

            .sidebar {
                position: relative;
                width: 100%;
                min-height: auto;
            }

            .sidebar-logo {
                padding: 20px 24px 14px;
            }

            .sidebar-nav {
                flex: none;
                display: flex;
                flex-wrap: wrap;
                gap: 6px;
                padding: 12px 16px;
            }

            .nav-label {
                width: 100%;
                padding: 8px 8px 2px;
            }

            .nav-item a {
                border-left: 0;
                border-radius: 10px;
                padding: 10px 14px;
                background: rgba(255,255,255,0.04);
            }

            .nav-item a.active {
                border-left-color: transparent;
                background: rgba(196,168,130,0.22);
            }

            .sidebar-footer {
                padding: 12px 24px 18px;
            }

            .main {
                margin-left: 0;
                min-height: auto;
            }

            .topbar {
                position: relative;
                padding: 16px 24px;
                gap: 16px;
                flex-wrap: wrap;
            }

            .topbar-right {
                width: 100%;
                justify-content: space-between;
            }

            .search-box {
                flex: 1;
            }

            .search-box input {
                width: 100%;
            }

            .content {
                padding: 24px;
            }

            .table-header {
                align-items: flex-start;
                gap: 14px;
                flex-direction: column;
            }

            .filter-tabs {
                width: 100%;
                overflow-x: auto;
                padding-bottom: 2px;
            }

            .filter-tab {
                flex: 0 0 auto;
            }
        }

        @media (max-width: 767px) {
            .content {
                padding: 20px 16px 28px;
            }

            .content-header {
                margin-bottom: 22px;
            }

            .content-header h2 {
                font-size: 1.35rem;
            }

            .folders-grid {
                grid-template-columns: 1fr;
                gap: 12px;
                margin-bottom: 24px;
            }

            .folder-card {
                flex-direction: row;
                align-items: center;
                padding: 16px;
                border-radius: 14px;
            }

            .table-section {
                border-radius: 16px;
            }

            .table-header,
            .table-footer {
                padding: 16px;
            }

            .table-footer {
                align-items: flex-start;
                flex-direction: column;
                gap: 12px;
            }

            .pagination-btns {
                width: 100%;
                overflow-x: auto;
                padding-bottom: 2px;
            }

            .booking-table thead th,
            .booking-table tbody td {
                padding: 9px 10px;
            }
        }

        @media (max-width: 575px) {
            .sidebar-logo .brand {
                font-size: 1rem;
            }

            .sidebar-nav {
                display: grid;
                grid-template-columns: 1fr;
            }

            .nav-label {
                padding-left: 8px;
            }

            .nav-item a {
                width: 100%;
            }

            .topbar {
                padding: 14px 16px;
            }

            .topbar-right {
                align-items: stretch;
                flex-direction: column;
                gap: 10px;
            }

            .admin-badge {
                justify-content: flex-start;
            }

            .section-label {
                margin-bottom: 10px;
            }

            .filter-tabs {
                gap: 8px;
            }

            .filter-tab {
                padding: 7px 12px;
            }

            .table-header-left {
                width: 100%;
                justify-content: space-between;
            }
        }
    </style>
    <link href="../assets/admin-brown.css" rel="stylesheet">
</head>
<body>

<?php
$page = 'booking';
include 'include/sidebar.php';
?>

<!-- MAIN -->
<div class="main">

    <?php
    $page_title = 'Booking';
    $breadcrumb = 'Admin / Booking';
    include 'include/header.php';
    ?>

    <!-- CONTENT -->
    <div class="content">
        <?php if ($flash): ?>
            <div class="alert alert-<?= htmlspecialchars($flash['type'], ENT_QUOTES, 'UTF-8'); ?> alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($flash['message'], ENT_QUOTES, 'UTF-8'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="content-header">
            <h2>Riwayat Booking</h2>
            <p>Kelola semua booking dari client berdasarkan kategori layanan</p>
        </div>

        <!-- QUICK ACCESS FOLDERS -->
        <div class="section-label">Quick Access</div>
        <div class="folders-grid">

            <div class="folder-card active" onclick="setFolder('semua', this)">
                <div class="folder-icon">
                    <svg viewBox="0 0 48 40" fill="none">
                        <rect x="0" y="10" width="48" height="30" rx="5" fill="#C4A882" opacity="0.3"/>
                        <rect x="0" y="14" width="48" height="26" rx="5" fill="#C4A882"/>
                        <rect x="0" y="10" width="20" height="8" rx="3" fill="#C4A882" opacity="0.7"/>
                        <rect x="4" y="22" width="16" height="2" rx="1" fill="#fff" opacity="0.5"/>
                        <rect x="4" y="27" width="20" height="2" rx="1" fill="#fff" opacity="0.4"/>
                        <rect x="4" y="32" width="14" height="2" rx="1" fill="#fff" opacity="0.3"/>
                    </svg>
                </div>
                <div>
                    <div class="folder-name">Semua</div>
                    <div class="folder-count" id="count-semua">0 booking</div>
                </div>
            </div>

            <div class="folder-card" onclick="setFolder('makeup', this)">
                <div class="folder-icon">
                    <svg viewBox="0 0 48 40" fill="none">
                        <rect x="0" y="10" width="48" height="30" rx="5" fill="#D4956A" opacity="0.3"/>
                        <rect x="0" y="14" width="48" height="26" rx="5" fill="#D4956A"/>
                        <rect x="0" y="10" width="20" height="8" rx="3" fill="#D4956A" opacity="0.7"/>
                        <circle cx="24" cy="27" r="6" fill="#fff" opacity="0.25"/>
                        <rect x="21" y="25" width="6" height="1.5" rx="1" fill="#fff" opacity="0.6"/>
                        <rect x="21" y="28" width="6" height="1.5" rx="1" fill="#fff" opacity="0.6"/>
                        <rect x="21" y="31" width="6" height="1.5" rx="1" fill="#fff" opacity="0.6"/>
                    </svg>
                </div>
                <div>
                    <div class="folder-name">Makeup</div>
                    <div class="folder-count" id="count-makeup">0 booking</div>
                </div>
            </div>

            <div class="folder-card" onclick="setFolder('dekor', this)">
                <div class="folder-icon">
                    <svg viewBox="0 0 48 40" fill="none">
                        <rect x="0" y="10" width="48" height="30" rx="5" fill="#8B6B4A" opacity="0.3"/>
                        <rect x="0" y="14" width="48" height="26" rx="5" fill="#8B6B4A"/>
                        <rect x="0" y="10" width="20" height="8" rx="3" fill="#8B6B4A" opacity="0.7"/>
                        <path d="M18 32 Q24 20 30 32" stroke="#fff" stroke-width="1.5" fill="none" opacity="0.5"/>
                        <circle cx="24" cy="22" r="3" fill="#fff" opacity="0.4"/>
                    </svg>
                </div>
                <div>
                    <div class="folder-name">Dekor</div>
                    <div class="folder-count" id="count-dekor">0 booking</div>
                </div>
            </div>

            <div class="folder-card" onclick="setFolder('kostum', this)">
                <div class="folder-icon">
                    <svg viewBox="0 0 48 40" fill="none">
                        <rect x="0" y="10" width="48" height="30" rx="5" fill="#5C3D1E" opacity="0.3"/>
                        <rect x="0" y="14" width="48" height="26" rx="5" fill="#5C3D1E"/>
                        <rect x="0" y="10" width="20" height="8" rx="3" fill="#5C3D1E" opacity="0.7"/>
                        <path d="M18 18 L18 36 L30 36 L30 18 L26 22 L24 20 L22 22 Z" fill="#fff" opacity="0.25"/>
                    </svg>
                </div>
                <div>
                    <div class="folder-name">Kostum</div>
                    <div class="folder-count" id="count-kostum">0 booking</div>
                </div>
            </div>

        </div>

        <!-- TABLE -->
        <div class="table-section">
            <div class="table-header">
                <div class="table-header-left">
                    <h3 id="table-title">All Files</h3>
                    <span class="count-badge" id="table-count">0</span>
                </div>
                <div class="filter-tabs">
                    <div class="filter-tab active" onclick="filterStatus('semua', this)">Semua</div>
                    <div class="filter-tab" onclick="filterStatus('pending', this)">Pending</div>
                    <div class="filter-tab" onclick="filterStatus('menunggu_pembayaran', this)">Menunggu Pembayaran</div>
                    <div class="filter-tab" onclick="filterStatus('lunas', this)">Lunas</div>
                </div>
            </div>

            <div class="table-scroll">
                <table class="booking-table" id="bookingTable">
                    <thead>
                        <tr>
                            <th>Paket</th>
                            <th>Customer</th>
                            <th>Tgl Booking</th>
                            <th>Status</th>
                            <th>Alamat</th>
                            <th>No. Telp</th>
                            <th>Buat Halaman Pembayaran</th>
                            <th>Lihat Bukti Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <!-- diisi via JS -->
                    </tbody>
                </table>
            </div>

            <div id="emptyState" class="empty-state" style="display:none;">
                <i class="bi bi-folder2-open"></i>
                <p>Tidak ada data booking ditemukan</p>
            </div>

            <div class="table-footer">
                <div class="info" id="tableInfo">Menampilkan 0 data</div>
                <div class="pagination-btns" id="pagination"></div>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="buktiModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="color: var(--brown-dark);">Bukti Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <img src="" alt="Bukti pembayaran" class="payment-proof-img" id="buktiPreview">
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-brown" id="buktiDownload" download>
                    <i class="bi bi-download"></i> Download
                </a>
            </div>
        </div>
    </div>
</div>

<div class="copy-toast" id="copyToast">Link berhasil disalin</div>

<script>
const bookingData = <?= json_encode($bookingRows, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>;

let currentFolder  = 'semua';
let currentStatus  = 'semua';
let currentSearch  = '';
const perPage      = 6;
let currentPage    = 1;

const statusLabels = {
    pending:               { label:'Pending', cls:'status-pending' },
    menunggu_pembayaran:   { label:'Menunggu Pembayaran', cls:'status-menunggu_pembayaran' },
    lunas:                 { label:'Lunas', cls:'status-lunas' },
};

function escapeHtml(value) {
    return String(value ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

function actionForm(id, action, label, icon, cls = '') {
    return `
        <form method="post" onsubmit="return confirm('Lanjutkan aksi ini?');">
            <input type="hidden" name="id_booking" value="${id}">
            <input type="hidden" name="action" value="${action}">
            <button type="submit" class="btn-action ${cls}">
                <i class="bi ${icon}"></i> ${label}
            </button>
        </form>
    `;
}

function renderPaymentTools(b) {
    if (b.status !== 'menunggu_pembayaran' || !b.payment_link) {
        return '';
    }

    const link = escapeHtml(b.payment_link);
    return `
        <div class="action-btns">
            <button type="button" class="btn-action copy" onclick="copyPaymentLink('${link}')">
                <i class="bi bi-clipboard"></i> Salin Link
            </button>
        </div>
    `;
}

function renderProofTools(b) {
    if (!b.bukti_url) {
        return '';
    }

    const url = escapeHtml(b.bukti_url);
    return `
        <div class="action-btns">
            <button type="button" class="btn-action" onclick="showBukti('${url}')">
                <i class="bi bi-eye"></i> Lihat
            </button>
            <a href="${url}" class="btn-action" download>
                <i class="bi bi-download"></i> Download
            </a>
        </div>
        <div class="muted-action">${escapeHtml(b.tanggal_upload)}</div>
    `;
}

function renderActions(b) {
    if (b.status === 'pending') {
        return `
            <div class="action-btns">
                ${actionForm(b.id, 'terima_pesanan', 'Terima Pesanan', 'bi-check2-circle', 'accept')}
                ${actionForm(b.id, 'tolak_pesanan', 'Tolak Pesanan', 'bi-x-circle', 'reject')}
            </div>
        `;
    }

    if (b.status === 'menunggu_pembayaran') {
        return '<span class="muted-action">Menunggu Client Upload Bukti</span>';
    }

    if (b.status === 'lunas' && b.bukti_url && b.status_pembayaran !== 'diterima') {
        return `
            <div class="action-btns">
                ${actionForm(b.id, 'konfirmasi_pembayaran', 'Konfirmasi Pembayaran', 'bi-check2-circle', 'accept')}
                ${actionForm(b.id, 'tolak_pembayaran', 'Tolak Pembayaran', 'bi-x-circle', 'reject')}
            </div>
        `;
    }

    if (b.status === 'lunas' && b.status_pembayaran === 'diterima') {
        return '<span class="muted-action">Terverifikasi</span>';
    }

    return '<span class="muted-action">Tidak ada aksi</span>';
}

function initCounts() {
    document.getElementById('count-semua').textContent  = bookingData.length + ' booking';
    document.getElementById('count-makeup').textContent = bookingData.filter(b=>b.kategori==='makeup').length  + ' booking';
    document.getElementById('count-dekor').textContent  = bookingData.filter(b=>b.kategori==='dekor').length   + ' booking';
    document.getElementById('count-kostum').textContent = bookingData.filter(b=>b.kategori==='kostum').length  + ' booking';
}

function getFiltered() {
    return bookingData.filter(b => {
        const folderMatch  = currentFolder === 'semua' || b.kategori === currentFolder;
        const statusMatch  = currentStatus === 'semua' || b.status === currentStatus;
        const searchMatch  = currentSearch === '' ||
            b.paket.toLowerCase().includes(currentSearch) ||
            b.customer.toLowerCase().includes(currentSearch);
        return folderMatch && statusMatch && searchMatch;
    });
}

function renderTable() {
    const data     = getFiltered();
    const start    = (currentPage - 1) * perPage;
    const pageData = data.slice(start, start + perPage);
    const tbody    = document.getElementById('tableBody');

    document.getElementById('table-count').textContent = data.length;
    document.getElementById('tableInfo').textContent   = `Menampilkan ${pageData.length} dari ${data.length} data`;

    if (data.length === 0) {
        tbody.innerHTML = '';
        document.getElementById('emptyState').style.display = 'block';
    } else {
        document.getElementById('emptyState').style.display = 'none';
        tbody.innerHTML = pageData.map(b => {
            const st  = statusLabels[b.status] || { label: b.status, cls: '' };
            const ini = escapeHtml(b.customer.substring(0, 2).toUpperCase());
            return `
            <tr>
                <td>
                    <div class="paket-cell">
                        <div class="paket-name">${escapeHtml(b.paket)}</div>
                        <div class="paket-type">${escapeHtml(b.kategori.charAt(0).toUpperCase()+b.kategori.slice(1))}</div>
                    </div>
                </td>
                <td>
                    <div class="customer-cell">
                        <div class="cust-avatar">${ini}</div>
                        ${escapeHtml(b.customer)}
                    </div>
                </td>
                <td>${escapeHtml(b.tgl)}</td>
                <td><span class="status-badge ${st.cls}">${st.label}</span></td>
                <td>${escapeHtml(b.alamat)}</td>
                <td>${escapeHtml(b.telp)}</td>
                <td>${renderPaymentTools(b)}</td>
                <td>${renderProofTools(b)}</td>
                <td>${renderActions(b)}</td>
            </tr>`;
        }).join('');
    }

    renderPagination(data.length);
}

function renderPagination(total) {
    const pages = Math.ceil(total / perPage);
    const pg    = document.getElementById('pagination');
    if (pages <= 1) { pg.innerHTML = ''; return; }
    let html = '';
    for (let i = 1; i <= pages; i++) {
        html += `<div class="pg-btn ${i===currentPage?'active':''}" onclick="goPage(${i})">${i}</div>`;
    }
    pg.innerHTML = html;
}

function goPage(p) { currentPage = p; renderTable(); }

function setFolder(folder, el) {
    currentFolder = folder;
    currentPage   = 1;
    document.querySelectorAll('.folder-card').forEach(c => c.classList.remove('active'));
    el.classList.add('active');
    const titles = { semua:'All Files', makeup:'Makeup', dekor:'Dekor', kostum:'Kostum' };
    document.getElementById('table-title').textContent = titles[folder] || folder;
    renderTable();
}

function filterStatus(status, el) {
    currentStatus = status;
    currentPage   = 1;
    document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    renderTable();
}

function filterTable() {
    currentSearch = document.getElementById('searchInput').value.toLowerCase();
    currentPage   = 1;
    renderTable();
}

function lihat(id) {
    const booking = bookingData.find(b => b.id === id);
    if (!booking) return;
    alert(
        'Detail Booking #' + id + '\n' +
        'Paket: ' + booking.paket + '\n' +
        'Customer: ' + booking.customer + '\n' +
        'Tanggal: ' + booking.tgl + '\n' +
        'Status: ' + booking.status
    );
}

function copyPaymentLink(link) {
    navigator.clipboard.writeText(link).then(() => {
        showCopyToast();
    }).catch(() => {
        prompt('Salin link pembayaran:', link);
    });
}

function showCopyToast() {
    const toast = document.getElementById('copyToast');
    toast.classList.add('show');
    clearTimeout(window.copyToastTimer);
    window.copyToastTimer = setTimeout(() => toast.classList.remove('show'), 1800);
}

function showBukti(url) {
    document.getElementById('buktiPreview').src = url;
    document.getElementById('buktiDownload').href = url;
    new bootstrap.Modal(document.getElementById('buktiModal')).show();
}

// INIT
initCounts();
renderTable();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
