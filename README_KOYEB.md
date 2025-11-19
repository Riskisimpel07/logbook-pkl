Panduan singkat deploy ke Koyeb (GitHub repo + Dockerfile)

1) Ringkasan
- Repo ini sudah berisi `Dockerfile` yang telah diperbarui untuk menjalankan entrypoint yang menghormati variabel lingkungan `PORT` (Koyeb menyuntikkan port runtime).
- Ditambahkan `docker-entrypoint.sh` yang menjalankan `php artisan migrate --force` dan `php artisan storage:link` (jika tersedia), lalu memulai server Laravel built-in pada `0.0.0.0:$PORT`.

2) Langkah-langkah di Koyeb (cepat)
- Login ke https://app.koyeb.com
- Create -> App -> Connect Git Repository -> pilih GitHub dan repository `Riskisimpel07/logbook-pkl`.
- Pilih branch `main`.
- Build settings:
  - Build method: `Dockerfile` (pilih option yang sesuai di UI)
  - Dockerfile path: `Dockerfile` (root)
- Container port: Koyeb akan memberikan `PORT` runtime (tidak perlu diisi biasanya). Jika diminta, isi `8080` atau biarkan default; entrypoint menggunakan `PORT` env var.

3) Environment variables yang harus ditetapkan di Koyeb (App -> Settings -> Environment Variables):
- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_KEY` = (generate di lokal) `php artisan key:generate --show` -> copy ke Koyeb
- Database (pilihan cepat dengan SQLite):
  - `DB_CONNECTION=sqlite`
  - `DB_DATABASE=database/database.sqlite`

Catatan: Koyeb container filesystem adalah ephemeral — file yang ditulis ke `storage` tidak akan persist setelah instance diganti. Untuk produksi, gunakan object storage (S3-compatible) dan managed database.

4) Jika Anda ingin menggunakan Managed Database (Postgres) di Koyeb:
- Buat service Database (Postgres) di Koyeb (Add -> Database)
- Copy connection string dan set env vars:
  - `DB_CONNECTION=pgsql`
  - `DB_HOST=` (host dari DB)
  - `DB_PORT=`
  - `DB_DATABASE=`
  - `DB_USERNAME=`
  - `DB_PASSWORD=`

5) Hooks / Post-deploy
- Karena entrypoint menjalankan `php artisan migrate --force` dan `php artisan storage:link`, Anda tidak perlu mengeksekusi perintah manual setelah deploy (kecuali DB belum siap pada saat container start, dalam kasus itu jalankan migrate via console Koyeb).

6) Test local (optional)
- Build image locally dan jalankan:
```powershell
docker build -t logbook-pkl .
# jalankan container, map port 8080
docker run -p 8080:8080 -e PORT=8080 logbook-pkl
# buka http://localhost:8080
```

7) Setelah deploy di Koyeb
- Buka URL yang diberikan Koyeb.
- Cek halaman login, coba download PDF.
- Jika file upload diperlukan: pertimbangkan konfigurasi S3 dan set `FILESYSTEM_DISK=s3` serta env vars `AWS_*`.

Jika mau, saya bisa:
- Menjalankan commit & push perubahan (saya akan lakukan sekarang jika Anda setuju).
- Membuat instruksi step-by-step lengkap dengan screenshot/command yang bisa Anda copy-paste untuk Koyeb UI.
