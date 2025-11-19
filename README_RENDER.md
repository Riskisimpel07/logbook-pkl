Panduan singkat deploy ke Render.com

1. File yang sudah ditambahkan

-   `Dockerfile` - container image sederhana menjalankan `php artisan serve` di port 10000.
-   `.dockerignore` - mengurangi konteks build.
-   `render.yaml` - contoh konfigurasi untuk Render (opsional).

NOTE: Jika saat ini Anda mengembangkan di Laragon/MySQL lokal, Render tidak akan bisa menggunakan database tersebut. Pilihan cepat dan aman untuk deploy awal:

-   Gunakan SQLite: saya sudah menambahkan `database/database.sqlite` ke repo dan mengubah contoh `.env.example` sehingga `DB_CONNECTION=sqlite` dan `DB_DATABASE=database/database.sqlite`.

2. Langkah di Dashboard Render

-   Buat layanan baru (New Web Service) -> Connect repo (GitHub/GitLab) -> pilih branch.
-   Pilih environment: `Docker` (Render akan menggunakan `Dockerfile`).
-   Set `Dockerfile` path: `Dockerfile` (sudah di root).

3. Environment variables penting (set di Render -> Environment):

-   `APP_ENV=production`
-   `APP_DEBUG=false`
-   `APP_KEY` (generate di local: `php artisan key:generate --show` -> copy to Render)
-   Database: `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`

Langkah singkat untuk menggunakan SQLite di Render (sudah disiapkan):

1. Di Render dashboard → Environment, tambahkan/cek:
    - `APP_KEY` (sudah Anda set)
    - `APP_ENV=production`
    - `APP_DEBUG=false`
    - `DB_CONNECTION=sqlite`
    - `DB_DATABASE=database/database.sqlite`
2. Pastikan file `database/database.sqlite` termasuk di repo (sudah ditambahkan).
3. Deploy service. `render.yaml` sudah mengaktifkan `postDeploy` yang menjalankan:
    - `php artisan migrate --force`
    - `php artisan storage:link`
      Jadi seharusnya tabel akan dibuat otomatis setelah build.

Catatan:

-   SQLite file akan tersimpan di filesystem container Render (ephemeral). Untuk aplikasi production, gunakan managed DB (Postgres/MySQL) dan storage object (S3) untuk file yang harus persist.
-   Jika ingin menggunakan Managed Database (Postgres) di Render, saya bisa bantu konfigurasi `DB_*` vars.

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
