Panduan singkat deploy ke Render.com

1. File yang sudah ditambahkan

-   `Dockerfile` - container image sederhana menjalankan `php artisan serve` di port 10000.
-   `.dockerignore` - mengurangi konteks build.
-   `render.yaml` - contoh konfigurasi untuk Render (opsional).

2. Langkah di Dashboard Render

-   Buat layanan baru (New Web Service) -> Connect repo (GitHub/GitLab) -> pilih branch.
-   Pilih environment: `Docker` (Render akan menggunakan `Dockerfile`).
-   Set `Dockerfile` path: `Dockerfile` (sudah di root).

3. Environment variables penting (set di Render -> Environment):

-   `APP_ENV=production`
-   `APP_DEBUG=false`
-   `APP_KEY` (generate di local: `php artisan key:generate --show` -> copy to Render)
-   Database: `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`

4. Storage

-   Render containers bersifat ephemeral. Untuk menyimpan file yang diupload gunakan S3 / Spaces. Jika tetap pakai `public/storage`, pertimbangkan menaruh file di object storage.

5. Migrate & seed

-   Di Render dashboard -> `Shell` / `Console` -> jalankan:
    -   `php artisan migrate --force`
    -   `php artisan storage:link` (jika perlu)

6. Cek local sebelum push

-   Build image local (opsional):
    ```powershell
    docker build -t logbook-pkl .
    docker run -p 10000:10000 logbook-pkl
    # buka http://localhost:10000
    ```

Catatan: Dockerfile ini memakai PHP built-in server untuk memudahkan deploy cepat. Untuk production yang lebih stabil, gunakan PHP-FPM + Nginx atau image yang sudah dioptimasi.
