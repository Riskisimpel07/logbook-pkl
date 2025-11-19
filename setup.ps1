# Laravel Logbook PKL - Setup Script
# Run this file to create all necessary view files

# Create directories
New-Item -Path "resources\views\layouts" -ItemType Directory -Force
New-Item -Path "resources\views\auth" -ItemType Directory -Force
New-Item -Path "resources\views\admin\users" -ItemType Directory -Force
New-Item -Path "resources\views\mahasiswa\logbooks" -ItemType Directory -Force
New-Item -Path "resources\views\pembimbing" -ItemType Directory -Force

Write-Host "Directories created successfully!" -ForegroundColor Green
Write-Host "Now running composer install for DomPDF..." -ForegroundColor Yellow

# Install DomPDF
composer require barryvdh/laravel-dompdf

Write-Host "Setup complete! Next steps:" -ForegroundColor Green
Write-Host "1. Run: php artisan migrate:fresh" -ForegroundColor Cyan
Write-Host "2. Run: php artisan db:seed --class=UserSeeder" -ForegroundColor Cyan
Write-Host "3. Login with nim_nis: admin, password: admin123" -ForegroundColor Cyan
