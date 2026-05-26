# 📊 Data Flow Ringkas - Quick Reference
## Dari Registrasi sampai Booking

---

## 🎯 CHART: Perjalanan Data Client

```
┌──────────────────────────────────────────────────────────────────────────────┐
│                          YAYUK MAKEOVER - DATA FLOW                          │
└──────────────────────────────────────────────────────────────────────────────┘

FASE 1: AUTHENTICATION
───────────────────────
👤 Client Register
   ├─ Input: Username, Email, Password, Nama, NoHP
   └─ Database: ✅ INSERT into `user` table
                  (id_user, username, email, full_name, no_telp, password_hash)

📧 Client Login
   ├─ Query: SELECT from `user` WHERE username/email
   └─ Session: ✅ SET $_SESSION[id_user, username, full_name, role]


FASE 2: BROWSE & SHOP
────────────────────
🛍️ View Categories (Makeup/Dekor/Kostum)
   ├─ Query: SELECT * FROM `layanan` WHERE kategori = 'makeup'
   └─ Display: Product cards dengan nama, harga, foto

🛒 Add to Cart
   ├─ JavaScript: addToCart(nama, tipe, harga, foto, idLayanan)
   ├─ API Call: POST to `actions/add_to_cart.php`
   ├─ Session Check: IF id_user NOT IN SESSION → LOGIN REQUIRED
   └─ Database: ✅ INSERT/UPDATE `keranjang` table
                  (id_user, nama_layanan, tipe_layanan, harga, kuantitas, foto)

📋 View Cart
   ├─ Query: SELECT * FROM `keranjang` WHERE id_user
   └─ Display: List items dengan checkbox, harga, qty, subtotal


FASE 3: SCHEDULING
──────────────────
📅 Select Date
   ├─ Query: SELECT * FROM `jadwal_kerja` ORDER BY tanggal
   └─ Display: Calendar dengan slot availability

🕐 Select Time Slot
   ├─ Slots: Pagi (07:00), Siang (11:00), Malam (15:00) [24-hour format]
   ├─ Check: COUNT booking di tanggal itu (max 3)
   └─ If available → INSERT into `jadwal_kerja`
                     (tanggal, jam_mulai, jam_selesai, kapasitas_max)
   
   ✅ Store to Session:
      $_SESSION['draft_booking']['id_jadwal'] = id dari jadwal_kerja
      $_SESSION['draft_booking']['items'] = all keranjang items


FASE 4: PAYMENT FORM
────────────────────
💳 Enter Details
   ├─ Input: Nama, NoHP, Alamat, Metode Bayar
   ├─ Validate: Nama (letters only), NoHP (10-12 digits), Alamat (not empty)
   └─ Session: ✅ SET $_SESSION['pembayaran'] = [nama, hp, alamat, catatan]


FASE 5: CREATE BOOKING 🔥 [NEW IN TASK 5]
───────────────────────────────
📦 CREATE BOOKING TRANSACTION
   ├─ BEGIN TRANSACTION
   │
   ├─ STEP 1: UPDATE user contact info (optional)
   │   └─ UPDATE `user` SET full_name, no_telp WHERE id_user
   │
   ├─ STEP 2: Create booking record
   │   └─ ✅ INSERT into `booking` table
   │       (id_user, id_jadwal, total_harga, status='pending', catatan, no_telp)
   │       → Get $id_booking = lastInsertId()
   │
   ├─ STEP 3: Move cart items to booking_detail
   │   ├─ FOR EACH item in keranjang:
   │   │  └─ ✅ INSERT into `booking_detail` table
   │   │      (id_booking, id_layanan, qty, harga, subtotal)
   │   └─ Handle missing id_layanan (auto-create from keranjang nama)
   │
   ├─ STEP 4: ⭐ CLEAR CART [NEW]
   │   └─ ✅ DELETE FROM `keranjang` WHERE id_user
   │       → Cart items now in booking_detail, keranjang kosong!
   │
   └─ COMMIT TRANSACTION
      
   ✅ Update Session:
      $_SESSION['draft_booking']['id_booking'] = $id_booking


FASE 6: WHATSAPP CONFIRMATION 🔥 [NEW IN TASK 4]
──────────────────────────────────────
📲 Show Booking Summary
   ├─ Display: ID, Nama, NoHP, Layanan, Tanggal, Jam, Total
   └─ Message template: "Booking #ID untuk John Doe, Makeup + Kostum, Rp560k"

💬 Click "Konfirmasi via WhatsApp"
   ├─ ⭐ NEW JavaScript Handler
   ├─ STEP 1: Open WhatsApp in new tab
   │   └─ window.open(waUrl, '_blank', 'noopener')
   │
   └─ STEP 2: Auto-redirect to home after 1 second
       └─ setTimeout(() => {
              window.location.href = '../index.php'
           }, 1000)
       
   Result: User back at home, WhatsApp open untuk confirmation


FASE 7: PAYMENT PROOF
─────────────────────
📸 Upload Bukti Transfer
   ├─ Input: Metode Bayar (Transfer/Cash/E-wallet), File JPG/PNG
   ├─ Validate: MIME type, File size (max 5MB)
   └─ Save: File ke `assets/bukti_pembayaran/bukti_*.jpg`

💾 Create Payment Record
   ├─ BEGIN TRANSACTION
   │
   ├─ UPDATE `booking` SET bukti_pembayaran, tanggal_upload, status='konfirmasi'
   │
   └─ INSERT/UPDATE `pembayaran` table
      (id_booking, jumlah_bayar, metode_bayar, bukti_transfer, status='pending')
      → Status = 'pending' tunggu admin verifikasi
   
   └─ COMMIT TRANSACTION


FASE 8: ORDER HISTORY 📋
────────────────────────
📊 View Riwayat Pesanan
   └─ Query: SELECT b.*, bd.qty, l.nama_layanan
            FROM booking b
            LEFT JOIN booking_detail bd
            LEFT JOIN layanan l
            WHERE b.id_user = ?
            GROUP BY b.id_booking
            ORDER BY b.created_at DESC

   Display:
   ┌─────────────────────────────────────┐
   │ #BK001 | Makeup + Kostum | Selesai │
   │ Rp560k | 27 Mei 2026               │
   ├─────────────────────────────────────┤
   │ #BK002 | Dekor | Pending           │
   │ Rp800k | 26 Mei 2026               │
   └─────────────────────────────────────┘
```

---

## 🗂️ DATABASE TABLES - Yang Tersentuh

| Tabel | Kapan | Operasi | Data |
|-------|-------|---------|------|
| **user** | Register | INSERT | id_user, username, email, full_name, no_telp, password_hash, role |
| **layanan** | Browse | SELECT | id_layanan, nama_layanan, kategori, harga, foto |
| **keranjang** | Add Cart | INSERT/UPDATE | id_user, nama_layanan, tipe_layanan, harga, qty, foto |
| **keranjang** | ⭐ Checkout | DELETE | Clear all items for user |
| **jadwal_kerja** | Schedule | INSERT/SELECT | tanggal, jam_mulai, jam_selesai, kapasitas, status |
| **booking** | Checkout | INSERT | id_user, id_jadwal, total, status, catatan |
| **booking** | Payment | UPDATE | bukti_pembayaran, status='konfirmasi' |
| **booking_detail** | Checkout | INSERT | id_booking, id_layanan, qty, harga, subtotal |
| **pembayaran** | Payment | INSERT/UPDATE | id_booking, jumlah_bayar, metode, bukti, status |

---

## 🔄 CONTOH REAL DATA FLOW

### Scenario: Siti Mulyani booking Makeup + Kostum

```
1️⃣ REGISTRASI
   Input: username=siti2024, email=siti@email.com, pwd=***
   → user table gets: id_user=5, username='siti2024', email='siti@email.com', 
                      full_name=NULL, no_telp=NULL, role='client'

2️⃣ LOGIN
   Session: $_SESSION['id_user']=5, $_SESSION['username']='siti2024'

3️⃣ BROWSE MAKEUP
   Query: SELECT * FROM layanan WHERE kategori='makeup' AND is_active=1
   Display: 
   - Makeup Graduation (150k)
   - Makeup Natural (150k)
   - Makeup Flawless (150k)
   etc.

4️⃣ ADD MAKEUP GRADUATION TO CART
   POST to add_to_cart.php:
   {
     nama_layanan: 'Makeup Graduation',
     tipe_layanan: 'makeup',
     harga: 150000,
     kuantitas: 1,
     foto: '../assets/fotogradu2.jpg'
   }
   
   → keranjang table gets:
     id_keranjang=1, id_user=5, nama_layanan='Makeup Graduation',
     tipe_layanan='makeup', harga=150000, kuantitas=1, foto='../assets/...'

5️⃣ BROWSE KOSTUM
   Display kostum catalog

6️⃣ ADD KOSTUM WEDDING TO CART (quantity=2)
   POST to add_to_cart.php:
   {
     nama_layanan: 'Kostum Wedding',
     tipe_layanan: 'kostum',
     harga: 200000,
     kuantitas: 2
   }
   
   → keranjang table gets:
     id_keranjang=2, id_user=5, nama_layanan='Kostum Wedding',
     tipe_layanan='kostum', harga=200000, kuantitas=2

7️⃣ VIEW CART
   SELECT * FROM keranjang WHERE id_user=5
   
   Cart View:
   ┌───────────────────────────────┐
   │ Makeup Graduation (1x) - 150k │
   │ Kostum Wedding (2x) - 400k    │
   │ SUBTOTAL: 550k                │
   └───────────────────────────────┘
   
   Session: $_SESSION['draft_booking'] = {
     source: 'cart',
     items: [{...makeup...}, {...kostum...}],
     total: 550000
   }

8️⃣ SELECT SCHEDULE
   Pick: Tanggal 27 Mei 2026, Jam Pagi (07:00)
   
   → jadwal_kerja table gets:
     id_jadwal=100, tanggal='2026-05-27', jam_mulai='07:00:00',
     jam_selesai='09:00:00', kapasitas_max=1, status='tersedia'
   
   Session update:
   $_SESSION['draft_booking']['id_jadwal'] = 100
   $_SESSION['draft_booking']['tanggal'] = '2026-05-27'
   $_SESSION['draft_booking']['jam_mulai'] = '07:00:00'

9️⃣ ENTER PAYMENT DETAILS
   Input:
   - Nama: Siti Mulyani
   - NoHP: 08123456789
   - Alamat: Jl. Pemuda No.5
   - Metode: Transfer
   
   Session: $_SESSION['pembayaran'] = {
     nama: 'Siti Mulyani',
     hp: '08123456789',
     alamat: 'Jl. Pemuda No.5',
     catatan: ''
   }

🔟 CREATE BOOKING (proses_pembayaran.php)
   Transaction BEGIN
   
   a) UPDATE user contact:
      UPDATE user SET full_name='Siti Mulyani', no_telp='08123456789' 
      WHERE id_user=5
   
   b) CREATE booking:
      INSERT INTO booking:
      id_user=5, id_jadwal=100, total_harga=560000 (550k+10k fee),
      status='pending', catatan='Jl. Pemuda No.5'
      → id_booking = 123
   
   c) MOVE CART ITEMS → booking_detail:
      INSERT INTO booking_detail (id_booking=123, id_layanan=1, qty=1, harga=150000, subtotal=150000)
      INSERT INTO booking_detail (id_booking=123, id_layanan=2, qty=2, harga=200000, subtotal=400000)
   
   d) ⭐ CLEAR CART (NEW):
      DELETE FROM keranjang WHERE id_user=5
      → keranjang table NOW EMPTY for this user
   
   Session update:
   $_SESSION['draft_booking']['id_booking'] = 123
   
   Transaction COMMIT

1️⃣1️⃣ WHATSAPP CONFIRMATION (konfirmasi_awal.php)
   ⭐ NEW AUTO-REDIRECT HANDLER:
   
   Display summary, then user click "Konfirmasi via WhatsApp"
   ├─ WhatsApp opens: wa.me/62... (admin number)
   │  Message: "Booking #123 untuk Siti Mulyani, Makeup Graduation + Kostum Wedding (2x), 
   │            Jl. Pemuda No.5, Rp 560.000"
   │
   └─ After 1 second: window.location = '../index.php'
      User redirected to home

1️⃣2️⃣ PAYMENT PROOF (konfirmasi_akhir.php → proses_konfirmasi.php)
   User upload transfer proof:
   - File: transfer_27mei.jpg (150KB)
   - Validate: ✅ MIME=image/jpeg, Size<5MB
   - Save to: assets/bukti_pembayaran/bukti_BK123_transfer.jpg
   
   Transaction BEGIN
   
   a) UPDATE booking:
      UPDATE booking 
      SET bukti_pembayaran='bukti_BK123_transfer.jpg', 
          tanggal_upload=NOW(), 
          status='konfirmasi'
      WHERE id_booking=123
   
   b) INSERT payment record:
      INSERT INTO pembayaran:
      id_booking=123, jumlah_bayar=560000, metode_bayar='transfer',
      bukti_transfer='bukti_BK123_transfer.jpg', status_verifikasi='pending'
   
   Transaction COMMIT

1️⃣3️⃣ ADMIN VERIFY PAYMENT
   Admin review transfer proof
   → UPDATE pembayaran SET status_verifikasi='diterima' WHERE id_pembayaran=X
   → UPDATE booking SET status_booking='selesai' WHERE id_booking=123

1️⃣4️⃣ VIEW HISTORY (riwayat_pesanan.php)
   User login & view riwayat_pesanan
   
   Query hasil:
   ┌───────────────────────────────────────────────────────────────┐
   │ #123 | Makeup Graduation + Kostum Wedding (2x) | Selesai     │
   │ Rp 560.000 | 27 Mei 2026                                     │
   │ [Detail]  [Cancel] [Rate]                                    │
   └───────────────────────────────────────────────────────────────┘
   
   Data dari:
   - booking table: ID, total, status, created_at
   - booking_detail table: qty items
   - layanan table: nama_layanan
```

---

## 📋 FIELD MAPPING - Dari Input sampai Database

### Input → Database Path

```
REGISTRASI
──────────
username (form) → user.username
email (form) → user.email
password (form) → user.password_hash (hashed)
full_name (optional) → user.full_name
no_telp (optional) → user.no_telp

CART
────
selectedProduct.name → keranjang.nama_layanan
selectedProduct.type → keranjang.tipe_layanan
selectedProduct.price → keranjang.harga
selectedProduct.image → keranjang.foto
quantity (user) → keranjang.kuantitas
id_user (session) → keranjang.id_user

BOOKING
───────
tanggal (calendar) → jadwal_kerja.tanggal → booking.tgl_booking
jam (time slots) → jadwal_kerja.jam_mulai, jam_selesai
id_jadwal → booking.id_jadwal

cart.subtotal + 10000 → booking.total_harga

pembayaran.nama → user.full_name (update)
pembayaran.hp → user.no_telp (update)
pembayaran.alamat → booking.catatan

keranjang.items → booking_detail (INSERT each item)
                → keranjang (DELETE all)

metode_bayar (form) → pembayaran.metode_bayar
bukti_transfer (file) → pembayaran.bukti_transfer
```

---

## ✅ DATA INTEGRITY CHECKS

```
During Checkout:
├─ ✅ User logged in (id_user exists in session)
├─ ✅ Cart not empty (SELECT COUNT FROM keranjang > 0)
├─ ✅ Schedule selected (id_jadwal in draft_booking)
├─ ✅ Form fields validated (nama, hp, alamat)
├─ ✅ Schedule still available (booking count < 3)
├─ ✅ Payment inserted correctly
└─ ✅ Cart cleared after booking (DELETE succeeded)

During Payment:
├─ ✅ Booking exists (SELECT booking WHERE id_booking)
├─ ✅ File uploaded (UPLOAD_ERR_OK)
├─ ✅ File type valid (JPEG/PNG only)
├─ ✅ File size valid (< 5MB)
├─ ✅ Transaction committed (no rollback)
└─ ✅ Payment record exists (pembayaran table)
```

---

## 🔑 KEY FILES UNTUK REFERENCE

```
FLOW STAGE              FILE PATH
───────────────────────────────────────────────────
Registration           public/register.php
                       actions/proses_register.php

Login                  public/login.php
                       actions/proses_login.php

Browse Products        public/makeup.php
                       public/kostum.php
                       public/dekor.php

Add to Cart           actions/add_to_cart.php
                      public/include/add_to_cart_script.php

View Cart             public/keranjang.php

Schedule              public/penjadwalan.php

Payment Form          public/pembayaran.php

Create Booking ⭐      actions/proses_pembayaran.php
(Task 5 + Cart clear)

WA Confirmation ⭐    public/konfirmasi_awal.php
(Task 4 + Redirect)

Payment Proof         public/konfirmasi_akhir.php
                      actions/proses_konfirmasi.php

Order History         public/riwayat_pesanan.php

Database Schema       database/db_mua.sql
```

---

## 🎯 QUICK LOOKUP - Dari Mana Ke Mana

**Q: Nama produk yang diinput user masuk kemana?**
A: form → add_to_cart.php → keranjang.nama_layanan → booking_detail (FK layanan) → riwayat_pesanan display

**Q: Berapa harga user yang input?**
A: form → proses_pembayaran.php → booking.total_harga + pembayaran.jumlah_bayar

**Q: Kapan data keranjang dihapus?**
A: Saat proses_pembayaran.php CREATE BOOKING → DELETE keranjang WHERE id_user

**Q: Bagaimana user tahu booking sukses?**
A: Email/WhatsApp message → riwayat_pesanan.php menampilkan booking baru

**Q: Bukti transfer file disimpan ke mana?**
A: assets/bukti_pembayaran/ → pembayaran.bukti_transfer column

**Q: Status booking berubah kapan?**
A: pending (create) → dikonfirmasi (WA sent) → konfirmasi (payment uploaded) → selesai (admin verify)

---

**Generated:** 26 Mei 2026  
**Document Type:** Quick Reference Guide  
**Version:** 2.0 (Post-Task-5-Revision)
