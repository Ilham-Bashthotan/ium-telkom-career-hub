# Use Case Diagram — Telkom Career Hub

## Aktor

1. **User** (Alumni / Umum)
2. **Admin**
3. **Sistem** (Auto Crawler)

## Daftar Use Case

### UC01 — UC07: Fitur User

| Kode | Use Case                  | Aktor | Keterangan                                       |
| ---- | ------------------------- | ----- | ------------------------------------------------ |
| UC01 | Registrasi akun           | User  | Mengisi data diri, status alumni, riwayat kerja  |
| UC02 | Login                     | User  | Wajib untuk mengakses fitur tertentu             |
| UC03 | Lihat daftar lowongan     | User  | Dapat diakses tanpa login                        |
| UC04 | Lihat detail lowongan     | User  | «include» UC02 — wajib login                     |
| UC05 | Akses link apply          | User  | «include» UC04 — diarahkan ke form perusahaan    |
| UC06 | Lihat info mitra industri | User  | Daftar mitra yang bekerja sama dengan SMK Telkom |
| UC07 | Lihat info PPDB           | User  | Bersifat informatif / banner                     |

### UC08 — UC11: Fitur Admin

| Kode | Use Case              | Aktor | Keterangan                                         |
| ---- | --------------------- | ----- | -------------------------------------------------- |
| UC08 | Kelola lowongan kerja | Admin | Tambah, edit, hapus, update lowongan               |
| UC09 | Kelola akun user      | Admin | Melihat data user yang terdaftar                   |
| UC10 | Kelola crawler        | Admin | Memproses lowongan hasil crawling (Approve/Reject) |
| UC11 | Simpan lowongan       | User  | Menyimpan lowongan kerja ke daftar favorit         |
| UC12 | Reset password user   | Admin | Reset password dilakukan melalui panel admin       |

### UC12: Fitur Sistem

| Kode | Use Case            | Aktor  | Keterangan                                  |
| ---- | ------------------- | ------ | ------------------------------------------- |
| UC13 | Tarik data crawling | Sistem | Menarik data lowongan dari sumber eksternal |

## Relasi Antar Use Case

- UC04 **«include»** UC02 — melihat detail lowongan mengharuskan user sudah login
- UC05 **«include»** UC04 — akses link apply hanya bisa dari halaman detail
- UC13 **«include»** UC10 — setiap hasil crawling wajib melewati proses persetujuan admin sebelum ditampilkan
- UC11 **«include»** UC02 — menyimpan lowongan wajib login

---

# ERD — Telkom Career Hub

## Entitas dan Atribut

### 1. USER

| Atribut            | Tipe      | Keterangan                                          |
| ------------------ | --------- | --------------------------------------------------- |
| **user_id** _(PK)_ | INT       | Primary key                                         |
| nama_lengkap       | VARCHAR   | Nama lengkap user                                   |
| email              | VARCHAR   | Email pribadi (unik)                                |
| no_hp              | VARCHAR   | Nomor HP                                            |
| password           | VARCHAR   | Password terenkripsi                                |
| is_alumni          | BOOLEAN   | Apakah alumni SMK Telkom                            |
| status_pekerjaan   | ENUM      | `belum_bekerja` / `sedang_bekerja` / `wirausaha`    |
| tempat_kerja       | VARCHAR   | Diisi nama perusahaan jika sudah bekerja (nullable) |
| created_at         | TIMESTAMP | Tanggal registrasi                                  |
| updated_at         | TIMESTAMP | Tanggal update data                                 |

### 2. LOWONGAN

| Atribut                  | Tipe      | Keterangan                                         |
| ------------------------ | --------- | -------------------------------------------------- |
| **lowongan_id** _(PK)_   | INT       | Primary key                                        |
| judul                    | VARCHAR   | Judul posisi lowongan                              |
| deskripsi                | TEXT      | Deskripsi pekerjaan                                |
| link_apply               | VARCHAR   | Link form apply milik perusahaan                   |
| sumber                   | ENUM      | `manual` / `crawl`                                 |
| status                   | ENUM      | `draft` / `aktif` / `nonaktif`                     |
| tanggal_posting          | DATE      | Tanggal lowongan diposting                         |
| tanggal_expired          | DATE      | Tanggal lowongan berakhir                          |
| lokasi                   | VARCHAR   | Lokasi kerja (contoh: Bandung, Remote)             |
| tipe_pekerjaan           | ENUM      | `Full-time`, `Part-time`, `Internship`, `Contract` |
| gaji                     | VARCHAR   | Kisaran gaji (opsional)                            |
| **perusahaan_id** _(FK)_ | INT       | Referensi ke tabel PERUSAHAAN                      |
| **jurusan_id** _(FK)_    | INT       | Referensi ke tabel JURUSAN                         |
| **admin_id** _(FK)_      | INT       | Admin yang memposting                              |
| created_at               | TIMESTAMP | Waktu dibuat                                       |
| updated_at               | TIMESTAMP | Waktu diupdate                                     |

### 3. PERUSAHAAN

| Atribut                  | Tipe      | Keterangan                               |
| ------------------------ | --------- | ---------------------------------------- |
| **perusahaan_id** _(PK)_ | INT       | Primary key                              |
| nama_perusahaan          | VARCHAR   | Nama perusahaan                          |
| deskripsi                | TEXT      | Deskripsi singkat perusahaan             |
| sektor_industri          | VARCHAR   | Bidang industri (contoh: Telekomunikasi) |
| logo                     | VARCHAR   | Path/URL logo perusahaan                 |
| is_mitra                 | BOOLEAN   | Apakah termasuk mitra resmi SMK Telkom   |
| website                  | VARCHAR   | URL website perusahaan                   |
| created_at               | TIMESTAMP | Waktu dibuat                             |
| updated_at               | TIMESTAMP | Waktu diupdate                           |

### 4. JURUSAN

| Atribut               | Tipe      | Keterangan              |
| --------------------- | --------- | ----------------------- |
| **jurusan_id** _(PK)_ | INT       | Primary key             |
| kode_jurusan          | VARCHAR   | Contoh: DKV, PPLG, TJKT |
| nama_jurusan          | VARCHAR   | Nama lengkap jurusan    |
| created_at            | TIMESTAMP | Waktu dibuat            |
| updated_at            | TIMESTAMP | Waktu diupdate          |

### 5. ADMIN

| Atribut             | Tipe      | Keterangan            |
| ------------------- | --------- | --------------------- |
| **admin_id** _(PK)_ | INT       | Primary key           |
| nama                | VARCHAR   | Nama admin            |
| email               | VARCHAR   | Email admin (unik)    |
| password            | VARCHAR   | Password terenkripsi  |
| created_at          | TIMESTAMP | Tanggal akun dibuat   |
| updated_at          | TIMESTAMP | Tanggal akun diupdate |

### 6. PPDB

| Atribut             | Tipe      | Keterangan             |
| ------------------- | --------- | ---------------------- |
| **ppdb_id** _(PK)_  | INT       | Primary key            |
| judul               | VARCHAR   | Judul info PPDB        |
| konten              | TEXT      | Isi informasi PPDB     |
| banner_url          | VARCHAR   | URL gambar banner      |
| tanggal_mulai       | DATE      | Tanggal mulai tayang   |
| tanggal_selesai     | DATE      | Tanggal selesai tayang |
| **admin_id** _(FK)_ | INT       | Admin yang mengelola   |
| created_at          | TIMESTAMP | Waktu dibuat           |
| updated_at          | TIMESTAMP | Waktu diupdate         |

#### 7. LOG_AKTIVITAS

| Atribut             | Tipe      | Keterangan                                     |
| ------------------- | --------- | ---------------------------------------------- |
| **log_id** _(PK)_   | INT       | Primary key                                    |
| **admin_id** _(FK)_ | INT       | Admin yang melakukan aksi                      |
| aksi                | VARCHAR   | Jenis aksi (Tambah, Edit, Hapus, Setujui, dll) |
| detail              | TEXT      | Penjelasan detail aktivitas                    |
| created_at          | TIMESTAMP | Waktu kejadian                                 |
| updated_at          | TIMESTAMP | Waktu diupdate                                 |

### 8. SAVED_LOWONGAN

| Atribut                | Tipe      | Keterangan                  |
| ---------------------- | --------- | --------------------------- |
| **id** _(PK)_          | INT       | Primary key                 |
| **user_id** _(FK)_     | INT       | Referensi ke tabel USER     |
| **lowongan_id** _(FK)_ | INT       | Referensi ke tabel LOWONGAN |
| created_at             | TIMESTAMP | Waktu disimpan              |
| updated_at             | TIMESTAMP | Waktu diupdate              |

## Relasi Antar Entitas

| Relasi                    | Kardinalitas | Keterangan                                        |
| ------------------------- | ------------ | ------------------------------------------------- |
| PERUSAHAAN — LOWONGAN     | One-to-Many  | Satu perusahaan bisa punya banyak lowongan        |
| JURUSAN — LOWONGAN        | One-to-Many  | Satu jurusan bisa punya banyak lowongan           |
| ADMIN — LOWONGAN          | One-to-Many  | Satu admin bisa memposting banyak lowongan        |
| ADMIN — PPDB              | One-to-Many  | Satu admin bisa mengelola banyak info PPDB        |
| ADMIN — LOG_AKTIVITAS     | One-to-Many  | Satu admin bisa memiliki banyak catatan aktivitas |
| USER — SAVED_LOWONGAN     | One-to-Many  | Satu user bisa menyimpan banyak lowongan          |
| LOWONGAN — SAVED_LOWONGAN | One-to-Many  | Satu lowongan bisa disimpan oleh banyak user      |
