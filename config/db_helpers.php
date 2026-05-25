<?php
if (!function_exists('db_columns')) {
    function db_columns(PDO $pdo, string $table, bool $refresh = false): array
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
}

if (!function_exists('db_has_column')) {
    function db_has_column(PDO $pdo, string $table, string $column): bool
    {
        return isset(db_columns($pdo, $table)[$column]);
    }
}

if (!function_exists('ensure_dynamic_booking_schema')) {
    function ensure_dynamic_booking_schema(PDO $pdo): void
    {
        if (!db_has_column($pdo, 'layanan', 'kategori_layanan')) {
            $pdo->exec("ALTER TABLE layanan ADD kategori_layanan enum('makeup','kostum','dekor','paket') NOT NULL DEFAULT 'makeup' AFTER nama_layanan");
            db_columns($pdo, 'layanan', true);
        }

        if (!db_has_column($pdo, 'keranjang', 'id_layanan')) {
            $pdo->exec("ALTER TABLE keranjang ADD id_layanan bigint(20) UNSIGNED DEFAULT NULL AFTER id_user");
            $pdo->exec("ALTER TABLE keranjang ADD KEY idx_keranjang_layanan (id_layanan)");
            db_columns($pdo, 'keranjang', true);
        }

        if (!db_has_column($pdo, 'booking', 'konfirmasi_akhir_token')) {
            $pdo->exec("ALTER TABLE booking ADD konfirmasi_akhir_token varchar(64) DEFAULT NULL AFTER status_booking");
            db_columns($pdo, 'booking', true);
        }

        if (!db_has_column($pdo, 'booking', 'bukti_pembayaran')) {
            $pdo->exec("ALTER TABLE booking ADD bukti_pembayaran varchar(255) DEFAULT NULL AFTER konfirmasi_akhir_token");
            db_columns($pdo, 'booking', true);
        }

        if (!db_has_column($pdo, 'booking', 'tanggal_upload')) {
            $pdo->exec("ALTER TABLE booking ADD tanggal_upload datetime DEFAULT NULL AFTER bukti_pembayaran");
            db_columns($pdo, 'booking', true);
        }

        if (!db_has_column($pdo, 'layanan', 'variant_data')) {
            $pdo->exec("ALTER TABLE layanan ADD COLUMN variant_data TEXT DEFAULT NULL AFTER foto_layanan");
            db_columns($pdo, 'layanan', true);
        }

        $pdo->exec("
            UPDATE booking
            SET status_booking = CASE
                WHEN status_booking IN ('menunggu_pembayaran','menunggu_konfirmasi','pesanan_dibuat','lunas','dibayar','diproses') THEN 'dikonfirmasi'
                WHEN status_booking = 'dibatalkan' THEN 'dibatalkan'
                WHEN status_booking = 'selesai' THEN 'selesai'
                ELSE 'pending'
            END
        ");

        $pdo->exec("
            ALTER TABLE booking
            MODIFY status_booking enum('pending','dikonfirmasi','konfirmasi','selesai','dibatalkan') DEFAULT 'pending'
        ");
    }
}

if (!function_exists('db_has_table')) {
    function db_has_table(PDO $pdo, string $table): bool
    {
        // Use information_schema with a prepared statement for compatibility
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = ?");
        $stmt->execute([$table]);
        return (bool) ((int) $stmt->fetchColumn());
    }
}

if (!function_exists('ensure_dynamic_gallery_schema')) {
    function ensure_dynamic_gallery_schema(PDO $pdo): void
    {
        if (!db_has_table($pdo, 'gallery')) {
            $pdo->exec("CREATE TABLE gallery (
                id_gallery bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                kategori enum('makeup','kostum','dekor') NOT NULL DEFAULT 'makeup',
                judul varchar(150) NOT NULL,
                deskripsi text DEFAULT NULL,
                foto varchar(255) DEFAULT NULL,
                urutan int(11) NOT NULL DEFAULT 0,
                is_active tinyint(1) NOT NULL DEFAULT 1,
                created_at timestamp NOT NULL DEFAULT current_timestamp(),
                updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (id_gallery)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");
        }
    }
}
?>
