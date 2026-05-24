# Panduan Penggunaan Fitur Crawling

Dokumen ini menjelaskan cara menggunakan fitur crawling lowongan pada Telkom Career Hub.

## 1. Tujuan Fitur

Fitur crawling dipakai untuk mengambil lowongan dari sumber eksternal yang diizinkan, lalu menyimpannya ke database sebagai data draft agar bisa divalidasi admin sebelum dipublikasikan.

## 2. Prasyarat

Sebelum memakai fitur ini, pastikan:

- Kamu login sebagai **admin utama**.
- URL sumber termasuk dalam allowlist pada `config/crawl.php`.
- Server mengaktifkan fitur `cache` bawaan Laravel.
- Jika ingin otomatis, scheduler Laravel sudah aktif di server.

## 3. Pengaturan Dasar

Konfigurasi crawling ada di `config/crawl.php`.

Parameter penting:

- `main_admin_id`: ID admin yang boleh menjalankan crawler.
- `allowed_hosts`: daftar domain yang diizinkan.
- `daily_limit`: batas maksimal crawl per hari.
- `cooldown_minutes`: jeda antar eksekusi.
- `max_urls_per_run`: jumlah URL yang diproses per run.
- `default_source_urls`: daftar URL default untuk mode otomatis.

Contoh environment:

```env
CRAWL_MAIN_ADMIN_ID=1
CRAWL_DAILY_LIMIT=3
CRAWL_COOLDOWN_MINUTES=240
CRAWL_MAX_URLS_PER_RUN=5
CRAWL_DEFAULT_SOURCE_URLS=https://example.com/jobs,https://example.org/career
```

## 4. Cara Menjalankan Manual dari Dashboard

1. Login ke panel admin.
2. Buka menu **Web Crawler**.
3. Masukkan satu atau beberapa URL sumber pada kolom **Source URLs**.
4. Pastikan URL masih berada dalam domain yang diizinkan.
5. Klik **Jalankan Crawler**.

Hasil crawling akan:

- Disimpan ke tabel `lowongans`.
- Menggunakan `sumber = crawl`.
- Diset sebagai `status = draft`.
- Muncul di halaman validasi crawler.

## 5. Cara Approve Data Hasil Crawl

Setelah data masuk:

1. Buka halaman **Web Crawler**.
2. Lihat daftar lowongan hasil crawl yang masih draft.
3. Periksa judul, perusahaan, deskripsi, dan sumbernya.
4. Klik tombol approve untuk mengubah status menjadi aktif.

## 6. Menjalankan via Artisan

Kamu juga bisa menjalankan crawler lewat command:

```bash
php artisan crawl:run
```

Jika ingin menentukan source URL manual:

```bash
php artisan crawl:run --source-urls="https://example.com/job-1,https://example.com/job-2"
```

## 7. Mode Otomatis / Scheduler

Scheduler sudah disiapkan di `routes/console.php` dengan jadwal setiap 8 jam.

Agar scheduler jalan, pastikan server menjalankan cron Laravel:

```bash
php artisan schedule:run
```

Biasanya perintah ini dipanggil oleh cron server setiap menit.

## 8. Batasan Penggunaan

Fitur ini dibatasi supaya tetap hemat resource:

- Hanya admin utama yang bisa menjalankan crawler.
- Ada batas harian.
- Ada cooldown antar run.
- Ada batas jumlah URL per eksekusi.
- Hanya domain yang diizinkan yang bisa diproses.

Jika batas sudah habis, crawler akan menolak proses baru sampai hari berikutnya atau cooldown selesai.

## 9. Alur Penyimpanan Data

Alurnya adalah:

1. Admin menjalankan crawler.
2. URL sumber divalidasi.
3. Data diambil dari halaman sumber.
4. Data disaring dan dicegah dari duplikasi.
5. Data disimpan ke database sebagai draft.
6. Admin melakukan validasi manual.
7. Data dipublikasikan menjadi aktif.

## 10. Troubleshooting

### Crawler tidak jalan

Cek apakah:

- Kamu login sebagai admin utama.
- URL sumber valid dan berada di allowlist.
- Limit harian belum habis.
- Cooldown sudah selesai.

### Data tidak muncul

Cek apakah:

- Halaman sumber dapat diakses dari server.
- Struktur HTML sumber tidak berubah.
- URL memang mengandung informasi lowongan yang bisa diekstrak.

### Scheduler tidak jalan

Cek apakah cron server sudah memanggil:

```bash
php artisan schedule:run
```

## 11. Catatan Penting

- Fitur ini dirancang untuk crawling ringan dan gratis.
- Hindari scraping berlebihan agar server tidak cepat habis resource.
- Gunakan sumber publik yang memang diizinkan untuk diambil datanya.
