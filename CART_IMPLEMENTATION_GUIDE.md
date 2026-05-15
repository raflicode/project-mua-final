# 📋 PANDUAN IMPLEMENTASI SISTEM KERANJANG USER

## ✅ YANG SUDAH SELESAI

### 1. Database
- ✅ Tabel `keranjang` sudah ditambahkan ke `database/db_mua.sql`
- Kolom: `id_keranjang`, `id_user`, `nama_layanan`, `tipe_layanan`, `harga`, `kuantitas`, `created_at`, `updated_at`
- **PENTING:** Jalankan SQL migration untuk membuat tabel

```bash
# Di phpmyadmin atau console MySQL:
mysql -u root -p db_mua < database/db_mua.sql
```

### 2. Backend API (Actions)
- ✅ `actions/add_to_cart.php` - Menambah item ke keranjang
- ✅ `actions/remove_from_cart.php` - Menghapus item dari keranjang
- ✅ `actions/update_cart.php` - Mengubah quantity item
- ✅ `actions/get_cart_count.php` - Ambil total quantity keranjang

### 3. Frontend
- ✅ `public/include/navbar.php` - Update untuk:
  - Sembunyikan link keranjang saat belum login
  - Tampilkan cart count badge dari database
  - Update cart count secara real-time

- ✅ `public/keranjang.php` - Rewrite untuk:
  - Fetch data dari database per user
  - Redirect ke login jika belum login
  - Handle add/remove/update via API

- ✅ `public/service.php` - Update untuk:
  - Import SweetAlert2
  - Ubah tombol "Keranjang" → "Tambah Keranjang"
  - Call function `addToCart()` saat diklik

- ✅ `public/include/add_to_cart_script.php` - Helper script dengan:
  - Function `addToCart(nama, tipe, harga)`
  - Auto-login redirect jika belum login
  - Success/error notifications

---

## 🧪 CARA TESTING

### Step 1: Setup Database
1. Buka PhpMyAdmin atau MySQL command line
2. Jalankan `db_mua.sql` dari `database/db_mua.sql`
3. Verifikasi tabel `keranjang` sudah dibuat

```sql
SHOW TABLES;
DESCRIBE keranjang;
```

### Step 2: Login sebagai User
1. Buka `http://localhost/project-mua-final/index.php`
2. Klik Login
3. Gunakan email: `rafliclient@gmail.com` password: `12345678` (atau user lain)

### Step 3: Cek Navbar
- ✅ Logo keranjang harus tampil di navbar (hanya saat login)
- ✅ Badge cart count harus tampil (default: 0 jika keranjang kosong)

### Step 4: Test Add to Cart
1. Buka `Service` page (`public/service.php`)
2. Lihat 3 paket: Makeup Wedding, Wedding Kostum, Dekor Terop
3. Klik tombol "Tambah Keranjang"
4. SweetAlert2 akan show success notification
5. Cart badge di navbar akan update (+1)

### Step 5: Cek Database
```sql
SELECT * FROM keranjang WHERE id_user = 2;
```
Seharusnya ada 1 baris dengan:
- `nama_layanan` = "Makeup Wedding"
- `tipe_layanan` = "makeup"
- `harga` = 2500000
- `kuantitas` = 1

### Step 6: Test Keranjang Page
1. Klik logo keranjang di navbar
2. Seharusnya redirect ke `public/keranjang.php`
3. Lihat item yang baru ditambah
4. Test aksi:
   - Ubah quantity dengan +/- button
   - Check total harga update otomatis
   - Hapus item
   - Cart count di navbar update

### Step 7: Test Multiple Items
1. Tambah lebih dari 1 item dari service page
2. Cek keranjang page menampilkan semua items
3. Test select/deselect items
4. Test "Pilih Semua" checkbox
5. Test "Hapus" button untuk selected items

### Step 8: Test Login Requirement
1. Logout dari aplikasi
2. Coba akses `public/keranjang.php` langsung
3. Seharusnya redirect ke login page

### Step 9: Test Not Logged In User
1. Logout
2. Kembali ke home page
3. Logo keranjang tidak boleh tampil di navbar
4. Coba klik "Tambah Keranjang" (jika bisa)
5. Seharusnya muncul SweetAlert "Login Diperlukan"

---

## 🔗 FILE-FILE YANG DIMODIFIKASI

| File | Status | Perubahan |
|------|--------|-----------|
| `database/db_mua.sql` | ✅ Selesai | Tambah tabel keranjang |
| `public/include/navbar.php` | ✅ Selesai | Conditional cart link + cart count |
| `public/keranjang.php` | ✅ Selesai | Fetch dari DB + API calls |
| `public/service.php` | ✅ Selesai | Tambah button + SweetAlert |
| `public/include/add_to_cart_script.php` | ✅ Selesai | NEW helper script |
| `actions/add_to_cart.php` | ✅ Selesai | NEW API endpoint |
| `actions/remove_from_cart.php` | ✅ Selesai | NEW API endpoint |
| `actions/update_cart.php` | ✅ Selesai | NEW API endpoint |
| `actions/get_cart_count.php` | ✅ Selesai | NEW API endpoint |

---

## 📌 LANGKAH SELANJUTNYA (OPTIONAL)

Untuk file-file lain (makeup.php, dekor.php, kostum.php, paket_gold.php, paket_silver.php), ikuti pola yang sama:

1. Import SweetAlert2 di `<head>`
2. Include `add_to_cart_script.php` sebelum closing `</body>`
3. Ubah tombol "Keranjang" menjadi button dengan `onclick="addToCart(...)"`

### Contoh untuk makeup.php:
```html
<!-- Di head -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Sebelum </body> -->
<?php include 'include/add_to_cart_script.php'; ?>

<!-- Ubah tombol dari -->
<a href="keranjang.php" class="btn btn-primary">Keranjang</a>

<!-- Menjadi -->
<button onclick="addToCart('Makeup Paket A', 'makeup', 1500000)" class="btn btn-primary">
  Tambah Keranjang
</button>
```

---

## ⚠️ TROUBLESHOOTING

### Masalah: Keranjang link tidak tampil saat login
- Cek: `$_SESSION['id_user']` di navbar.php
- Pastikan session_start() dipanggil

### Masalah: Cart count tidak update
- Cek browser console untuk fetch errors
- Pastikan `get_cart_count.php` dapat diakses
- Verifikasi session user aktif

### Masalah: Add to cart tidak jalan
- Cek SweetAlert2 sudah loaded
- Cek `add_to_cart_script.php` sudah included
- Verifikasi database connection

### Masalah: Data tidak tersimpan di database
- Cek tabel `keranjang` sudah dibuat
- Verifikasi user ID di session
- Cek error message di SweetAlert2

---

## 📧 API REQUEST/RESPONSE REFERENCE

### Add to Cart
```bash
POST /project-mua-final/actions/add_to_cart.php

Request Body:
- nama_layanan=Makeup Wedding
- tipe_layanan=makeup
- harga=2500000
- kuantitas=1

Response Success:
{
  "success": true,
  "message": "Item ditambahkan ke keranjang",
  "cart_count": 3,
  "action": "added"
}

Response Error (Not Logged In):
{
  "success": false,
  "message": "Silakan login terlebih dahulu"
}
```

### Remove from Cart
```bash
POST /project-mua-final/actions/remove_from_cart.php

Request Body:
- id_keranjang=5

Response Success:
{
  "success": true,
  "message": "Item dihapus dari keranjang",
  "cart_count": 2
}
```

### Update Quantity
```bash
POST /project-mua-final/actions/update_cart.php

Request Body:
- id_keranjang=5
- kuantitas=3

Response Success:
{
  "success": true,
  "message": "Kuantitas diperbarui"
}
```

### Get Cart Count
```bash
GET /project-mua-final/actions/get_cart_count.php

Response:
{
  "cart_count": 5
}
```

---

Berhasil! 🎉 Sistem keranjang user sudah terintegrasi sepenuhnya.
