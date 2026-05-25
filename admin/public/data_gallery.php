<?php
require_once __DIR__ . '/../../config/auth.php';
require_login(['admin']);
require_once __DIR__ . '/../../config/koneksi.php';
require_once __DIR__ . '/../../config/db_helpers.php';

ensure_dynamic_gallery_schema($pdo);

function gallery_redirect(string $message, string $type = 'success'): void
{
    $_SESSION['gallery_flash'] = ['message' => $message, 'type' => $type];
    header('Location: data_gallery.php');
    exit;
}

function normalize_gallery_category(string $kategori): string
{
    return in_array($kategori, ['makeup', 'dekor', 'kostum'], true) ? $kategori : 'makeup';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    define('GALLERY_MAX_UPLOAD_BYTES', 5 * 1024 * 1024);
    $action = $_POST['action'] ?? 'save';
    $id = (int) ($_POST['id_gallery'] ?? 0);

    try {
        if ($action === 'delete') {
            if ($id <= 0) {
                gallery_redirect('Item gallery tidak valid.', 'danger');
            }

            $stmt = $pdo->prepare('UPDATE gallery SET is_active = 0 WHERE id_gallery = ?');
            $stmt->execute([$id]);
            gallery_redirect('Item gallery berhasil dihapus.');
        }

        $kategori = normalize_gallery_category(trim($_POST['kategori_gallery'] ?? 'makeup'));
        $judul = trim($_POST['judul_gallery'] ?? '');
        $deskripsi = trim($_POST['deskripsi_gallery'] ?? '');
        $urutan = max(0, (int) ($_POST['urutan_gallery'] ?? 0));
        $foto = trim($_POST['foto_lama'] ?? '');

        if ($judul === '') {
            gallery_redirect('Judul gambar wajib diisi.', 'danger');
        }

        if (!empty($_FILES['foto_gallery']['name']) && $_FILES['foto_gallery']['error'] === UPLOAD_ERR_OK) {
            if ($_FILES['foto_gallery']['size'] > GALLERY_MAX_UPLOAD_BYTES) {
                gallery_redirect('Ukuran file tidak boleh lebih dari 5MB.', 'danger');
            }

            $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $_FILES['foto_gallery']['tmp_name']);
            finfo_close($finfo);

            if (!isset($allowed[$mime])) {
                gallery_redirect('Foto harus JPG, PNG, atau WEBP.', 'danger');
            }

            $uploadDir = __DIR__ . '/../../assets/gallery';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $fileName = uniqid('gallery_') . '.' . $allowed[$mime];
            if (!move_uploaded_file($_FILES['foto_gallery']['tmp_name'], $uploadDir . '/' . $fileName)) {
                gallery_redirect('Gagal menyimpan foto gallery.', 'danger');
            }

            $foto = 'assets/gallery/' . $fileName;
        }

            if ($foto === '') {
                gallery_redirect('Foto gallery wajib diunggah.', 'danger');
            }

        if ($id > 0) {
            $stmt = $pdo->prepare('UPDATE gallery SET kategori = ?, judul = ?, deskripsi = ?, foto = ?, urutan = ? WHERE id_gallery = ?');
            $stmt->execute([$kategori, $judul, $deskripsi, $foto, $urutan, $id]);
            gallery_redirect('Data gallery berhasil diperbarui.');
        }

        $stmt = $pdo->prepare('INSERT INTO gallery (kategori, judul, deskripsi, foto, urutan, is_active) VALUES (?, ?, ?, ?, ?, 1)');
        $stmt->execute([$kategori, $judul, $deskripsi, $foto, $urutan]);
        gallery_redirect('Data gallery berhasil ditambahkan.');
    } catch (Throwable $e) {
        gallery_redirect('Gagal menyimpan data gallery: ' . $e->getMessage(), 'danger');
    }
}

$galleryStmt = $pdo->query("SELECT id_gallery, kategori, judul, deskripsi, foto, urutan FROM gallery WHERE is_active = 1 ORDER BY kategori ASC, urutan ASC, id_gallery ASC");
$galleryRows = array_map(static function (array $row): array {
    return [
        'id' => (int) $row['id_gallery'],
        'kategori' => $row['kategori'],
        'judul' => $row['judul'],
        'deskripsi' => $row['deskripsi'] ?? '',
        'foto' => $row['foto'] ? '../../' . ltrim($row['foto'], '/') : '',
        'foto_raw' => $row['foto'] ?? '',
        'urutan' => (int) $row['urutan'],
    ];
}, $galleryStmt->fetchAll(PDO::FETCH_ASSOC));

$flash = $_SESSION['gallery_flash'] ?? null;
unset($_SESSION['gallery_flash']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Data Gallery | Yayuk Makeover</title>
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

        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family:'DM Sans',sans-serif;
            background:var(--cream);
            color:var(--text-main);
            min-height:100vh;
            display:flex;
        }

        .sidebar { width:var(--sidebar-w); min-height:100vh; background:var(--brown-dark); display:flex; flex-direction:column; position:fixed; top:0; left:0; z-index:100; }
        .content { padding:24px; flex:1; margin-left:var(--sidebar-w); }
        .content-header { margin-bottom:28px; }
        .content-header h2 { font-family:'Playfair Display',serif; font-size:1.6rem; font-weight:600; color:var(--brown-dark); margin-bottom:4px; }
        .content-header p { font-size:0.85rem; color:var(--text-muted); }
        .card-custom { border-radius:20px; border:1.5px solid var(--cream-deep); background:var(--white); padding:22px; }
        .form-grid { display:grid; grid-template-columns:1fr; gap:16px; }
        .form-grid .card-custom { padding:20px; }
        .form-group label { display:block; font-size:0.85rem; margin-bottom:8px; color:var(--text-main); }
        .form-group input, .form-group textarea, .form-group select { width:100%; padding:10px 12px; border:1px solid var(--cream-deep); border-radius:12px; background:var(--cream-dark); color:var(--text-main); }
        .gallery-table { width:100%; border-collapse:collapse; }
        .gallery-table th, .gallery-table td { padding:14px 12px; border-bottom:1px solid #e8e1d7; vertical-align:middle; }
        .gallery-table th { background:var(--cream); color:var(--brown-dark); font-weight:600; text-align:left; }
        .thumb-img { width:110px; border-radius:14px; object-fit:cover; height:80px; }
        .badge-kategori { padding:6px 10px; border-radius:999px; font-size:0.75rem; font-weight:600; }
        .badge-makeup { background:#fde8e8; color:#c62828; }
        .badge-dekor { background:#e8f4fd; color:#1565c0; }
        .badge-kostum { background:#f1f4e7; color:#4f772d; }
        .btn-action { display:inline-flex; align-items:center; gap:6px; }
        .uploads-note { font-size:0.8rem; color:var(--text-muted); }
        .img-modal { width:100%; max-height:60vh; object-fit:contain; border-radius:14px; }
        @media (min-width: 768px) { .form-grid { grid-template-columns: 1.4fr 0.6fr; } }
    </style>
</head>
<body>

<?php
$page = 'data_gallery';
include 'include/sidebar.php';
?>

<div class="content">
    <?php if ($flash): ?>
        <div class="alert alert-<?= htmlspecialchars($flash['type'], ENT_QUOTES, 'UTF-8'); ?> alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($flash['message'], ENT_QUOTES, 'UTF-8'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="content-header">
        <h2>Data Gallery</h2>
        <p>Tambahkan gambar gallery untuk halaman client makeup, dekor, dan kostum.</p>
    </div>

    <div class="card-custom">
        <div class="d-flex align-items-center justify-content-between" style="margin-bottom:18px;">
            <h4 id="galleryFormTitle">Tambah Gallery Baru</h4>
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="resetGalleryForm()">Tambah Baru</button>
        </div>
        <form method="post" enctype="multipart/form-data" onsubmit="return validateGalleryForm(event);">
            <div class="form-grid">
                <div>
                    <div class="form-group">
                        <label for="kategori_gallery">Kategori</label>
                        <select id="kategori_gallery" name="kategori_gallery">
                            <option value="makeup">Makeup</option>
                            <option value="dekor">Dekor</option>
                            <option value="kostum">Kostum</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="judul_gallery">Judul Gambar</label>
                        <input type="text" id="judul_gallery" name="judul_gallery" placeholder="Judul gambar" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi_gallery">Deskripsi</label>
                        <textarea id="deskripsi_gallery" name="deskripsi_gallery" rows="4" placeholder="Deskripsi singkat"></textarea>
                    </div>
                </div>

                <div>
                    <div class="form-group">
                        <label for="urutan_gallery">Urutan Tampil</label>
                        <input type="number" id="urutan_gallery" name="urutan_gallery" value="0" min="0">
                    </div>
                    <div class="form-group">
                        <label for="foto_gallery">Unggah Foto</label>
                        <input type="file" id="foto_gallery" name="foto_gallery" accept="image/jpeg,image/png,image/webp">
                        <p class="uploads-note">Format JPG, PNG, WEBP. Ukuran file max 5MB.</p>
                        <img id="fotoGalleryPreview" src="" alt="Preview Foto" style="display:none; width:100%; max-height:240px; object-fit:cover; border-radius:12px; margin-top:12px; border:1px solid #e8e1d7;">
                    </div>
                    <input type="hidden" id="id_gallery" name="id_gallery" value="0">
                    <input type="hidden" id="foto_lama" name="foto_lama" value="">
                    <input type="hidden" name="action" value="save">
                    <button type="submit" class="btn btn-brown" id="gallerySubmitBtn" style="background:var(--brown); color:var(--white);">Simpan Gallery</button>
                </div>
            </div>
        </form>
    </div>

    <div class="card-custom mt-4">
        <h4 style="margin-bottom:18px;">Daftar Gallery</h4>
        <div class="table-responsive">
            <table class="gallery-table">
                <thead>
                    <tr>
                        <th>Preview</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Urutan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($galleryRows)): ?>
                        <tr>
                            <td colspan="5" style="padding:18px;">Belum ada data gallery.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($galleryRows as $item): ?>
                            <tr>
                                <td><img src="<?= htmlspecialchars($item['foto'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?= htmlspecialchars($item['judul'], ENT_QUOTES, 'UTF-8'); ?>" class="thumb-img"></td>
                                <td>
                                    <strong><?= htmlspecialchars($item['judul'], ENT_QUOTES, 'UTF-8'); ?></strong>
                                    <p style="margin:4px 0 0; color:var(--text-muted); font-size:0.85rem;"><?= htmlspecialchars($item['deskripsi'], ENT_QUOTES, 'UTF-8'); ?></p>
                                </td>
                                <td>
                                    <span class="badge-kategori <?= 'badge-' . $item['kategori']; ?>"><?= htmlspecialchars(ucfirst($item['kategori']), ENT_QUOTES, 'UTF-8'); ?></span>
                                </td>
                                <td><?= $item['urutan']; ?></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-action" onclick="editGalleryItem(<?= $item['id']; ?>)"><i class="bi bi-pencil"></i> Edit</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary btn-action" onclick="previewGalleryItem(<?= $item['id']; ?>)"><i class="bi bi-eye"></i> Lihat</button>
                                    <form method="post" style="display:inline-block;" onsubmit="return confirm('Hapus item gallery ini?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id_gallery" value="<?= $item['id']; ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger btn-action"><i class="bi bi-trash"></i> Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="galleryPreviewModal" tabindex="-1" aria-labelledby="galleryPreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-sm-down modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="galleryPreviewModalLabel">Preview Gambar Gallery</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="galleryPreviewImage" src="" alt="Preview" class="img-modal mb-3">
                <h5 id="galleryPreviewTitle"></h5>
                <p id="galleryPreviewDescription" class="text-muted"></p>
                <span id="galleryPreviewCategory" class="badge badge-kategori"></span>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const galleryRows = <?= json_encode($galleryRows, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
    const maxUploadBytes = 5 * 1024 * 1024;

    const previewInput = document.getElementById('foto_gallery');
    const previewImg = document.getElementById('fotoGalleryPreview');

    previewInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) {
            previewImg.style.display = 'none';
            previewImg.src = '';
            return;
        }

        if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type)) {
            alert('Foto harus JPG, PNG, atau WEBP.');
            this.value = '';
            previewImg.style.display = 'none';
            return;
        }

        if (file.size > maxUploadBytes) {
            alert('Ukuran file tidak boleh lebih dari 5MB.');
            this.value = '';
            previewImg.style.display = 'none';
            return;
        }

        const reader = new FileReader();
        reader.onload = () => {
            previewImg.src = reader.result;
            previewImg.style.display = 'block';
        };
        reader.readAsDataURL(file);
    });

    function validateGalleryForm(event) {
        const title = document.getElementById('judul_gallery').value.trim();
        if (title === '') {
            alert('Judul gambar wajib diisi.');
            return false;
        }

        const fileInput = document.getElementById('foto_gallery');
        const file = fileInput.files[0];
        if (file && file.size > maxUploadBytes) {
            alert('Ukuran file tidak boleh lebih dari 5MB.');
            return false;
        }

        if (file && !['image/jpeg', 'image/png', 'image/webp'].includes(file.type)) {
            alert('Foto harus JPG, PNG, atau WEBP.');
            return false;
        }

        return true;
    }

    function resetGalleryForm() {
        document.getElementById('galleryFormTitle').textContent = 'Tambah Gallery Baru';
        document.getElementById('id_gallery').value = '0';
        document.getElementById('kategori_gallery').value = 'makeup';
        document.getElementById('judul_gallery').value = '';
        document.getElementById('deskripsi_gallery').value = '';
        document.getElementById('urutan_gallery').value = '0';
        document.getElementById('foto_gallery').value = '';
        document.getElementById('foto_lama').value = '';
        document.getElementById('gallerySubmitBtn').textContent = 'Simpan Gallery';
        previewImg.style.display = 'none';
        previewImg.src = '';
    }

    function editGalleryItem(itemId) {
        const item = galleryRows.find(row => row.id === itemId);
        if (!item) {
            alert('Data gallery tidak ditemukan.');
            return;
        }

        document.getElementById('galleryFormTitle').textContent = 'Edit Gallery';
        document.getElementById('id_gallery').value = item.id;
        document.getElementById('kategori_gallery').value = item.kategori;
        document.getElementById('judul_gallery').value = item.judul;
        document.getElementById('deskripsi_gallery').value = item.deskripsi;
        document.getElementById('urutan_gallery').value = item.urutan;
        document.getElementById('foto_lama').value = item.foto_raw;
        document.getElementById('gallerySubmitBtn').textContent = 'Perbarui Gallery';

        if (item.foto) {
            previewImg.src = item.foto;
            previewImg.style.display = 'block';
        } else {
            previewImg.style.display = 'none';
            previewImg.src = '';
        }
    }

    function previewGalleryItem(itemId) {
        const item = galleryRows.find(row => row.id === itemId);
        if (!item) {
            alert('Data gallery tidak ditemukan.');
            return;
        }

        document.getElementById('galleryPreviewImage').src = item.foto;
        document.getElementById('galleryPreviewTitle').textContent = item.judul;
        document.getElementById('galleryPreviewDescription').textContent = item.deskripsi;
        const categoryBadge = document.getElementById('galleryPreviewCategory');
        categoryBadge.textContent = item.kategori.charAt(0).toUpperCase() + item.kategori.slice(1);
        categoryBadge.className = 'badge-kategori badge-' + item.kategori;

        const previewModal = new bootstrap.Modal(document.getElementById('galleryPreviewModal'));
        previewModal.show();
    }
</script>
</body>
</html>
