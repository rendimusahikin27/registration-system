# Sistem Pendaftaran Peserta (PHP + MySQL)

Project demo kedua untuk portofolio — menunjukkan kemampuan koneksi database (bukan cuma file-based seperti demo pertama). Cocok ditawarkan ke klien yang butuh: pendaftaran acara/workshop, absensi, atau sistem approval sederhana.

## Isi Project

- `index.html` + `style.css` + `script.js` — form pendaftaran publik
- `register.php` — proses simpan data ke MySQL (pakai prepared statement, aman dari SQL injection)
- `config.php` — kredensial database & admin (WAJIB diedit sebelum dipakai)
- `schema.sql` — struktur database, tinggal import
- `admin/login.php`, `admin/index.php`, `admin/logout.php` — dashboard admin sederhana untuk lihat daftar peserta (dilindungi login)

## Setup Lokal

1. Pastikan sudah ada MySQL/MariaDB + PHP di laptop (XAMPP/Laragon paling gampang untuk pemula)
2. Import `schema.sql`:
   ```
   mysql -u root -p < schema.sql
   ```
3. Edit `config.php`, sesuaikan `DB_USER`/`DB_PASS` dengan konfigurasi lokal
4. Jalankan:
   ```
   php -S localhost:8000
   ```
5. Buka `http://localhost:8000` untuk form, atau `http://localhost:8000/admin/login.php` untuk dashboard
   - Login default: `admin` / `admin123` (GANTI ini di `config.php` sebelum deploy ke hosting asli)

## Deploy ke InfinityFree (Hosting Gratis untuk Demo)

1. Daftar akun di [infinityfree.net](https://infinityfree.net), buat subdomain gratis (misal `daftar-acara.infinityfreeapp.com`)
2. Masuk ke **Control Panel → MySQL Databases**, buat database baru — catat **hostname**, **username**, **password**, dan **nama database** yang diberikan (biasanya beda dari `localhost`, contoh: `sqlXXX.infinityfree.com`)
3. Buka **phpMyAdmin** dari panel, pilih database yang baru dibuat, klik tab **Import**, upload `schema.sql`
4. Edit `config.php`, ganti `DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME` sesuai yang dicatat di langkah 2
5. Ganti juga `ADMIN_USERNAME` & `ADMIN_PASSWORD` ke kombinasi yang lebih aman (jangan pakai `admin`/`admin123` di versi yang online)
6. Masuk ke **File Manager**, upload semua file (termasuk folder `admin/`) ke `htdocs/`
7. Akses lewat subdomain yang diberikan, coba isi form, lalu cek `admin/login.php` untuk pastikan data masuk

## Deploy ke Hosting Klien (Berbayar)

1. Upload semua file lewat FTP/File Manager
2. Buat database MySQL lewat cPanel, import `schema.sql` lewat phpMyAdmin
3. Edit `config.php` dengan kredensial database dari hosting (biasanya diberi oleh cPanel saat bikin database)
4. Ganti `ADMIN_USERNAME` & `ADMIN_PASSWORD` ke yang aman

## Cara Upload Source Code ke GitHub (untuk Link "Lihat Kode" di Portofolio)

**PENTING — lakukan ini dulu sebelum upload ke GitHub:**
Repo GitHub public bisa dilihat siapa saja. Buka `config.php`, ganti nilai `DB_USER`, `DB_PASS`, `ADMIN_PASSWORD` yang asli (dari InfinityFree) menjadi placeholder generik, contoh:
```php
define('DB_USER', 'ganti_dengan_username_anda');
define('DB_PASS', 'ganti_dengan_password_anda');
define('ADMIN_PASSWORD', 'ganti_sebelum_dipakai');
```
Simpan kredensial asli hanya di server InfinityFree, jangan pernah ikut ter-upload ke repo public.

Langkah upload:
1. Buat repository baru di GitHub, public, beri nama `registration-system`
2. Upload semua file & folder (termasuk `admin/`) lewat "uploading an existing file"
3. Commit changes
4. Salin link repo-nya (`https://github.com/username-kamu/registration-system`), tempel ke link "Lihat Kode" di portofolio kamu

## Poin yang Bisa Dipakai untuk "Jual" ke Klien

- Sudah pakai prepared statement → aman dari SQL injection (nilai jual teknis)
- Admin dashboard terpisah dengan login → klien bisa pantau sendiri tanpa perlu buka database manual
- Struktur mudah diperluas: tinggal tambah kolom di `schema.sql` dan form sesuai kebutuhan (misal upload foto, pilihan sesi, dsb.)
