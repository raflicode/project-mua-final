# Panduan Implementasi Table Modern CSS

## 🎯 Langkah-Langkah Implementasi

### 1. Import CSS di Halaman Admin
Tambahkan di `<head>` setiap halaman admin yang punya tabel:

```html
<link href="../assets/table-modern.css" rel="stylesheet">
```

### 2. Struktur HTML yang Benar

#### Template Lengkap:
```html
<div class="table-wrapper">
    <!-- Header Section (Optional tapi recommended) -->
    <div class="table-header-section">
        <div class="table-header-left">
            <h3>Judul Tabel</h3>
            <span class="table-count-badge">42</span>
        </div>
    </div>

    <!-- Table Scroll Wrapper -->
    <div class="table-wrapper-scroll">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th style="width: 80px;">Kolom 1</th>
                    <th style="width: 150px;">Kolom 2</th>
                    <th style="width: 120px;">Status</th>
                    <th style="width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Isi row di sini -->
            </tbody>
        </table>
    </div>

    <!-- Footer Section (Optional) -->
    <div class="table-footer-section">
        <div class="table-footer-info">
            Menampilkan 1-10 dari 42 data
        </div>
    </div>
</div>
```

---

## 🎨 Komponen-Komponen

### A. STATUS BADGE

#### Variasi Status:
```html
<!-- Success / Hijau -->
<span class="badge-status success">Lunas</span>

<!-- Pending / Kuning -->
<span class="badge-status pending">Menunggu</span>

<!-- Processing / Biru -->
<span class="badge-status processing">Diproses</span>

<!-- Danger / Merah -->
<span class="badge-status danger">Batal</span>
```

### B. ACTION BUTTONS

#### Dengan Teks + Icon:
```html
<div class="action-buttons">
    <a href="#detail" class="btn-action btn-info">
        <i class="bi bi-eye"></i>
        <span>Lihat</span>
    </a>
    <a href="#edit" class="btn-action btn-warning">
        <i class="bi bi-pencil"></i>
        <span>Edit</span>
    </a>
    <a href="#delete" class="btn-action btn-danger">
        <i class="bi bi-trash"></i>
        <span>Hapus</span>
    </a>
</div>
```

#### Icon Only (lebih compact):
```html
<div class="action-buttons">
    <a href="#" class="btn-action btn-info" title="Lihat">
        <i class="bi bi-eye"></i>
    </a>
    <a href="#" class="btn-action btn-warning" title="Edit">
        <i class="bi bi-pencil"></i>
    </a>
    <a href="#" class="btn-action btn-danger" title="Hapus">
        <i class="bi bi-trash"></i>
    </a>
</div>
```

#### Ukuran Button:
```html
<a class="btn-action btn-sm">Small</a>      <!-- Compact -->
<a class="btn-action">Default</a>           <!-- Normal -->
<a class="btn-action btn-lg">Large</a>      <!-- Besar -->
```

### C. CELL CONTENT (Multi-line)

#### Dengan Label + Sublabel:
```html
<td>
    <div class="cell-content">
        <div class="cell-label">Nama Utama</div>
        <div class="cell-sublabel">Detail atau email</div>
    </div>
</td>
```

#### Monospace (untuk kode/filename):
```html
<td class="cell-mono">makeup-bride-001.jpg</td>
```

#### Dengan Nowrap (tanpa line-break):
```html
<td style="white-space: nowrap;">+62 812 3456 7890</td>
<td style="white-space: nowrap;">28 Mei 2026</td>
<td style="white-space: nowrap;">Rp 2.500.000</td>
```

---

## 📋 Mapping Status ke Badge

Jika menggunakan PHP, mapping status otomatis:

```php
<?php
function getStatusBadge($status) {
    $mapping = [
        'lunas' => 'success',
        'dibayar' => 'success',
        'selesai' => 'success',
        'pending' => 'pending',
        'menunggu' => 'pending',
        'diproses' => 'processing',
        'proses' => 'processing',
        'batal' => 'danger',
        'gagal' => 'danger',
    ];
    
    $badgeClass = $mapping[strtolower($status)] ?? 'pending';
    $displayText = ucfirst($status);
    
    return "<span class=\"badge-status {$badgeClass}\">{$displayText}</span>";
}
?>

<!-- Penggunaan di view -->
<td>
    <?php echo getStatusBadge($row['status']); ?>
</td>
```

---

## 🔧 Width Kolom Guidelines

Atur width berdasarkan tipe data:

```
No/ID              → 50-80px
Nama/Title         → 150-250px
Email              → 180-250px
Telepon            → 120-150px
Tanggal            → 100-130px
Harga/Amount       → 100-130px
Status             → 90-120px
Action Buttons     → 150-200px
Checkbox           → 40px
Avatar/Image       → 50px
```

Contoh:
```html
<th style="width: 60px;">No</th>
<th style="width: 180px;">Nama</th>
<th style="width: 150px;">Email</th>
<th style="width: 100px;">Tanggal</th>
<th style="width: 100px;">Harga</th>
<th style="width: 90px;">Status</th>
<th style="width: 150px;">Aksi</th>
```

---

## 🎯 Icon Recommendations (Bootstrap Icons)

```
Lihat/View      → bi-eye
Edit            → bi-pencil atau bi-pencil-square
Hapus/Delete    → bi-trash
Download        → bi-download
Cetak/Print     → bi-printer
Approve/Check   → bi-check-circle
Reject/X        → bi-x-circle
Add/Plus        → bi-plus-circle
Settings        → bi-gear
More Options    → bi-three-dots-vertical
Back/Left       → bi-chevron-left
Next/Right      → bi-chevron-right
```

---

## 📱 Responsive Behavior (Otomatis)

| Breakpoint | Padding | Font Size | Button Size |
|-----------|---------|-----------|------------|
| Desktop   | 16px    | 0.92rem   | Normal     |
| Tablet    | 12px    | 0.85rem   | Small      |
| Mobile    | 10px    | 0.8rem    | Very Small |

---

## ✅ Checklist Implementasi

Untuk setiap halaman admin dengan tabel:

- [ ] Import `table-modern.css` di head
- [ ] Wrap table dengan `.table-wrapper`
- [ ] Wrap table scroll dengan `.table-wrapper-scroll`
- [ ] Tambah `.table-header-section` dengan judul
- [ ] Gunakan `class="table table-hover"` pada `<table>`
- [ ] Set width untuk setiap `<th>` dengan style
- [ ] Gunakan `.badge-status` untuk status
- [ ] Gunakan `.btn-action` untuk button
- [ ] Tambah `.cell-content` untuk cell multi-line
- [ ] Gunakan `white-space: nowrap` untuk data singkat
- [ ] Tambah `.table-footer-section` dengan info/pagination
- [ ] Test responsive di mobile (< 768px)

---

## 🚀 Advanced Features

### Empty State:
```html
<div class="table-empty">
    <i class="bi bi-inbox"></i>
    <p>Belum ada data</p>
</div>
```

### Loading Skeleton:
```html
<tr class="table-loading">
    <td><div class="skeleton-line full"></div></td>
    <td><div class="skeleton-line short"></div></td>
    <td><div class="skeleton-line full"></div></td>
</tr>
```

### Pagination:
```html
<div class="table-pagination">
    <button class="pagination-btn" disabled>
        <i class="bi bi-chevron-left"></i>
    </button>
    <span class="pagination-info">Halaman 1 dari 5</span>
    <button class="pagination-btn">
        <i class="bi bi-chevron-right"></i>
    </button>
</div>
```

---

## 📝 Notes

- Semua styling sudah responsive (mobile-first)
- Sticky header otomatis di `<thead>`
- Zebra rows (warna bergantian) otomatis
- Hover effect smooth dan professional
- Touch-friendly untuk mobile
- Aksesibel dengan keyboard navigation

---

## 🔄 Migration Path

1. **Fase 1**: Implementasi di halaman baru/penting (booking, payment)
2. **Fase 2**: Implementasi di halaman existing (gallery, services)
3. **Fase 3**: Fine-tune berdasarkan feedback
4. **Fase 4**: Hapus CSS lama yang tidak dipakai

---

## ❓ Troubleshooting

**Q: Tabel tidak muncul?**
A: Pastikan import CSS sudah benar dan `.table-wrapper` ada.

**Q: Horizontal scroll tidak muncul?**
A: Wrap table dengan `.table-wrapper-scroll`

**Q: Status badge tidak tampil?**
A: Pastikan class `.badge-status.{success|pending|processing|danger}` benar

**Q: Button action terlalu besar?**
A: Gunakan `.btn-action.btn-sm` untuk ukuran kecil

**Q: Mobile masih kurang bagus?**
A: Cek width kolom, mungkin perlu dikurangi atau hide beberapa kolom

---

Selamat mengimplementasikan! 🎉
