<?php
require_once __DIR__ . '/db_helpers.php';

if (!function_exists('catalog_image_path')) {
    function catalog_image_path(?string $path, string $fallback): string
    {
        $path = trim((string) $path);
        if ($path === '') {
            return $fallback;
        }

        if (preg_match('#^(https?://|/)#', $path)) {
            return $path;
        }

        if (strpos($path, '../assets/') === 0) {
            return $path;
        }

        return '../' . ltrim($path, '/');
    }
}

if (!function_exists('catalog_format_rupiah')) {
    function catalog_format_rupiah($value): string
    {
        return 'Rp ' . number_format((float) $value, 0, ',', '.');
    }
}

if (!function_exists('catalog_includes')) {
    function catalog_includes(?string $description, string $fallback): array
    {
        $description = trim((string) $description);
        if ($description === '') {
            return [$fallback];
        }

        $items = [];
        foreach (preg_split('/\r\n|\n|;/', $description) as $part) {
            $part = trim($part);
            if ($part !== '') {
                $items[] = $part;
            }
        }

        return $items ?: [$fallback];
    }
}

if (!function_exists('catalog_variant_rows')) {
    function catalog_variant_rows(?string $variantData): array
    {
        $variantData = trim((string) $variantData);
        if ($variantData === '') {
            return [];
        }

        $decoded = json_decode($variantData, true);
        return is_array($decoded) ? $decoded : [];
    }
}

if (!function_exists('fetch_catalog_by_category')) {
    function fetch_catalog_by_category(PDO $pdo, string $category, string $fallbackImage, string $fallbackInclude): array
    {
        ensure_dynamic_booking_schema($pdo);

        $stmt = $pdo->prepare("
            SELECT id_layanan, nama_layanan, harga_dasar, foto_layanan, deskripsi, variant_data
            FROM layanan
            WHERE is_active = 1 AND kategori_layanan = ?
            ORDER BY nama_layanan ASC
        ");
        $stmt->execute([$category]);

        $catalog = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $serviceId = (int) $row['id_layanan'];
            $baseImage = catalog_image_path($row['foto_layanan'] ?? '', $fallbackImage);
            $baseIncludes = catalog_includes($row['deskripsi'] ?? '', $fallbackInclude);
            $variants = [];

            foreach (catalog_variant_rows($row['variant_data'] ?? '') as $index => $variant) {
                if (!is_array($variant)) {
                    continue;
                }

                $label = trim((string) ($variant['label'] ?? $variant['name'] ?? ''));
                $price = (float) ($variant['price'] ?? $variant['harga'] ?? $row['harga_dasar']);
                $image = trim((string) ($variant['foto'] ?? $variant['image'] ?? ''));
                $includes = $variant['includes'] ?? $baseIncludes;

                if (is_string($includes)) {
                    $includes = catalog_includes($includes, $fallbackInclude);
                }
                if (!is_array($includes) || $includes === []) {
                    $includes = $baseIncludes;
                }

                $variants[] = [
                    'id' => $serviceId,
                    'nama' => $label !== '' ? $label : $row['nama_layanan'] . ' - Opsi ' . ($index + 1),
                    'foto' => catalog_image_path($image, $baseImage),
                    'harga' => catalog_format_rupiah($price),
                    'harga_value' => $price,
                    'include' => array_values(array_filter(array_map('trim', $includes), static fn($item) => $item !== '')),
                ];
            }

            if ($variants === []) {
                $variants[] = [
                    'id' => $serviceId,
                    'nama' => $row['nama_layanan'],
                    'foto' => $baseImage,
                    'harga' => catalog_format_rupiah($row['harga_dasar']),
                    'harga_value' => (float) $row['harga_dasar'],
                    'include' => $baseIncludes,
                ];
            }

            $catalog[] = [
                'id' => $serviceId,
                'jenis' => $row['nama_layanan'],
                'variasi' => $variants,
            ];
        }

        return $catalog;
    }
}
?>
