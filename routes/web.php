<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PembimbingController;

// Redirect root to login
Route::get('/', function () {
    return redirect('/login');
});

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::get('/logbooks', [AdminController::class, 'logbooks'])->name('admin.logbooks');
    Route::get('/assign-pembimbing', [AdminController::class, 'showAssignPembimbing'])->name('admin.assign.pembimbing');
    Route::post('/assign-pembimbing', [AdminController::class, 'assignPembimbing'])->name('admin.assign.pembimbing.store');
});

// Mahasiswa Routes
Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->group(function () {
    Route::get('/dashboard', [MahasiswaController::class, 'dashboard'])->name('mahasiswa.dashboard');
    Route::get('/identitas', [MahasiswaController::class, 'identitas'])->name('mahasiswa.identitas');
    Route::put('/identitas', [MahasiswaController::class, 'updateIdentitas'])->name('mahasiswa.identitas.update');
    Route::get('/logbook', [MahasiswaController::class, 'logbooks'])->name('mahasiswa.logbooks');
    Route::get('/logbook/create', [MahasiswaController::class, 'createLogbook'])->name('mahasiswa.logbook.create');
    Route::post('/logbook', [MahasiswaController::class, 'storeLogbook'])->name('mahasiswa.logbook.store');
    Route::get('/logbook/{id}/edit', [MahasiswaController::class, 'editLogbook'])->name('mahasiswa.logbook.edit');
    Route::put('/logbook/{id}', [MahasiswaController::class, 'updateLogbook'])->name('mahasiswa.logbook.update');
    Route::delete('/logbook/{id}', [MahasiswaController::class, 'deleteLogbook'])->name('mahasiswa.logbook.delete');
    Route::get('/logbook/pdf', [MahasiswaController::class, 'downloadPdf'])->name('mahasiswa.logbook.pdf');
});

// Pembimbing Routes
Route::middleware(['auth', 'role:pembimbing'])->prefix('pembimbing')->group(function () {
    Route::get('/dashboard', [PembimbingController::class, 'dashboard'])->name('pembimbing.dashboard');
    Route::get('/mahasiswa', [PembimbingController::class, 'mahasiswaList'])->name('pembimbing.mahasiswa');
    Route::get('/mahasiswa/{id}/logbook', [PembimbingController::class, 'mahasiswaLogbooks'])->name('pembimbing.mahasiswa.logbooks');
    Route::post('/logbook/{id}/validasi', [PembimbingController::class, 'validateLogbook'])->name('pembimbing.logbook.validate');
    Route::get('/mahasiswa/{id}/pdf', [PembimbingController::class, 'downloadPdf'])->name('pembimbing.mahasiswa.pdf');
});

