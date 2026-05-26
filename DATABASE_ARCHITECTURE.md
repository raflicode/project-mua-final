# 📊 Database & System Architecture
## Yayuk Makeover - Data Storage & Relationships

---

## 🗄️ DATABASE SCHEMA VISUAL

```
                              ┌─────────────────────┐
                              │       user          │
                              ├─────────────────────┤
                              │ id_user (PK)        │
                              │ username (UNIQUE)   │
                              │ email (UNIQUE)      │
                              │ full_name           │
                              │ no_telp             │
                              │ password_hash       │
                              │ role (admin/client) │
                              │ created_at          │
                              │ updated_at          │
                              └──────┬──────────────┘
                                     │
                    ┌────────────────┼────────────────┐
                    │                │                │
                    ▼                ▼                ▼
        ┌──────────────────┐ ┌──────────────┐ ┌──────────────────┐
        │    keranjang     │ │   booking    │ │    pembayaran    │
        ├──────────────────┤ ├──────────────┤ ├──────────────────┤
        │ id_keranjang(PK) │ │ id_booking(P)│ │ id_pembayaran(PK)│
        │ id_user (FK)     │ │ id_user (FK) │ │ id_booking (FK)  │
        │ id_layanan (FK)  │ │ id_jadwal(FK)│ │ jumlah_bayar     │
        │ nama_layanan     │ │ tgl_booking  │ │ metode_bayar     │
        │ tipe_layanan     │ │ total_harga  │ │ bukti_transfer   │
        │ foto             │ │ status       │ │ tgl_upload       │
        │ harga            │ │ catatan      │ │ status_verifikasi│
        │ kuantitas        │ │ created_at   │ │ created_at       │
        │ created_at       │ └──────────────┘ └──────────────────┘
        │ updated_at       │
        └──────────────────┘
                    │
                    └──> ⭐ DELETED saat booking created (TASK 5)
        
                    ┌──────────────────┐
                    │  booking_detail  │
                    ├──────────────────┤
                    │ id_booking_det(P)│
                    │ id_booking (FK)  │
                    │ id_layanan (FK)  │
                    │ qty              │
                    │ harga            │
                    │ subtotal         │
                    │ created_at       │
                    └──────────────────┘
                            │
                            └─> (Menyimpan copy dari keranjang items)
        
        ┌──────────────────┐         ┌─────────────────┐
        │    layanan       │         │  jadwal_kerja   │
        ├──────────────────┤         ├─────────────────┤
        │ id_layanan (PK)  │         │ id_jadwal (PK)  │
        │ nama_layanan     │         │ tanggal         │
        │ kategori_layanan │         │ jam_mulai       │
        │ deskripsi        │         │ jam_selesai     │
        │ harga_dasar      │         │ kapasitas_max   │
        │ foto_layanan     │         │ status_slot     │
        │ is_active        │         │ created_at      │
        │ created_at       │         └─────────────────┘
        │ updated_at       │
        └──────────────────┘
         ▲                  ▲
         │                  │
      (FK in          (FK in
     keranjang)    booking_detail)
```

---

## 🔗 FOREIGN KEY RELATIONSHIPS

```sql
-- user ↔ booking
ALTER TABLE booking
  ADD CONSTRAINT fk_booking_user 
  FOREIGN KEY (id_user) REFERENCES user(id_user)
  ON DELETE CASCADE ON UPDATE CASCADE;

-- user ↔ keranjang
ALTER TABLE keranjang
  ADD CONSTRAINT fk_keranjang_user 
  FOREIGN KEY (id_user) REFERENCES user(id_user)
  ON DELETE CASCADE ON UPDATE CASCADE;

-- layanan ↔ keranjang
ALTER TABLE keranjang
  ADD CONSTRAINT fk_keranjang_layanan 
  FOREIGN KEY (id_layanan) REFERENCES layanan(id_layanan)
  ON DELETE SET NULL ON UPDATE CASCADE;

-- layanan ↔ booking_detail
ALTER TABLE booking_detail
  ADD CONSTRAINT fk_bd_layanan 
  FOREIGN KEY (id_layanan) REFERENCES layanan(id_layanan)
  ON UPDATE CASCADE;

-- booking ↔ booking_detail
ALTER TABLE booking_detail
  ADD CONSTRAINT fk_bd_booking 
  FOREIGN KEY (id_booking) REFERENCES booking(id_booking)
  ON DELETE CASCADE ON UPDATE CASCADE;

-- booking ↔ jadwal_kerja
ALTER TABLE booking
  ADD CONSTRAINT fk_booking_jadwal 
  FOREIGN KEY (id_jadwal) REFERENCES jadwal_kerja(id_jadwal)
  ON UPDATE CASCADE;

-- booking ↔ pembayaran
ALTER TABLE pembayaran
  ADD CONSTRAINT fk_pembayaran_booking 
  FOREIGN KEY (id_booking) REFERENCES booking(id_booking)
  ON DELETE CASCADE ON UPDATE CASCADE;
```

**Cascade Rules:**
- ❌ Delete User → ✅ Delete booking, keranjang
- ❌ Delete Booking → ✅ Delete booking_detail, pembayaran
- ❌ Delete Layanan → ⚠️ Set NULL in keranjang.id_layanan

---

## 📊 TABLE DETAILS

### 1. `user` Table - Identitas Client

```sql
CREATE TABLE user (
  id_user BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  email VARCHAR(100) NOT NULL UNIQUE,
  full_name VARCHAR(100) NOT NULL,
  no_telp VARCHAR(20),
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('admin','client') DEFAULT 'client',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INDEXES:
  - PRIMARY KEY: id_user
  - UNIQUE: username
  - UNIQUE: email
```

**Data Entry:**
```
Registration Form → proses_register.php → INSERT
Login → proses_login.php → SELECT & Verify password
Update Profile → proses_pembayaran.php → UPDATE (full_name, no_telp)
```

---

### 2. `layanan` Table - Product Catalog

```sql
CREATE TABLE layanan (
  id_layanan BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nama_layanan VARCHAR(100) NOT NULL,
  kategori_layanan ENUM('makeup','kostum','dekor','paket') DEFAULT 'makeup',
  deskripsi TEXT,
  harga_dasar DECIMAL(12,2) NOT NULL,
  foto_layanan VARCHAR(255),
  is_active TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INDEXES:
  - PRIMARY KEY: id_layanan
```

**Typical Data:**
```
| id | nama_layanan | kategori | harga_dasar | foto |
|----|----|----------|---------|---------|
| 1  | Makeup Graduation | makeup | 150000 | fotogradu.jpg |
| 2  | Makeup Natural | makeup | 150000 | fotonatural.jpg |
| 10 | Kostum Wedding | kostum | 200000 | kostum_wedding.jpg |
| 20 | Dekor Minimalis | dekor | 800000 | dekor_minimal.jpg |
```

---

### 3. `keranjang` Table - Shopping Cart (TEMP)

```sql
CREATE TABLE keranjang (
  id_keranjang BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  id_user BIGINT UNSIGNED NOT NULL,
  id_layanan BIGINT UNSIGNED,
  nama_layanan VARCHAR(100) NOT NULL,
  tipe_layanan ENUM('makeup','dekor','kostum','paket') NOT NULL,
  foto VARCHAR(255),
  harga DECIMAL(12,2) NOT NULL,
  kuantitas INT DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (id_user) REFERENCES user(id_user) ON DELETE CASCADE,
  FOREIGN KEY (id_layanan) REFERENCES layanan(id_layanan) ON DELETE SET NULL
);

INDEXES:
  - PRIMARY KEY: id_keranjang
  - KEY: idx_keranjang_user (id_user)
  - KEY: idx_keranjang_layanan (id_layanan)
```

**Lifecycle:**
```
INSERT (Add to Cart) 
  ↓
UPDATE (Change Qty) or DELETE (Remove item)
  ↓
proses_pembayaran.php: INSERT keranjang items → booking_detail
  ↓
⭐ DELETE FROM keranjang (Task 5) - Cart cleared!
  ↓
Next login: Empty cart for fresh shopping
```

**Example Data:**
```
| id_user | nama_layanan | tipe | harga | qty |
|---------|-----------|------|-------|-----|
| 5 | Makeup Graduation | makeup | 150000 | 1 |
| 5 | Kostum Wedding | kostum | 200000 | 2 |
```

---

### 4. `jadwal_kerja` Table - Available Time Slots

```sql
CREATE TABLE jadwal_kerja (
  id_jadwal BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  tanggal DATE NOT NULL,
  jam_mulai TIME NOT NULL,
  jam_selesai TIME NOT NULL,
  kapasitas_max INT DEFAULT 1,
  status_slot ENUM('tersedia','penuh','libur') DEFAULT 'tersedia',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INDEXES:
  - PRIMARY KEY: id_jadwal
```

**Example Data (24-hour format):**
```
| id | tanggal | jam_mulai | jam_selesai | kapasitas | status |
|----|---------|-----------|-------------|-----------|--------|
| 100 | 2026-05-27 | 07:00:00 | 09:00:00 | 1 | tersedia |
| 101 | 2026-05-27 | 11:00:00 | 13:00:00 | 1 | tersedia |
| 102 | 2026-05-27 | 15:00:00 | 17:00:00 | 1 | penuh |
```

**Time Labels (Frontend Display):**
```
Pagi   = 07:00 - 10:00 (Morning)
Siang  = 11:00 - 13:00 (Afternoon)
Malam  = 15:00 - 18:00 (Evening)
```

---

### 5. `booking` Table - Customer Orders

```sql
CREATE TABLE booking (
  id_booking BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  id_user BIGINT UNSIGNED NOT NULL,
  id_jadwal BIGINT UNSIGNED NOT NULL,
  tgl_booking DATETIME DEFAULT CURRENT_TIMESTAMP,
  total_harga DECIMAL(12,2) NOT NULL DEFAULT 0,
  status_booking ENUM('pending','dikonfirmasi','selesai','dibatalkan') 
                 DEFAULT 'pending',
  konfirmasi_akhir_token VARCHAR(64),
  bukti_pembayaran VARCHAR(255),
  tanggal_upload DATETIME,
  catatan TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (id_user) REFERENCES user(id_user) ON DELETE CASCADE,
  FOREIGN KEY (id_jadwal) REFERENCES jadwal_kerja(id_jadwal) ON UPDATE CASCADE
);

INDEXES:
  - PRIMARY KEY: id_booking
  - KEY: idx_booking_user (id_user)
  - KEY: idx_booking_jadwal (id_jadwal)
```

**Status Flow:**
```
pending → (user WhatsApp) → dikonfirmasi → konfirmasi 
          (when session starts)              (payment uploaded)
                             ↓
                        (admin verify)
                             ↓
                          selesai (done) atau dibatalkan (cancel)
```

**Example Data:**
```
| id | id_user | id_jadwal | total | status | created_at |
|----|---------|-----------|-------|--------|------------|
| 123 | 5 | 100 | 560000 | pending | 2026-05-27 14:30:00 |
```

---

### 6. `booking_detail` Table - Order Line Items

```sql
CREATE TABLE booking_detail (
  id_booking_detail BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  id_booking BIGINT UNSIGNED NOT NULL,
  id_layanan BIGINT UNSIGNED NOT NULL,
  qty INT NOT NULL DEFAULT 1,
  harga DECIMAL(12,2) NOT NULL,
  subtotal DECIMAL(12,2) NOT NULL,
  catatan_item TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_booking) REFERENCES booking(id_booking) ON DELETE CASCADE,
  FOREIGN KEY (id_layanan) REFERENCES layanan(id_layanan) ON UPDATE CASCADE
);

INDEXES:
  - PRIMARY KEY: id_booking_detail
  - KEY: idx_bookingdetail_booking (id_booking)
  - KEY: idx_bookingdetail_layanan (id_layanan)
```

**Example Data (untuk booking #123):**
```
| id | id_booking | id_layanan | qty | harga | subtotal |
|----|------------|------------|-----|-------|----------|
| 1001 | 123 | 1 | 1 | 150000 | 150000 |
| 1002 | 123 | 10 | 2 | 200000 | 400000 |
```

---

### 7. `pembayaran` Table - Payment Verification

```sql
CREATE TABLE pembayaran (
  id_pembayaran BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  id_booking BIGINT UNSIGNED NOT NULL,
  jumlah_bayar DECIMAL(12,2) NOT NULL,
  metode_bayar ENUM('transfer','cash','ewallet') DEFAULT 'transfer',
  bukti_transfer VARCHAR(255),
  tgl_upload DATETIME DEFAULT CURRENT_TIMESTAMP,
  status_verifikasi ENUM('pending','diterima','ditolak') DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_booking) REFERENCES booking(id_booking) ON DELETE CASCADE
);

INDEXES:
  - PRIMARY KEY: id_pembayaran
  - KEY: idx_pembayaran_booking (id_booking)
```

**Status Flow:**
```
pending → (admin check proof) → diterima (verified) atau ditolak (rejected)
```

**Example Data:**
```
| id | id_booking | jumlah | metode | bukti_transfer | status |
|----|------------|--------|--------|----------------|--------|
| 501 | 123 | 560000 | transfer | bukti_BK123_transfer.jpg | pending |
```

---

## 📈 TRANSACTION FLOW WITH DATA

### ✅ Booking Creation Transaction (proses_pembayaran.php)

```
Session Start:
├─ $_SESSION['id_user'] = 5 (Siti Mulyani)
├─ $_SESSION['draft_booking']['items'] = [
│    {id_layanan: 1, nama: 'Makeup Graduation', harga: 150000, qty: 1},
│    {id_layanan: 10, nama: 'Kostum Wedding', harga: 200000, qty: 2}
│  ]
├─ $_SESSION['draft_booking']['id_jadwal'] = 100
├─ $_SESSION['draft_booking']['total'] = 550000
└─ $_SESSION['pembayaran'] = {nama: 'Siti Mulyani', hp: '08123456789', alamat: '...'}

BEGIN TRANSACTION
│
├─ STEP 1: UPDATE user contact
│  └─ UPDATE user 
│     SET full_name='Siti Mulyani', no_telp='08123456789'
│     WHERE id_user=5
│
├─ STEP 2: INSERT booking
│  └─ INSERT INTO booking (id_user, id_jadwal, total_harga, status_booking, catatan)
│     VALUES (5, 100, 560000, 'pending', '...')
│     → Get: $id_booking = 123
│
├─ STEP 3: INSERT booking_detail (from keranjang items)
│  ├─ INSERT INTO booking_detail (id_booking=123, id_layanan=1, qty=1, harga=150000, subtotal=150000)
│  └─ INSERT INTO booking_detail (id_booking=123, id_layanan=10, qty=2, harga=200000, subtotal=400000)
│
├─ STEP 4: ⭐ DELETE keranjang (NEW in Task 5)
│  └─ DELETE FROM keranjang WHERE id_user=5
│     → keranjang table now EMPTY for user 5
│
└─ COMMIT TRANSACTION

Post-Transaction:
├─ booking table: +1 new record (id_booking=123, status='pending')
├─ booking_detail table: +2 new records (items from keranjang)
├─ keranjang table: -2 records (CLEARED for user 5)
└─ Session update: $_SESSION['draft_booking']['id_booking'] = 123
```

---

## 📱 Data Flow Timing

```
PHASE                  TIME              DATABASE STATE
──────────────────────────────────────────────────────────
Registration          T+0s              user: 1 record
Login                 T+30s             session: populated
Browse + Add Cart     T+2m              keranjang: 2 records
Select Schedule       T+5m              jadwal_kerja: queried
Enter Payment Info    T+7m              session: pembayaran set
Create Booking        T+8m              booking: 1 (pending)
                                        booking_detail: 2
                                        keranjang: 0 ⭐ CLEARED
WhatsApp Confirm      T+10m             booking: 1 (dikonfirmasi)
Upload Payment Proof  T+20m             pembayaran: 1 (pending)
                                        booking: 1 (konfirmasi)
Admin Verify Payment  T+1h              pembayaran: 1 (diterima)
                                        booking: 1 (selesai)
View History          T+2h              Query: booking+detail shown
```

---

## 🔍 QUERY EXAMPLES

### Browse Products
```sql
SELECT id_layanan, nama_layanan, harga_dasar, foto_layanan
FROM layanan
WHERE kategori_layanan = 'makeup' AND is_active = 1
ORDER BY nama_layanan ASC;
```

### View Cart
```sql
SELECT * FROM keranjang
WHERE id_user = 5
ORDER BY created_at DESC;
```

### Create Booking (check availability)
```sql
SELECT COUNT(*) FROM booking b
JOIN jadwal_kerja jk ON b.id_jadwal = jk.id_jadwal
WHERE jk.tanggal = '2026-05-27'
  AND b.status_booking != 'dibatalkan';
-- Result should be < 3 (max 3 bookings per date)
```

### View Order History
```sql
SELECT
    b.id_booking,
    b.total_harga,
    b.status_booking,
    b.created_at,
    GROUP_CONCAT(DISTINCT l.nama_layanan) AS layanan,
    SUM(bd.qty) AS total_items
FROM booking b
LEFT JOIN booking_detail bd ON bd.id_booking = b.id_booking
LEFT JOIN layanan l ON l.id_layanan = bd.id_layanan
WHERE b.id_user = 5
  AND b.status_booking != 'dibatalkan'
GROUP BY b.id_booking
ORDER BY b.created_at DESC;
```

---

## 📊 Database Statistics

```
Expected Table Sizes (per 100 users with active bookings):

user:              ~100 records         (1.5 KB)
layanan:           ~50 records          (500 B) [Admin managed]
keranjang:         ~50 records          (750 B) [Temporary]
jadwal_kerja:      ~365 records         (2 KB) [Time slots]
booking:           ~300 records         (6 KB) [Orders]
booking_detail:    ~600 records         (3 KB) [Order items]
pembayaran:        ~300 records         (4 KB) [Payments]

Total Storage:     ~18 KB per 100 users
Growth Rate:       ~180 KB per year (100 active users)
```

---

## 🛡️ Data Security

```
Password Storage:
└─ password_hash column uses PASSWORD_DEFAULT (bcrypt)
   → Checked: password_verify($input, $hash)

Payment Proof Files:
└─ Stored in: assets/bukti_pembayaran/
   → Validated: MIME type (JPEG/PNG only)
   → Size checked: < 5MB
   → Filename: bukti_{uniqid}_booking_{id}.{ext}

Session Data:
└─ Stored server-side (PHP $_SESSION)
   → Contains: id_user, cart items, draft_booking, pembayaran
   → Cleared after: Logout or session timeout
```

---

## 📋 Data Compliance

```
Data Retention:
├─ user: Permanent (unless account deleted)
├─ layanan: Permanent (admin managed)
├─ keranjang: Deleted after checkout (Task 5)
├─ jadwal_kerja: Permanent (historical record)
├─ booking: Permanent (order history)
├─ booking_detail: Permanent (audit trail)
├─ pembayaran: Permanent (financial record)
└─ Payment proofs: 1-2 years (after completion)

Backup Strategy:
├─ Daily database backup (automated)
├─ Files backup: assets/bukti_pembayaran (weekly)
└─ Transaction logs: Database transaction log
```

---

## ✅ DATA QUALITY CHECKS

```
Constraints Enforced:
├─ PRIMARY KEY: All tables have unique ID
├─ FOREIGN KEY: Referential integrity maintained
├─ UNIQUE: username, email (user table)
├─ NOT NULL: Critical fields enforced
├─ ENUM: Valid status values only
├─ DECIMAL(12,2): Price precision maintained
├─ CASCADE: Orphaned records handled
└─ ON UPDATE: Referential consistency updated

Example Integrity:
├─ Delete user → Auto-delete booking, keranjang
├─ Delete booking → Auto-delete booking_detail, pembayaran
├─ Update id_jadwal → All references updated automatically
└─ Invalid enum → Database rejects insert/update
```

---

**Generated:** 26 Mei 2026  
**Database Version:** 8.0+ / MariaDB 10.4+  
**Character Set:** UTF8MB4 (Full Unicode Support)
