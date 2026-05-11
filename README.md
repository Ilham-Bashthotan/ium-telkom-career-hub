# Telkom Career Hub

Sistem manajemen portal lowongan pekerjaan dan kemitraan industri berbasis web untuk SMK Telkom. Dibangun menggunakan arsitektur **MVC (Model-View-Controller)** dengan framework **Laravel**.

---

## Daftar Isi

- [Deskripsi](#deskripsi)
- [Fitur Utama](#fitur-utama)
- [Arsitektur](#arsitektur)
- [Requirement](#requirement)
- [Persiapan Environment Lokal](#persiapan-environment-lokal)
- [Setup & Instalasi](#setup--instalasi)
- [Akun Default](#akun-default)

---

## Deskripsi

Telkom Career Hub dikembangkan untuk memfasilitasi lulusan dan siswa SMK Telkom dalam mencari lowongan pekerjaan, melihat perusahaan mitra, dan memperoleh informasi seputar PPDB. Sistem ini menghubungkan administrator sekolah, perusahaan mitra, dan pengguna (alumni/umum) dalam satu wadah yang terpusat.

Sistem dibangun dalam satu project Laravel dengan pendekatan _server-side rendering_ (SSR):

| Bagian   | Teknologi        | Keterangan                                                                |
| -------- | ---------------- | ------------------------------------------------------------------------- |
| Backend  | Laravel          | Logika bisnis, autentikasi multi-guard (User & Admin), integrasi database |
| Frontend | HTML/CSS (Blade) | Tampilan antarmuka web langsung dikelola oleh Laravel Views               |

---

## Fitur Utama

- **Autentikasi Multi-Guard**: Sistem login terpisah untuk _Admin_ dan _User_ (Alumni/Umum).
- **Manajemen Lowongan**: CRUD lowongan kerja, lengkap dengan detail kualifikasi, gaji, dan relasi jurusan.
- **Manajemen Perusahaan Mitra**: Pendataan perusahaan mitra sekolah beserta status kerja sama.
- **Crawler Management**: Antarmuka bagi admin untuk memproses dan menyetujui lowongan hasil crawling secara semi-otomatis.
- **Manajemen PPDB**: Pengelolaan banner dan informasi Penerimaan Peserta Didik Baru.
- **Log Aktivitas**: Perekaman aktivitas administrator secara otomatis.

---

## Arsitektur

```
ium-telkom-career-hub/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Admin/          # Controller khusus panel Admin (CRUD, Dashboard)
│   │       ├── User/           # Controller khusus User/Alumni (Home, Profil)
│   │       ├── AuthController.php
│   │       └── HomeController.php
│   └── Models/                 # Admin, User, Lowongan, Perusahaan, Jurusan, PPDB, SavedLowongan, LogAktifitas.
├── database/
│   ├── migrations/             # Skema database terurut berdasar ERD
│   └── seeders/                # Dummy data generator
├── resources/
│   └── views/                  # Folder untuk template antarmuka
├── routes/
│   └── web.php                 # Registrasi seluruh URL route
└── docs/
    └── wireframe/              # Referensi struktur awal / mockup HTML & CSS
```

---

## Requirement

| Komponen     | Versi                                          |
| ------------ | ---------------------------------------------- |
| PHP          | >= 8.2                                         |
| Laravel      | 11.x                                           |
| Composer     | >= 2.x                                         |
| SQLite       | Built-in (via PHP)                             |
| Laravel Herd | Opsional (Sangat direkomendasikan untuk lokal) |

---

## Persiapan Environment Lokal

Sebelum melakukan instalasi project, pastikan environment kamu sudah siap agar proses coding dan instalasi berjalan lancar.

**1. Instalasi Laravel Herd**

Untuk pengguna Windows/macOS, **jangan gunakan XAMPP**. Sangat disarankan untuk menginstal Laravel Herd. Herd sudah memaketkan PHP, Composer, dan ekstensi yang dibutuhkan secara otomatis, berjalan jauh lebih cepat, dan minim konfigurasi.

**2. Setup Git Bash untuk Laravel Herd (Khusus Windows)**

Jika kamu menggunakan Git Bash dan mendapati pesan error `bash: php: command not found` atau `composer: command not found`, kamu perlu mendaftarkan path Herd secara manual:

1. Buka Git Bash dan ketik: `nano ~/.bashrc`

2. Untuk mencari path PHP dari Herd, jalankan:

```bash
where.exe php
```

Gunakan hasil path tersebut sebagai referensi. Lalu tambahkan konfigurasi alias berikut (ganti `NAMA_USER_KAMU` dengan nama folder user Windows-mu):

```bash
alias php='/c/Users/NAMA_USER_KAMU/.config/herd/bin/php.bat'
alias composer='/c/Users/NAMA_USER_KAMU/.config/herd/bin/composer.bat'
```

3. Simpan dengan tekan `Ctrl+O` -> `Enter` -> `Ctrl+X`.
4. Terapkan perubahan dengan mengetik: `source ~/.bashrc`

**3. Rekomendasi Extension VS Code**

Agar pengalaman coding Laravel makin mulus, instal ekstensi berikut:

- **PHP Intelephense** (Ben Mewburn): Wajib untuk auto-complete dan deteksi error kode PHP.
- **Laravel Extension Pack** (Winfred Wang): Bundle paket esensial untuk kebutuhan Laravel.
- **SQLite** (alexcvzz): Untuk melihat dan mengelola isi file database `database.sqlite` langsung dari dalam VS Code.

---

## Setup & Instalasi

### 1. Clone & Install Dependency

```bash
git clone https://github.com/your-org/ium-telkom-career-hub.git
cd ium-telkom-career-hub

composer install
```

### 2. Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit file `.env` dan pastikan konfigurasi koneksi database menggunakan SQLite:

```env
APP_NAME="Telkom Career Hub"
APP_URL=http://career-hub.test

DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

### 3. Migrasi & Seeder Database

Jalankan perintah berikut untuk mengeksekusi migrasi database berserta data contoh (dummy):

```bash
touch database/database.sqlite
php artisan migrate:fresh --seed
```

### 4. Jalankan Aplikasi

**Laravel Herd** — Jika menggunakan Herd, kamu cukup mengakses URL project lokalmu (contoh: `http://career-hub.test`).

**Artisan** — Jika tidak menggunakan Herd:

```bash
php artisan serve
```

Akses di `http://localhost:8000`.

---

## Akun Default

Setelah menjalankan proses seeding, kamu dapat mencoba login menggunakan akun dummy berikut:

| Role   | Email                    | Password      | Keterangan                         |
| ------ | ------------------------ | ------------- | ---------------------------------- |
| Admin  | `admin@smktelkom.sch.id` | `password123` | Akses penuh dashboard admin        |
| Alumni | `alumni@gmail.com`       | `password123` | Mengakses dashboard user/alumni    |
| Umum   | `umum@gmail.com`         | `password123` | Mengakses dashboard pendaftar umum |
