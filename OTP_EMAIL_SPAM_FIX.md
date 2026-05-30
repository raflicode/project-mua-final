# OTP Email Spam Fix - Implementation Guide

## Masalah
Email OTP terkirim tapi masuk di folder Spam Gmail.

## Root Cause
1. **Email HTML terlalu sederhana** → Gmail mendeteksi sebagai suspicious
2. **Kurang headers anti-spam** (Reply-To, Message-ID, dll)
3. **Tidak ada plain text alternative** → email clients lebih suka
4. **Subject line generic** → "Kode OTP" terdeteksi sebagai spam signature

## Solusi yang Diterapkan

### ✅ 1. File Baru: `config/email_config.php`
Menyimpan konfigurasi SMTP dan credentials di satu tempat:
- Host: smtp.gmail.com
- Port: 587 (TLS)
- Support environment variables untuk security (getenv)
- Debug mode untuk troubleshooting

### ✅ 2. File Baru: `config/email_helper.php`
Helper functions untuk mengirim email:
- `sendEmail()` → fungsi utama, menangani SMTP + error logging
- `getOtpEmailTemplate()` → HTML template profesional dengan:
  - Gradient header
  - OTP display yang prominent
  - Security warning
  - Proper HTML structure
- `getOtpPlainText()` → plain text alternative

**Template Improvements:**
- Professional gradient header
- Better visual hierarchy
- Security warning untuk mencegah phishing
- Proper HTML structure (DOCTYPE, meta tags)
- Mobile-responsive CSS
- Border dan styling yang lebih baik
- Plus copyright/footer profesional

### ✅ 3. Updated: `actions/send_otp.php`
Refactored untuk:
- Menggunakan email helper function
- Hapus hardcoded credentials
- Lebih clean dan maintainable
- Better error handling

## File yang Perlu Upload ke Server

Upload ke WinSCP ke folder project Anda:
```
project-mua-final/
├── config/
│   ├── email_config.php        ← NEW
│   ├── email_helper.php        ← NEW
│   └── koneksi.php             (existing)
└── actions/
    └── send_otp.php            ← UPDATED
```

## Langkah Upload di WinSCP

1. **Buka WinSCP** → Connect ke hosting
2. **Navigate ke** `project-mua-final/config/`
3. **Upload files baru:**
   - Right-click → Upload → `email_config.php` & `email_helper.php`
4. **Update file:**
   - Right-click `send_otp.php` → Edit → Copy-paste kode baru
   - Save & Close
5. **Clear browser cache** (Ctrl+Shift+Del) sebelum test

## Test OTP Setelah Upload

1. **Akses halaman forgot/register Anda**
2. **Masukkan email**
3. **Tunggu email masuk** (check Inbox dulu, bukan Spam)
4. **Jika masih spam:**
   - Check PHP error log di hosting panel (look for "[PHPMailer debug]" messages)
   - Verify Gmail credentials (2FA + App Password)
   - Coba whitelist email pengirim di Gmail settings

## Kemungkinan Masalah & Solusi

| Masalah | Solusi |
|---------|---------|
| Email masih masuk Spam | Server hosting mungkin diblokir Gmail. Gunakan SMTP server dari hosting atau SendGrid/Mailgun |
| "Permission denied" upload | Check file permissions, gunakan 644 (baca-tulis) |
| Parse error di email helper | Pastikan PHP version ≥7.0 dan vendor/autoload.php ada |
| Credentials error | Pastikan App Password Gmail yang benar (bukan password akun) |

## Keamanan - PENTING!

⚠️ **Jangan commit file `email_config.php` ke Git** (karena ada credentials):
```bash
# Tambahkan ke .gitignore
echo "config/email_config.php" >> .gitignore
```

**Better Practice di Production:**
Simpan credentials di environment variables (hosting biasanya support .env):
```php
// Di hosting control panel, set environment variables:
// MAIL_USERNAME = zaind377@gmail.com
// MAIL_PASSWORD = djql ypoe rndc mnvi

// Maka file tetap aman
```

## Keuntungan Refactor Ini

✅ Email lebih profesional → Spam probability ↓↓  
✅ Reusable email helper → Bisa dipakai untuk email lain (konfirmasi pembayaran, dll)  
✅ Centralized config → Gampang ganti SMTP/credentials  
✅ Better logging → Mudah debug di production  
✅ AltBody support → Kompatibilitas email client lebih baik  
✅ Security warning → Educate users tentang phishing  

## Next Steps

Setelah test berhasil:
1. Coba kirim OTP untuk reset password
2. Coba kirim OTP saat register
3. Pastikan OTP masuk Inbox (bukan Spam)
4. Jika perlu, refactor file pembayaran/konfirmasi email lain dengan template ini
