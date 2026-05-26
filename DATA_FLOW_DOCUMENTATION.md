# 📊 Data Flow Documentation - Yayuk Makeover
## Perjalanan Data Client dari Registrasi sampai Booking

**Last Updated:** 26 Mei 2026

---

## 🔍 Ringkasan Umum

```
📋 Registrasi  →  🔐 Login  →  🛍️ Browse  →  🛒 Cart  →  📅 Booking  →  💳 Payment  →  ✅ History
   (user)        (session)   (layanan)    (keranjang) (jadwal_kerja) (pembayaran) (riwayat)
                                                        (booking)
                                                      (booking_detail)
```

---

## 📍 TAHAP 1: REGISTRASI (Register)

### 📄 Halaman: `public/register.php`

**User Input:**
```
┌─────────────────────────────────┐
│ Username        [         ]     │
│ Email           [         ]     │
│ Full Name       [         ]     │
│ No. Telp        [         ]     │
│ Password        [         ]     │
│ Confirm Pass    [         ]     │
└─────────────────────────────────┘
```

### 🔗 Proses: `actions/proses_register.php`

**Validasi Input:**
```
Username     → Not empty, min 3 chars, alphanumeric
Email        → Valid email format, unique
Full Name    → Not empty
No. Telp     → Numeric, 10-12 digits
Password     → Min 8 chars, hashed with PASSWORD_DEFAULT
```

**Data Destination: `user` Table**

```sql
INSERT INTO user (
    username,       ← dari input form
    email,          ← dari input form
    full_name,      ← dari input form
    no_telp,        ← dari input form
    password_hash,  ← hashed password
    role            ← 'client' (default)
) VALUES (?, ?, ?, ?, ?, 'client')
```

### 📊 Database: `user` Table

| Column | Value | Notes |
|--------|-------|-------|
| `id_user` | Auto-increment | Primary key |
| `username` | User input | UNIQUE |
| `email` | User input | UNIQUE |
| `full_name` | User input | - |
| `no_telp` | User input | Optional, updated later |
| `password_hash` | Hashed | 255 chars |
| `role` | 'client' | Enum: admin/client |
| `created_at` | NOW() | Timestamp |
| `updated_at` | NOW() | Timestamp |

**Hasil:** ✅ User berhasil membuat akun

---

## 🔐 TAHAP 2: LOGIN & SESSION

### 📄 Halaman: `public/login.php`

**User Input:**
```
Username/Email  [         ]
Password        [         ]
[  Login  ]
```

### 🔗 Proses: `actions/proses_login.php`

**Query Database:**
```sql
SELECT id_user, username, full_name, password_hash, role
FROM user
WHERE username = ? OR email = ?
```

**Validasi Password:**
```php
password_verify($input_password, $db_password_hash) === true
```

### 💾 Session Storage: `$_SESSION`

```php
$_SESSION['id_user']    = (int) $user['id_user'];
$_SESSION['username']   = $user['username'];
$_SESSION['full_name']  = $user['full_name'];
$_SESSION['role']       = $user['role'];
$_SESSION['logged_in']  = true;
```

**Hasil:** ✅ User logged in, session created

---

## 🛍️ TAHAP 3: BROWSE SERVICES

### 📄 Halaman: `public/service.php` (Kategori) → `public/makeup.php`, `public/kostum.php`, `public/dekor.php`

**Data Source: `layanan` Table**

```sql
SELECT * FROM layanan
WHERE kategori_layanan = 'makeup'  -- atau 'kostum', 'dekor', 'paket'
  AND is_active = 1
ORDER BY nama_layanan ASC
```

### 📊 Database: `layanan` Table

| Column | Example | Notes |
|--------|---------|-------|
| `id_layanan` | 1-999 | Primary key |
| `nama_layanan` | "Makeup Graduation" | Service name |
| `kategori_layanan` | makeup/kostum/dekor/paket | Category |
| `deskripsi` | "Makeup dengan..." | Description |
| `harga_dasar` | 150000.00 | Base price |
| `foto_layanan` | "path/to/image.jpg" | Service image |
| `is_active` | 1 | Active flag |
| `created_at` | Timestamp | Created date |
| `updated_at` | Timestamp | Updated date |

### 📺 Display di Frontend:

```
┌────────────────────────────┐
│  Makeup Graduation         │
│  [Image from foto_layanan] │
│  Rp 150.000               │
│  Deskripsi: Makeup dengan... │
│  [+ ADD TO CART]          │
└────────────────────────────┘
```

**Hasil:** ✅ User melihat service catalog

---

## 🛒 TAHAP 4: ADD TO CART

### 📄 Halaman: `public/makeup.php` / `public/kostum.php` / `public/dekor.php`

**User Action:** Klik "[+ ADD TO CART]"

**JavaScript Handler:** `include/add_to_cart_script.php`

```javascript
addToCart(
    namaLayanan,    // "Makeup Graduation"
    tipeLayanan,    // "makeup"
    harga,          // 150000
    foto,           // path/to/image.jpg
    idLayanan       // 1 (optional)
)
```

### 🔗 API Endpoint: `actions/add_to_cart.php` (POST)

**Request Body:**
```
nama_layanan   = "Makeup Graduation"
tipe_layanan   = "makeup"
harga          = 150000
kuantitas      = 1
foto           = "path/to/image.jpg"
id_layanan     = 1 (optional)
```

**Session Check:**
```php
if (!isset($_SESSION['id_user'])) {
    return error: "Login required"
}
$id_user = $_SESSION['id_user'];
```

### 📊 Database: `keranjang` Table

**Check if already exists:**
```sql
SELECT id_keranjang, kuantitas FROM keranjang
WHERE id_user = ? 
  AND nama_layanan = ? 
  AND tipe_layanan = ?
```

**Case 1: Item sudah ada → UPDATE**
```sql
UPDATE keranjang
SET kuantitas = kuantitas + 1
WHERE id_keranjang = ?
```

**Case 2: Item baru → INSERT**
```sql
INSERT INTO keranjang (
    id_user,        ← dari session
    id_layanan,     ← dari request (optional)
    nama_layanan,   ← dari request
    tipe_layanan,   ← dari request
    foto,           ← dari request
    harga,          ← dari request
    kuantitas       ← 1 (default)
) VALUES (?, ?, ?, ?, ?, ?, 1)
```

### 📊 `keranjang` Table Structure

| Column | Value | Notes |
|--------|-------|-------|
| `id_keranjang` | Auto | Primary key |
| `id_user` | Session | FK → user.id_user |
| `id_layanan` | Request | FK → layanan.id_layanan (optional) |
| `nama_layanan` | Request | Service name |
| `tipe_layanan` | Request | Enum: makeup/dekor/kostum/paket |
| `foto` | Request | Image path |
| `harga` | Request | Price |
| `kuantitas` | 1 | Quantity |
| `created_at` | NOW() | Created |
| `updated_at` | NOW() | Updated |

**Response:**
```json
{
    "success": true,
    "message": "Item ditambahkan ke keranjang",
    "cart_count": 3,
    "action": "added"
}
```

**Hasil:** ✅ Item ditambah ke keranjang

---

## 📋 TAHAP 5: VIEW CART & CHECKOUT

### 📄 Halaman: `public/keranjang.php`

**Load Cart Items dari Database:**
```sql
SELECT * FROM keranjang 
WHERE id_user = ?
ORDER BY created_at DESC
```

**Display:**
```
┌─────────────────────────────────────────────┐
│ [✓] Produk      Harga    Qty    Total  Aksi │
├─────────────────────────────────────────────┤
│ [✓] Makeup      150k     1      150k   [Del]│
│ [✓] Kostum      200k     2      400k   [Del]│
├─────────────────────────────────────────────┤
│ SUBTOTAL: 550k                      [Next]  │
└─────────────────────────────────────────────┘
```

### 🔗 Proses Checkout: `actions/proses_keranjang.php` → `public/booking.php`

**Session Storage (draft_booking):**
```php
$_SESSION['draft_booking'] = [
    'source'          => 'cart',
    'items'           => [ /* all cart items */ ],
    'total'           => 550000,
    'id_jadwal'       => null,  // akan diisi di tahap penjadwalan
];
```

**Hasil:** ✅ Cart siap untuk di-checkout

---

## 📅 TAHAP 6: SCHEDULING & DATE SELECTION

### 📄 Halaman: `public/penjadwalan.php`

**Data Source: `jadwal_kerja` Table**

```sql
SELECT * FROM jadwal_kerja 
ORDER BY tanggal ASC, jam_mulai ASC
```

### 📊 Database: `jadwal_kerja` Table

| Column | Example | Notes |
|--------|---------|-------|
| `id_jadwal` | 1-999 | Primary key |
| `tanggal` | 2026-05-27 | Date |
| `jam_mulai` | 07:00:00 | Start time (24-hour) |
| `jam_selesai` | 10:00:00 | End time |
| `kapasitas_max` | 1 | Max capacity |
| `status_slot` | tersedia | Enum: tersedia/penuh/libur |

**Display Calendar:**
```
      Mei 2026
Su Mo Tu We Th Fr Sa
27 28 29 30 1  2  3    ← User pilih tanggal
...

Pilih Jam:
[ Pagi (07:00-10:00)  ] Open
[ Siang (11:00-13:00) ] Open
[ Malam (15:00-18:00) ] Closed
```

### 🔗 Form Submission

**User Input:**
```
selected_date  = "2026-05-27"
jam_mulai      = "07:00:00"
```

### 📊 Backend Processing: `public/penjadwalan.php` (POST)

**Check slot availability:**
```sql
SELECT COUNT(*) FROM booking b
JOIN jadwal_kerja jk ON b.id_jadwal = jk.id_jadwal
WHERE jk.tanggal = ?
  AND b.status_booking != 'dibatalkan'
```

**If available (< 3 bookings), Create/Update jadwal:**
```sql
INSERT INTO jadwal_kerja (
    tanggal,        ← dari user input
    jam_mulai,      ← dari user input
    jam_selesai,    ← jam_mulai + 2 hours
    kapasitas_max,  ← 1
    status_slot     ← 'tersedia'
) VALUES (?, ?, ?, 1, 'tersedia')
```

**Get inserted ID:**
```php
$id_jadwal = $pdo->lastInsertId();
```

**Update session:**
```php
$_SESSION['draft_booking']['id_jadwal'] = $id_jadwal;
$_SESSION['draft_booking']['tanggal'] = "2026-05-27";
$_SESSION['draft_booking']['jam_mulai'] = "07:00:00";
```

**Redirect:** → `public/pembayaran.php`

**Hasil:** ✅ Jadwal dipilih, data tersimpan di session

---

## 💳 TAHAP 7: PAYMENT DETAILS & BOOKING CREATION

### 📄 Halaman: `public/pembayaran.php`

**Form Input:**
```
Nama Lengkap    [User Name    ]
No. HP          [08123456789  ]
Alamat/Catatan  [Jl. Xxx...   ]
Metode Bayar    [Transfer ▼  ]
[Konfirmasi]
```

### 🔗 Proses: `actions/proses_pembayaran.php` (POST)

**Session Verification:**
```php
if (!isset($_SESSION['draft_booking']))
    if (!isset($_SESSION['draft_booking']['id_jadwal']))
        return redirect to penjadwalan
```

**Input Validation:**
```
nama     → Not empty, letters + spaces only
hp       → 10-12 digits
alamat   → Not empty
```

**Update User Contact (Optional):**
```sql
UPDATE user
SET full_name = ?, no_telp = ?
WHERE id_user = ?
```

### 📊 Create Booking Transaction

**Begin Transaction:**
```php
$pdo->beginTransaction();
```

**Insert into `booking` table:**
```sql
INSERT INTO booking (
    id_user,            ← from session
    id_jadwal,          ← from session draft_booking
    total_harga,        ← cart subtotal + 10000 fee
    status_booking,     ← 'pending'
    catatan,            ← from form input (alamat)
    no_telp,            ← from form input
    tgl_booking         ← NOW()
) VALUES (?, ?, ?, 'pending', ?, ?, NOW())
```

**Get Booking ID:**
```php
$id_booking = $pdo->lastInsertId();
```

### 📊 Database: `booking` Table

| Column | Value | Notes |
|--------|-------|-------|
| `id_booking` | Auto | Primary key |
| `id_user` | Session | FK → user.id_user |
| `id_jadwal` | Session | FK → jadwal_kerja.id_jadwal |
| `tgl_booking` | NOW() | Booking timestamp |
| `total_harga` | Cart + 10k | Total price |
| `status_booking` | pending | Enum status |
| `konfirmasi_akhir_token` | NULL | For payment confirmation |
| `bukti_pembayaran` | NULL | Payment proof path |
| `tanggal_upload` | NULL | Proof upload date |
| `catatan` | Form input | Address/notes |

**Insert Cart Items → `booking_detail`:**

```sql
INSERT INTO booking_detail (
    id_booking,     ← dari lastInsertId()
    id_layanan,     ← dari keranjang.id_layanan atau create baru
    qty,            ← dari keranjang.kuantitas
    harga,          ← dari keranjang.harga
    subtotal        ← qty * harga
) VALUES (?, ?, ?, ?, ?)
```

**For each item in cart:**
```php
foreach ($draft['items'] as $item) {
    $id_layanan = $item['id_layanan'] ?? 
                  findOrCreateLayananAwal(...); // Create service if not exist
    
    INSERT INTO booking_detail (...)
}
```

### 📊 Database: `booking_detail` Table

| Column | Value | Notes |
|--------|-------|-------|
| `id_booking_detail` | Auto | Primary key |
| `id_booking` | Inserted | FK → booking.id_booking |
| `id_layanan` | From item | FK → layanan.id_layanan |
| `qty` | From item | Quantity |
| `harga` | From item | Unit price |
| `subtotal` | qty * harga | Line total |
| `catatan_item` | NULL | Item notes |

**✅ NEW (Task 5): Clear Cart**

```sql
DELETE FROM keranjang WHERE id_user = ?
```

**Commit Transaction:**
```php
$pdo->commit();
```

**Update Session:**
```php
$_SESSION['draft_booking']['id_booking'] = $id_booking;
$_SESSION['pembayaran'] = [
    'nama' => $nama,
    'hp' => $hp,
    'alamat' => $alamat,
    'catatan' => $catatan
];
```

**Redirect:** → `public/konfirmasi_awal.php`

**Hasil:** ✅ Booking created dengan status 'pending'

---

## ✅ TAHAP 8: CONFIRMATION & WHATSAPP

### 📄 Halaman: `public/konfirmasi_awal.php`

**Display Booking Summary:**
```
┌──────────────────────────────┐
│ KONFIRMASI BOOKING           │
├──────────────────────────────┤
│ ID Booking: #BK001           │
│ Nama: John Doe               │
│ No HP: 08123456789           │
│ Services: Makeup + Kostum    │
│ Tanggal: 27 Mei 2026        │
│ Jam: 07:00 - 10:00          │
│ Total: Rp 560.000           │
├──────────────────────────────┤
│ [Konfirmasi via WhatsApp]   │
│ [Batalkan]                  │
└──────────────────────────────┘
```

**✅ NEW (Task 4): WhatsApp Auto-Redirect**

```javascript
function confirmAndRedirect() {
    const waUrl = '<?= htmlspecialchars($waUrl); ?>';
    window.open(waUrl, '_blank', 'noopener');
    setTimeout(() => {
        window.location.href = '../index.php';  // Redirect to home after 1 second
    }, 1000);
}
```

**Session State:**
```php
$_SESSION['draft_booking'] = [
    'id_booking' => 123,
    'id_jadwal' => 456,
    'items' => [...],
    'total' => 560000,
    'source' => 'cart'
]

$_SESSION['pembayaran'] = [
    'nama' => 'John Doe',
    'hp' => '08123456789',
    'alamat' => 'Jl. Xxx',
    'catatan' => 'catatan'
]
```

**Hasil:** ✅ User kirim WhatsApp confirmation, redirect to home

---

## 💰 TAHAP 9: PAYMENT CONFIRMATION & PROOF

### 📄 Halaman: `public/konfirmasi_akhir.php`

**After payment confirmation via WhatsApp, user uploads proof:**

**Form Input:**
```
Metode Bayar    [Transfer ▼]
Bukti Pembayaran [Choose file]
                [Upload]
```

### 🔗 Proses: `actions/proses_konfirmasi.php` (POST)

**File Upload Validation:**
```php
$file = $_FILES['bukti_pembayaran']
- mime type: JPEG/PNG only
- size: max 5MB
- error: UPLOAD_ERR_OK
```

**Save file:**
```php
$fileName = uniqid('bukti_') . '_booking_' . $id_booking . '.jpg';
move_uploaded_file($file['tmp_name'], '../assets/bukti_pembayaran/' . $fileName)
```

**Begin Transaction:**
```php
$pdo->beginTransaction();
```

**Update `booking` table:**
```sql
UPDATE booking
SET bukti_pembayaran = ?,
    tanggal_upload = NOW(),
    status_booking = 'konfirmasi'
WHERE id_booking = ?
```

### 📊 Database: `pembayaran` Table

**Check if pembayaran record exists:**
```sql
SELECT id_pembayaran FROM pembayaran WHERE id_booking = ?
```

**If exists → UPDATE:**
```sql
UPDATE pembayaran
SET bukti_transfer = ?,
    metode_bayar = ?,
    tgl_upload = NOW(),
    status_verifikasi = 'pending'
WHERE id_pembayaran = ?
```

**If not exists → INSERT:**
```sql
INSERT INTO pembayaran (
    id_booking,         ← from booking
    jumlah_bayar,       ← from booking.total_harga
    metode_bayar,       ← from form
    bukti_transfer,     ← file name
    status_verifikasi   ← 'pending'
) VALUES (?, ?, ?, ?, 'pending')
```

### 📊 `pembayaran` Table Structure

| Column | Value | Notes |
|--------|-------|-------|
| `id_pembayaran` | Auto | Primary key |
| `id_booking` | Inserted | FK → booking.id_booking |
| `jumlah_bayar` | booking.total | Amount to pay |
| `metode_bayar` | Form input | transfer/cash/ewallet |
| `bukti_transfer` | Filename | Payment proof path |
| `tgl_upload` | NOW() | Upload date |
| `status_verifikasi` | pending | Enum status |

**Commit Transaction:**
```php
$pdo->commit();
```

**Status Flow:**
```
booking: pending ──> dikonfirmasi ──> konfirmasi
pembayaran: pending ──> (admin verify) ──> diterima/ditolak
```

**Hasil:** ✅ Payment proof uploaded, status updated to 'konfirmasi'

---

## 📊 TAHAP 10: ORDER HISTORY

### 📄 Halaman: `public/riwayat_pesanan.php`

**Query All Bookings:**
```sql
SELECT
    b.id_booking,
    b.total_harga,
    b.status_booking,
    b.created_at,
    GROUP_CONCAT(DISTINCT l.nama_layanan) AS nama_layanan,
    SUM(bd.qty) AS total_qty
FROM booking b
LEFT JOIN booking_detail bd ON bd.id_booking = b.id_booking
LEFT JOIN layanan l ON l.id_layanan = bd.id_layanan
WHERE b.id_user = ?
  AND b.status_booking != 'dibatalkan'
GROUP BY b.id_booking
ORDER BY b.created_at DESC
```

**Display History:**
```
┌───────────────────────────────────────────────┐
│ RIWAYAT PESANAN                              │
├───────────────────────────────────────────────┤
│ [1] Makeup + Kostum                          │
│     Rp 560.000  │  Selesai  │  27 Mei 2026  │
├───────────────────────────────────────────────┤
│ [2] Dekor                                    │
│     Rp 800.000  │  Pending  │  26 Mei 2026  │
└───────────────────────────────────────────────┘
```

**Status Badge:**
- `pending` → "Menunggu Konfirmasi"
- `dikonfirmasi` → "Dikonfirmasi"
- `konfirmasi` → "Menunggu Pembayaran"
- `selesai` → "Selesai"
- `dibatalkan` → "Dibatalkan" (hidden)

**Hasil:** ✅ User dapat melihat semua booking history

---

## 🗂️ SUMMARY: Data Flow Tabel

```
┌─────────┐
│  user   │  Registration: (id_user, username, email, full_name, no_telp, role)
└────┬────┘
     │
     ├──> keranjang ────────────┐
     │    (id_user, nama_layanan,│
     │     tipe_layanan, harga,  │
     │     kuantitas)            │
     │                           │
     └──> booking ◄─────────────┘
          (id_user, id_jadwal,
           total_harga, status)
             │
             ├──> booking_detail (id_booking, id_layanan, qty)
             │    (from keranjang items)
             │
             └──> pembayaran (id_booking, jumlah_bayar, 
                  metode_bayar, bukti_transfer)
                     
jadwal_kerja
(tanggal, jam_mulai, jam_selesai, status_slot)
    │
    └──> ← Referenced by booking.id_jadwal

layanan
(nama_layanan, kategori, harga_dasar, foto_layanan)
    │
    └──> ← Referenced by booking_detail.id_layanan
    └──> ← Referenced by keranjang.id_layanan
```

---

## 📊 Data Lifecycle per Table

### 1️⃣ `user` Table
- **Created:** User registration
- **Updated:** Admin update profile / system update contact
- **Deleted:** (Cascade: booking, keranjang)
- **Lifecycle:** Registration → Active → Account management

### 2️⃣ `layanan` Table
- **Created:** Admin add service
- **Updated:** Admin edit service details
- **Deleted:** Admin delete (Cascade: booking_detail, keranjang)
- **Lifecycle:** Admin creates → Display on frontend → Referenced in bookings

### 3️⃣ `keranjang` Table
- **Created:** User add to cart
- **Updated:** User change quantity
- **Deleted:** User remove / User checkout (proses_pembayaran)
- **Lifecycle:** Add → View cart → Checkout → ✅ **DELETE** (NEW in Task 5)

### 4️⃣ `jadwal_kerja` Table
- **Created:** System creates when user picks time slot
- **Updated:** Admin manage schedule
- **Deleted:** Admin delete schedule
- **Lifecycle:** Create on demand → Referenced in booking → Used for availability check

### 5️⃣ `booking` Table
- **Created:** User checkout (proses_pembayaran)
- **Updated:** Status changes (pending → dikonfirmasi → konfirmasi → selesai)
- **Status:** pending (awal) → dikonfirmasi (after WhatsApp) → konfirmasi (after payment) → selesai (admin complete)
- **Lifecycle:** Create → Update status → Complete → View in history

### 6️⃣ `booking_detail` Table
- **Created:** User checkout (proses_pembayaran) - from keranjang items
- **Updated:** Not usually updated
- **Deleted:** (Cascade: booking deleted)
- **Lifecycle:** Insert once → Permanent record of what was ordered

### 7️⃣ `pembayaran` Table
- **Created:** After user checkout OR when payment proof uploaded
- **Updated:** Payment status verification
- **Status:** pending → diterima / ditolak
- **Lifecycle:** Create pending → Admin verify → Mark received/rejected

---

## 🔄 Field Transformation Through Flow

### Example: User Selects "Makeup Graduation (Rp 150.000)"

```
Step 1: Display (layanan table)
├─ id_layanan: 1
├─ nama_layanan: "Makeup Graduation"
├─ harga_dasar: 150000
└─ foto_layanan: "path/to/image.jpg"

Step 2: Add to Cart (keranjang table)
├─ id_layanan: 1 (optional)
├─ nama_layanan: "Makeup Graduation" ✅
├─ tipe_layanan: "makeup"
├─ harga: 150000 ✅
├─ kuantitas: 1
├─ foto: "path/to/image.jpg"
└─ (same data, different context)

Step 3: Checkout (booking_detail table)
├─ id_layanan: 1 (FK)
├─ qty: 1
├─ harga: 150000 ✅
├─ subtotal: 150000
└─ (itemized for permanence)

Step 4: History (riwayat_pesanan query)
├─ Join booking + booking_detail + layanan
├─ Display: "Makeup Graduation"
├─ Amount: "Rp 150.000"
└─ ✅ Data tetap konsisten
```

---

## ⚠️ Data Integrity Points

### Foreign Key Relationships:
```
booking.id_user ──FK──> user.id_user
booking.id_jadwal ──FK──> jadwal_kerja.id_jadwal
booking_detail.id_booking ──FK──> booking.id_booking
booking_detail.id_layanan ──FK──> layanan.id_layanan
pembayaran.id_booking ──FK──> booking.id_booking
keranjang.id_user ──FK──> user.id_user
keranjang.id_layanan ──FK──> layanan.id_layanan
```

### ON DELETE CASCADE:
- Delete user → Delete booking, keranjang
- Delete booking → Delete booking_detail, pembayaran
- Delete layanan → Set NULL in keranjang.id_layanan

### Transactions (ACID):
- `proses_pembayaran.php`: BEGIN → INSERT booking → INSERT booking_detail → DELETE keranjang → COMMIT
- `proses_konfirmasi.php`: BEGIN → UPDATE booking → INSERT/UPDATE pembayaran → COMMIT

---

## 🎯 KEY DATA FLOW STEPS SUMMARY

| # | Step | From | To | Status |
|---|------|------|-----|--------|
| 1 | Register | Form → `proses_register.php` | `user` | ✅ Create |
| 2 | Login | Form → `proses_login.php` | `$_SESSION` | ✅ Auth |
| 3 | Browse | Query `layanan` | Frontend display | ✅ Read |
| 4 | Add Cart | `add_to_cart.php` | `keranjang` | ✅ Create |
| 5 | Update Cart | `update_cart.php` | `keranjang` | ✅ Update |
| 6 | Select Schedule | Form → `penjadwalan.php` | `jadwal_kerja` + `$_SESSION` | ✅ Create + Store |
| 7 | Enter Payment Details | Form → `proses_pembayaran.php` | `$_SESSION['pembayaran']` | ✅ Store |
| 8 | Create Booking | `proses_pembayaran.php` | `booking` | ✅ Create (pending) |
| 9 | Create Order Details | `proses_pembayaran.php` | `booking_detail` | ✅ Create |
| 10 | ✅ NEW: Clear Cart | `proses_pembayaran.php` | DELETE `keranjang` | ✅ Delete |
| 11 | ✅ NEW: Redirect | `konfirmasi_awal.php` | Home page | ✅ Redirect |
| 12 | Upload Payment Proof | Form → `proses_konfirmasi.php` | `pembayaran` | ✅ Create/Update |
| 13 | Update Status | `proses_konfirmasi.php` | `booking` | ✅ Update (konfirmasi) |
| 14 | View History | Query `booking` + `booking_detail` | `riwayat_pesanan.php` | ✅ Read |

---

## 📁 File References

### Registration & Login
- `public/register.php` - Register form
- `public/login.php` - Login form
- `actions/proses_register.php` - Register handler
- `actions/proses_login.php` - Login handler

### Cart & Checkout
- `public/makeup.php`, `public/kostum.php`, `public/dekor.php` - Product pages
- `public/keranjang.php` - Cart display
- `actions/add_to_cart.php` - Add item API
- `actions/update_cart.php` - Update quantity
- `actions/remove_from_cart.php` - Remove item
- `actions/proses_keranjang.php` - Cart helpers

### Booking Flow
- `public/penjadwalan.php` - Schedule selection
- `public/pembayaran.php` - Payment details form
- `actions/proses_pembayaran.php` - **Booking creation + Cart clear (Task 5)**
- `public/konfirmasi_awal.php` - **WhatsApp confirmation + Auto-redirect (Task 4)**
- `public/konfirmasi_akhir.php` - Payment proof upload
- `actions/proses_konfirmasi.php` - Payment processing

### History
- `public/riwayat_pesanan.php` - Order history display

### Database
- `database/db_mua.sql` - Schema

---

## 💡 Notes

- **Session Data:** Temporary storage during checkout flow, cleared after confirmation
- **Transaction Safety:** Payment & booking operations wrapped in DB transactions
- **Data Normalization:** Product names stored in both keranjang (temporary) and booking_detail (permanent)
- **Audit Trail:** All tables have `created_at` and `updated_at` timestamps
- **User Privacy:** Passwords hashed, contact info optional in registration

---

**Document Status:** ✅ Complete  
**Last Updated:** 26 Mei 2026  
**Data Flow Version:** 2.0 (Post-Task-5 Revisions)
