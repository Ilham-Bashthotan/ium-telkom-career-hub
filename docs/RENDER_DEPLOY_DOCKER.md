# Panduan Deploy ke Render (Gratis) dengan Docker

Dokumen ini menjelaskan cara deploy `ium-telkom-career-hub` ke Render memakai Docker, tanpa database atau storage persisten. Cocok kalau data boleh hilang saat restart atau redeploy.

## Gambaran Singkat

Setup di repo ini sudah disiapkan untuk:

- Laravel berjalan di container Docker
- SQLite sebagai database
- Upload file disimpan di disk lokal container
- Session, cache, dan queue memakai file/sync
- `render.yaml` dipakai untuk konfigurasi service Render

## Prasyarat

- Repository sudah ada di GitHub
- Akun Render sudah login
- Branch yang akan dideploy: `render-setup`
- `APP_KEY` sudah ada untuk production, atau akan di-generate saat container start

## File Penting

- [Dockerfile](../Dockerfile)
- [docker/entrypoint.sh](../docker/entrypoint.sh)
- [render.yaml](../render.yaml)

## Nilai Env yang Dipakai di Render

Nilai ini yang paling penting untuk service Render:

- `APP_NAME=Telkom Career Hub`
- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL=https://ium-telkom-career-hub-1.onrender.com`
- `APP_KEY=base64:...`
- `DB_CONNECTION=sqlite`
- `DB_DATABASE=/opt/render/project/src/database/database.sqlite`
- `SESSION_DRIVER=file`
- `CACHE_STORE=file`
- `QUEUE_CONNECTION=sync`
- `FILESYSTEM_DISK=public`
- `MAIL_MAILER=log`

## Cara Deploy

### 1. Push branch ke GitHub

Pastikan perubahan terbaru sudah ada di branch `render-setup`:

```bash
git add .
git commit -m "Add Render Docker deployment guide"
git push origin render-setup
```

### 2. Buat Web Service di Render

1. Buka dashboard Render
2. Klik **New** -> **Web Service**
3. Pilih repository `ium-telkom-career-hub`
4. Pilih branch `render-setup`
5. Pastikan Render memakai `Dockerfile` dari root repo

### 3. Isi Environment Variables

Tambahkan atau verifikasi variable berikut di Render:

```env
APP_NAME=Telkom Career Hub
APP_ENV=production
APP_DEBUG=false
APP_URL=https://ium-telkom-career-hub-1.onrender.com
APP_KEY=base64:qrmGS6VvcAt/I+eTc9eCDn1BZ9YNyRcjEq1TiedRdYQ=
DB_CONNECTION=sqlite
DB_DATABASE=/opt/render/project/src/database/database.sqlite
SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
FILESYSTEM_DISK=public
MAIL_MAILER=log
MAIL_FROM_ADDRESS=noreply@telkomcareerhub.test
MAIL_FROM_NAME=Telkom Career Hub
VITE_APP_NAME=Telkom Career Hub
```

### 4. Deploy

Klik **Create Web Service** lalu tunggu build selesai.

Saat container start, `docker/entrypoint.sh` akan:

- memastikan folder `database`, `storage`, dan `bootstrap/cache` ada
- membuat `.env` dari `.env.example` jika perlu
- generate `APP_KEY` jika belum ada
- membuat `database.sqlite` jika belum ada
- menjalankan `migrate` dan `db:seed`
- membuat storage link

## Alur Startup di Render

Urutannya seperti ini:

1. Render membaca env vars dari dashboard dan `render.yaml`
2. Docker image dibangun dari `Dockerfile`
3. Container start dan menjalankan `docker/entrypoint.sh`
4. Laravel bootstrap berjalan memakai env production
5. Apache melayani request dari port default container

## Kenapa Tidak Pakai `SESSION_DRIVER=database`?

Karena project ini memang tidak perlu data sesi yang bertahan lama. Kalau pakai `database`, Laravel akan butuh tabel `sessions` dan itu menambah titik gagal.

Dengan `file`, aplikasi lebih simpel dan cocok untuk free plan Render.

## Kalau Muncul Error 500

Cek berurutan berikut:

1. Render logs
2. `APP_KEY` di dashboard sudah terisi
3. `APP_URL` sesuai URL service Render
4. `SESSION_DRIVER=file`
5. `CACHE_STORE=file`
6. `DB_CONNECTION=sqlite`
7. `DB_DATABASE=/opt/render/project/src/database/database.sqlite`

Jika error masih ada, lihat file log Laravel di container atau cek apakah ada migration yang gagal.

## Catatan Penting

- Data SQLite akan hilang jika container diredeploy atau restart
- Upload gambar juga ikut hilang karena storage container bersifat sementara
- Ini memang cocok untuk penggunaan gratis dan demo

## Cek Lokal Sebelum Deploy

Kalau mau tes sebelum push:

```bash
docker build -t ium-telkom-career-hub:local .
docker run -p 8080:80 --name ium-telkom-career-hub-local ium-telkom-career-hub:local
```

Lalu buka:

```text
http://127.0.0.1:8080
```

## Ringkasan

Kalau semua env di Render sudah benar, repo ini bisa deploy gratis dengan Docker tanpa pakai database eksternal. Yang paling penting adalah `APP_KEY`, `APP_URL`, `DB_CONNECTION`, `SESSION_DRIVER`, dan `CACHE_STORE`.
