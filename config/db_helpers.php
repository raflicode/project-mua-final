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

if (!function_exists('db_try_exec')) {
    function db_try_exec(PDO $pdo, string $sql): void
    {
        try {
            $pdo->exec($sql);
        } catch (Throwable $e) {
            // Some local databases already contain equivalent indexes/definitions.
            // Keep schema preparation best-effort so pages can still render.
        }
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

        if (!db_has_column($pdo, 'booking', 'tgl_booking')) {
            $afterColumn = db_has_column($pdo, 'booking', 'tanggal_booking') ? 'AFTER tanggal_booking' : 'AFTER id_jadwal';
            $pdo->exec("ALTER TABLE booking ADD tgl_booking datetime DEFAULT current_timestamp() $afterColumn");
            if (db_has_column($pdo, 'booking', 'tanggal_booking')) {
                $pdo->exec("UPDATE booking SET tgl_booking = tanggal_booking WHERE tgl_booking IS NULL");
            }
            db_columns($pdo, 'booking', true);
        }

        if (!db_has_column($pdo, 'booking', 'tanggal_booking')) {
            $pdo->exec("ALTER TABLE booking ADD tanggal_booking datetime DEFAULT current_timestamp() AFTER id_jadwal");
            $pdo->exec("UPDATE booking SET tanggal_booking = tgl_booking WHERE tanggal_booking IS NULL");
            db_columns($pdo, 'booking', true);
        }

        if (db_has_column($pdo, 'booking', 'id_layanan')) {
            db_try_exec($pdo, "ALTER TABLE booking MODIFY id_layanan int(11) DEFAULT NULL");
        }

        if (!db_has_column($pdo, 'booking_detail', 'qty')) {
            $pdo->exec("ALTER TABLE booking_detail ADD qty int(11) NOT NULL DEFAULT 1 AFTER id_layanan");
            db_columns($pdo, 'booking_detail', true);
        }

        if (!db_has_column($pdo, 'booking_detail', 'harga')) {
            $pdo->exec("ALTER TABLE booking_detail ADD harga decimal(12,2) NOT NULL DEFAULT 0.00 AFTER qty");
            if (db_has_column($pdo, 'booking_detail', 'harga_transaksi')) {
                $pdo->exec("UPDATE booking_detail SET harga = harga_transaksi WHERE harga = 0");
            }
            db_columns($pdo, 'booking_detail', true);
        }

        if (!db_has_column($pdo, 'booking_detail', 'subtotal')) {
            $pdo->exec("ALTER TABLE booking_detail ADD subtotal decimal(12,2) NOT NULL DEFAULT 0.00 AFTER harga");
            if (db_has_column($pdo, 'booking_detail', 'harga_transaksi')) {
                $pdo->exec("UPDATE booking_detail SET subtotal = harga_transaksi WHERE subtotal = 0");
            } else {
                $pdo->exec("UPDATE booking_detail SET subtotal = harga * qty WHERE subtotal = 0");
            }
            db_columns($pdo, 'booking_detail', true);
        }

        if (!db_has_column($pdo, 'pembayaran', 'id_booking')) {
            $pdo->exec("ALTER TABLE pembayaran ADD id_booking int(11) DEFAULT NULL AFTER id_pembayaran");
            db_columns($pdo, 'pembayaran', true);
        }

        if (!db_has_column($pdo, 'pembayaran', 'jumlah_bayar')) {
            $pdo->exec("ALTER TABLE pembayaran ADD jumlah_bayar decimal(12,2) NOT NULL DEFAULT 0.00 AFTER id_booking");
            db_columns($pdo, 'pembayaran', true);
        }

        if (!db_has_column($pdo, 'pembayaran', 'metode_bayar')) {
            $pdo->exec("ALTER TABLE pembayaran ADD metode_bayar varchar(50) DEFAULT 'transfer' AFTER jumlah_bayar");
            if (db_has_column($pdo, 'pembayaran', 'metode')) {
                $pdo->exec("UPDATE pembayaran SET metode_bayar = metode WHERE metode IS NOT NULL AND metode <> ''");
            }
            db_columns($pdo, 'pembayaran', true);
        }

        if (!db_has_column($pdo, 'pembayaran', 'bukti_transfer')) {
            $pdo->exec("ALTER TABLE pembayaran ADD bukti_transfer varchar(255) DEFAULT NULL AFTER metode_bayar");
            if (db_has_column($pdo, 'pembayaran', 'bukti_pembayaran')) {
                $pdo->exec("UPDATE pembayaran SET bukti_transfer = bukti_pembayaran WHERE bukti_transfer IS NULL");
            }
            db_columns($pdo, 'pembayaran', true);
        }

        if (!db_has_column($pdo, 'pembayaran', 'tgl_upload')) {
            $pdo->exec("ALTER TABLE pembayaran ADD tgl_upload datetime DEFAULT NULL AFTER bukti_transfer");
            if (db_has_column($pdo, 'pembayaran', 'created_at')) {
                $pdo->exec("UPDATE pembayaran SET tgl_upload = created_at WHERE tgl_upload IS NULL");
            }
            db_columns($pdo, 'pembayaran', true);
        }

        if (!db_has_column($pdo, 'pembayaran', 'status_verifikasi')) {
            $pdo->exec("ALTER TABLE pembayaran ADD status_verifikasi enum('pending','diterima','ditolak') DEFAULT 'pending' AFTER tgl_upload");
            if (db_has_column($pdo, 'pembayaran', 'status')) {
                $pdo->exec("
                    UPDATE pembayaran
                    SET status_verifikasi = CASE
                        WHEN status IN ('verified','diterima') THEN 'diterima'
                        WHEN status IN ('rejected','ditolak') THEN 'ditolak'
                        ELSE 'pending'
                    END
                ");
            }
            db_columns($pdo, 'pembayaran', true);
        }

        if (db_has_column($pdo, 'pembayaran', 'id_user')) {
            db_try_exec($pdo, "ALTER TABLE pembayaran MODIFY id_user int(11) DEFAULT NULL");
        }

        if (db_has_column($pdo, 'pembayaran', 'nama')) {
            db_try_exec($pdo, "ALTER TABLE pembayaran MODIFY nama varchar(100) DEFAULT ''");
        }

        if (db_has_column($pdo, 'pembayaran', 'hp')) {
            db_try_exec($pdo, "ALTER TABLE pembayaran MODIFY hp varchar(15) DEFAULT ''");
        }

        if (db_has_column($pdo, 'pembayaran', 'metode')) {
            db_try_exec($pdo, "ALTER TABLE pembayaran MODIFY metode varchar(50) DEFAULT ''");
        }

        if (db_has_column($pdo, 'pembayaran', 'alamat')) {
            db_try_exec($pdo, "ALTER TABLE pembayaran MODIFY alamat text DEFAULT NULL");
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
                WHEN status_booking = 'pending' THEN 'pending'
                WHEN status_booking = 'konfirmasi' THEN 'konfirmasi'
                WHEN status_booking = 'dikonfirmasi' THEN 'dikonfirmasi'
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
