<?php

if (!function_exists('optimized_image_allowed_mimes')) {
    function optimized_image_allowed_mimes(): array
    {
        return [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
        ];
    }
}

if (!function_exists('optimized_image_mime')) {
    function optimized_image_mime(string $tmpPath): ?string
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        if ($finfo === false) {
            return null;
        }

        $mime = finfo_file($finfo, $tmpPath);
        finfo_close($finfo);

        return is_string($mime) ? $mime : null;
    }
}

if (!function_exists('optimized_image_create_source')) {
    function optimized_image_create_source(string $tmpPath, string $mime)
    {
        if (!extension_loaded('gd')) {
            return false;
        }

        return match ($mime) {
            'image/jpeg' => function_exists('imagecreatefromjpeg') ? @imagecreatefromjpeg($tmpPath) : false,
            'image/png' => function_exists('imagecreatefrompng') ? @imagecreatefrompng($tmpPath) : false,
            'image/webp' => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($tmpPath) : false,
            default => false,
        };
    }
}

if (!function_exists('save_optimized_upload_image')) {
    /**
     * Saves an uploaded image as a lighter web asset.
     *
     * Returns ['file_name' => string, 'relative_path' => string, 'optimized' => bool].
     */
    function save_optimized_upload_image(
        array $file,
        string $uploadDir,
        string $relativeDir,
        string $prefix,
        int $maxBytes = 5242880,
        int $maxDimension = 1600,
        int $webpQuality = 82
    ): array {
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            throw new RuntimeException('Terjadi kesalahan saat upload file.');
        }

        if (($file['size'] ?? 0) > $maxBytes) {
            throw new RuntimeException('Ukuran file tidak boleh lebih dari ' . round($maxBytes / 1024 / 1024) . 'MB.');
        }

        $tmpPath = (string) ($file['tmp_name'] ?? '');
        $mime = optimized_image_mime($tmpPath);
        $allowed = optimized_image_allowed_mimes();

        if ($mime === null || !isset($allowed[$mime])) {
            throw new RuntimeException('Foto harus JPG, PNG, atau WEBP.');
        }

        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
            throw new RuntimeException('Folder upload tidak bisa dibuat.');
        }

        $relativeDir = trim(str_replace('\\', '/', $relativeDir), '/');
        $source = optimized_image_create_source($tmpPath, $mime);
        $canWriteWebp = $source !== false && function_exists('imagewebp');

        if ($canWriteWebp) {
            $width = imagesx($source);
            $height = imagesy($source);
            $scale = min(1, $maxDimension / max($width, $height));
            $targetWidth = max(1, (int) round($width * $scale));
            $targetHeight = max(1, (int) round($height * $scale));

            $canvas = imagecreatetruecolor($targetWidth, $targetHeight);
            imagealphablending($canvas, true);
            imagesavealpha($canvas, true);
            imagecopyresampled($canvas, $source, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);

            $fileName = uniqid($prefix, true) . '.webp';
            $targetPath = rtrim($uploadDir, '/\\') . DIRECTORY_SEPARATOR . $fileName;
            $saved = imagewebp($canvas, $targetPath, $webpQuality);
            imagedestroy($canvas);
            imagedestroy($source);

            if ($saved) {
                return [
                    'file_name' => $fileName,
                    'relative_path' => $relativeDir . '/' . $fileName,
                    'optimized' => true,
                ];
            }
        } elseif ($source !== false) {
            imagedestroy($source);
        }

        $fileName = uniqid($prefix, true) . '.' . $allowed[$mime];
        $targetPath = rtrim($uploadDir, '/\\') . DIRECTORY_SEPARATOR . $fileName;
        if (!move_uploaded_file($tmpPath, $targetPath)) {
            throw new RuntimeException('Gagal menyimpan foto.');
        }

        return [
            'file_name' => $fileName,
            'relative_path' => $relativeDir . '/' . $fileName,
            'optimized' => false,
        ];
    }
}

