# 🔍 Audit Quick Reference - Project MUA

## ❌ BUGS DITEMUKAN

### 1. Admin Registration Bug (CRITICAL) 🔴
**File:** `admin/public/register.php` (baris 14)

```php
// MASALAH:
} else {
    // TODO: simpan ke database di sini  ← TIDAK DIIMPLEMEN!
    $success = 'Akun berhasil dibuat!';  ← PESAN PALSU
}
```

**Dampak:** Admin tidak bisa mendaftar, hanya bisa dibuat manual di database

**Status:** Belum diperbaiki - PERLU IMPLEMENTASI SEGERA

---

### 2. Password Requirement Inconsistent (HIGH) 🟠
- Admin register: minimum 6 karakter ❌
- Client register: minimum 8 karakter ✅
- Login: check 8 karakter ✅

**Rekomendasi:** Seragamkan ke 8 karakter

---

### 3. Unused Code (HIGH) 🟠
**File:** `actions/proses_booking.php`

Fungsi `getBookingData()` defined tapi tidak digunakan.

**Action:** Delete atau refactor

---

### 4. Cart Image Path Logic (MEDIUM) 🟡
**File:** `actions/proses_keranjang.php`

Hardcoded image paths berdasarkan nama layanan:
```php
if (str_contains($name, 'graduation')) {
    return '../assets/fotograduation.jpeg';  // Sulit dimaintain
}
```

**Better:** Gunakan `foto_layanan` column dari database

---

### 5. Transaction Timing (MEDIUM) 🟡
**File:** `actions/proses_konfirmasi.php`

File upload sebelum transaction dimulai → potensi race condition.

**Fix:** Move transaction sebelum upload

---

## ✅ YANG SUDAH BENAR

### Registrasi & Login
```
CLIENT REGISTER:
✅ Email validation
✅ OTP verification
✅ Duplicate check (email & username)
✅ Password hashing
✅ Save to user table

ADMIN/CLIENT LOGIN:
✅ Email lookup
✅ Password verify
✅ Session setup (id_user, username, role, email)
✅ Remember me token
✅ Role-based redirect
```

### Authorization & Roles
```
✅ Admin pages: require_login(['admin'])
✅ Client pages: automatic redirect
✅ normalize_role() untuk case-insensitive
✅ redirect_to_role_home() berdasarkan role
```

### Data Operations
```
CART:
✅ Input: Add to cart → keranjang table
✅ Output: Load from keranjang table
✅ Duplikat check & qty update

BOOKING:
✅ Input: Create booking → booking & booking_detail
✅ Output: Display riwayat_pesanan dari booking table
✅ Jadwal availability check
✅ Kapasitas validation

PAYMENT:
✅ Input: Pembayaran file & data
✅ Output: Admin dashboard fetch pembayaran
✅ Status verification & update
✅ Transaction handling

SERVICE:
✅ Input: Admin add/edit/delete layanan
✅ Output: Public pages fetch dari layanan table
✅ Image upload & storage
✅ Kategori validation

GALLERY:
✅ Input: Admin add/edit gallery
✅ Output: Display di client pages
✅ Image handling
```

---

## 📋 DATA FLOW VERIFICATION

### Registrasi User
```
public/register.php (form & validasi)
    ↓
actions/proses_register.php (store in SESSION + send OTP)
    ↓
public/register_verify.php (OTP input)
    ↓
actions/proses_register_verify.php (INSERT INTO user table)
    ↓
public/login.php
✅ Data ada di database
```

### Login
```
public/login.php (form)
    ↓
actions/proses_login.php (SELECT from user table)
    ↓
Session setup + remember_me cookie
    ↓
Redirect ke dashboard/index
✅ Data dari database
```

### Add to Cart
```
public/[makeup|dekor|kostum].php (form)
    ↓
actions/add_to_cart.php (AJAX POST)
    ↓
INSERT/UPDATE keranjang table
    ↓
public/keranjang.php (display)
    ↓
actions/proses_keranjang.php (SELECT from keranjang)
✅ Input & Output dari database
```

### Booking & Payment
```
public/booking.php → penjadwalan.php → pembayaran.php
    ↓
actions/proses_pembayaran.php (INSERT booking & booking_detail)
    ↓
public/konfirmasi_akhir.php (upload bukti)
    ↓
actions/proses_konfirmasi.php (INSERT pembayaran)
    ↓
admin/public/dashboard.php (SELECT dari pembayaran)
    ↓
actions/verifikasi_pembayaran.php (UPDATE status)
✅ Semua operasi dengan database
```

### Service Management
```
admin/public/data_layanan.php (form)
    ↓
POST action: INSERT/UPDATE/DELETE layanan
    ↓
public/[service pages] (SELECT from layanan table)
    ↓
fetch_catalog_by_category() helper
✅ Database CRUD
```

---

## 🧪 VERIFICATION TESTS

### Test 1: Admin Registration
```
1. Go to admin/public/register.php
2. Fill form: username, email, password (6+ char)
3. Submit
4. ❌ RESULT: Success message shows BUT data NOT in user table
```

### Test 2: Client Registration → Login
```
1. Go to public/register.php
2. Fill form & submit
3. Enter OTP
4. ✅ RESULT: User created in user table
5. Login with credentials
6. ✅ RESULT: Session set correctly
```

### Test 3: Cart → Booking → Payment
```
1. Add to cart
2. ✅ RESULT: Data in keranjang table
3. Checkout
4. ✅ RESULT: Booking created in booking table
5. Upload pembayaran
6. ✅ RESULT: pembayaran table updated
```

### Test 4: Admin Verify Payment
```
1. Admin view dashboard pembayaran
2. ✅ RESULT: Fetch dari pembayaran table
3. Click verify
4. ✅ RESULT: status_verifikasi updated
```

---

## 📊 SUMMARY TABLE

| Area | Status | Evidence |
|------|--------|----------|
| Client Registration | ✅ | Code verified, OTP flow works |
| **Admin Registration** | ❌ | TODO not implemented |
| Login System | ✅ | Password verify + session setup |
| Role-based Access | ✅ | require_login(['admin']) works |
| Cart Input | ✅ | INSERT into keranjang verified |
| Cart Output | ✅ | SELECT from keranjang verified |
| Booking Input | ✅ | INSERT booking & booking_detail |
| Booking Output | ✅ | SELECT for riwayat_pesanan |
| Payment Input | ✅ | INSERT pembayaran verified |
| Payment Output | ✅ | SELECT for admin dashboard |
| Service CRUD | ✅ | INSERT/UPDATE/DELETE layanan |
| Gallery CRUD | ✅ | INSERT/UPDATE/DELETE gallery |

---

## 🚨 ACTION ITEMS

### Immediate (TODAY)
- [ ] Fix admin registration - implement database INSERT
- [ ] Test admin registration flow end-to-end

### This Week
- [ ] Standardize password requirement to 8 chars
- [ ] Delete proses_booking.php or refactor
- [ ] Add CSRF protection to forms

### This Month
- [ ] Refactor image path logic
- [ ] Move transaction wrapper earlier in proses_konfirmasi.php
- [ ] Add input validation in more places

---

**Status:** Audit Complete ✅  
**Critical Issues:** 1 (Admin Registration)  
**Date:** 2 Juni 2026
