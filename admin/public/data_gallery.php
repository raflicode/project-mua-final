<?php
require_once __DIR__ . '/../../config/auth.php';
require_login(['admin']);
require_once __DIR__ . '/../../config/koneksi.php';
require_once __DIR__ . '/../../config/db_helpers.php';
require_once __DIR__ . '/../../config/image_upload.php';

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

        if (!empty($_FILES['foto_gallery']['name'])) {
            $savedImage = save_optimized_upload_image(
                $_FILES['foto_gallery'],
                __DIR__ . '/../../assets/gallery',
                'assets/gallery',
                'gallery_',
                GALLERY_MAX_UPLOAD_BYTES
            );
            $foto = $savedImage['relative_path'];
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
    <link href="../assets/admin-brown.css" rel="stylesheet">
    <link href="../assets/admin-layout.css" rel="stylesheet">
    <style>
        :root {
            --text: #4d3828;
            --text-main: #4d3828;
            --text-muted: #6b4f3d;
        }
        body {
            color: var(--text);
        }
        .text-muted {
            color: var(--text-muted) !important;
        }
        .content-body,
        .content-body h4,
        .content-body p,
        .content-body label,
        .content-body td,
        .content-body th,
        .content-body .badge-kategori,
        .content-body .gallery-table th,
        .content-body .gallery-table td,
        .content-body .text-muted {
            color: #4d3828 !important;
        }
        .content-body .text-muted {
            color: #6b4f3d !important;
        }
    </style>
</head>
<body>

<?php
$page = 'gallery'; 
include 'include/sidebar.php';
?>

<div class="main-content-wrapper">

    <?php
    $page_title = 'Data Gallery';
    $breadcrumb = 'Admin / Data Gallery';
    include 'include/header.php';
    ?>

    <div class="content-body">
        <?php if ($flash): ?>
            <div class="alert alert-<?= htmlspecialchars($flash['type'], ENT_QUOTES, 'UTF-8'); ?> alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($flash['message'], ENT_QUOTES, 'UTF-8'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card-custom">
            <div class="d-flex align-items-center" style="margin-bottom:18px;">
                <h4 id="galleryFormTitle" style="font-weight: 600; color: var(--brown-dark);">Tambah Gallery Baru</h4>
            </div>
            <form method="post" enctype="multipart/form-data" onsubmit="return validateGalleryForm(event);">
                <div class="row gx-4 gy-3">
                    <div class="col-lg-8">
                        <div class="form-group mb-3">
                            <label for="kategori_gallery">Kategori</label>
                            <select id="kategori_gallery" name="kategori_gallery">
                                <option value="makeup">Makeup</option>
                                <option value="dekor">Dekor</option>
                                <option value="kostum">Kostum</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="judul_gallery">Judul Gambar</label>
                            <input type="text" id="judul_gallery" name="judul_gallery" placeholder="Judul gambar" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="deskripsi_gallery">Deskripsi</label>
                            <textarea id="deskripsi_gallery" name="deskripsi_gallery" rows="4" placeholder="Deskripsi singkat"></textarea>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group mb-3">
                            <label for="urutan_gallery">Urutan Tampil</label>
                            <input type="number" id="urutan_gallery" name="urutan_gallery" value="0" min="0">
                        </div>
                        <div class="form-group mb-3">
                            <label for="foto_gallery">Unggah Foto</label>
                            <input type="file" id="foto_gallery" name="foto_gallery" accept="image/jpeg,image/png,image/webp">
                            <p class="uploads-note mt-1">Format JPG, PNG, WEBP. Ukuran file max 5MB.</p>
                            <img id="fotoGalleryPreview" src="" alt="Preview Foto" class="w-100" style="display:none; max-height:240px; object-fit:cover; border-radius:12px; margin-top:12px; border:1px solid #e8e1d7;">
                        </div>
                        <input type="hidden" id="id_gallery" name="id_gallery" value="0">
                        <input type="hidden" id="foto_lama" name="foto_lama" value="">
                        <input type="hidden" name="action" value="save">
                        <button type="submit" class="btn btn-brown w-100 py-2" id="gallerySubmitBtn" style="background:var(--brown); color:var(--white); border-radius: 12px; border: none; font-weight: 500;">Simpan Gallery</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-custom">
            <h4 style="margin-bottom:18px; font-weight: 600; color: var(--brown-dark);">Daftar Gallery</h4>
            <div class="table-responsive">
                <table class="table table-hover align-middle text-nowrap gallery-table modern-admin-table mb-0">
                    <thead>
                        <tr>
                            <th class="text-nowrap">Preview</th>
                            <th class="text-nowrap table-cell-wide">Judul</th>
                            <th class="text-nowrap table-cell-status">Kategori</th>
                            <th class="text-nowrap">Urutan</th>
                            <th class="text-nowrap table-cell-action">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($galleryRows)): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted" style="padding:18px;">Belum ada data gallery.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($galleryRows as $item): ?>
                                <tr>
                                    <td class="text-nowrap align-middle"><img src="<?= htmlspecialchars($item['foto'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?= htmlspecialchars($item['judul'], ENT_QUOTES, 'UTF-8'); ?>" class="thumb-img"></td>
                                    <td class="text-nowrap align-middle">
                                        <strong><?= htmlspecialchars($item['judul'], ENT_QUOTES, 'UTF-8'); ?></strong>
                                        <p class="table-cell-truncate" style="margin:4px 0 0; color:var(--text-muted); font-size:0.85rem;" title="<?= htmlspecialchars($item['deskripsi'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($item['deskripsi'], ENT_QUOTES, 'UTF-8'); ?></p>
                                    </td>
                                    <td class="text-nowrap align-middle">
                                        <span class="badge-kategori <?= 'badge-' . $item['kategori']; ?>"><?= htmlspecialchars(ucfirst($item['kategori']), ENT_QUOTES, 'UTF-8'); ?></span>
                                    </td>
                                    <td class="text-nowrap align-middle"><?= $item['urutan']; ?></td>
                                    <td class="text-nowrap align-middle">
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

    function editGalleryItem(itemId) {
        const idNum = Number(itemId);
        const item = galleryRows.find(row => Number(row.id) === idNum || row.id == idNum);
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
