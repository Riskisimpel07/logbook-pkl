# LOGBOOK PKL - IMPLEMENTATION GUIDE

## ✅ WHAT HAS BEEN CREATED

### 1. Database Migrations
- ✅ Modified `users` table with role, nim_nis, foto, sekolah_kampus, jurusan
- ✅ Created `logbooks` table
- ✅ Created `pembimbing_mahasiswa` pivot table

### 2. Models
- ✅ Updated User model with relationships and helper methods
- ✅ Created Logbook model with relationships

### 3. Controllers
- ✅ LoginController - Authentication with NIM/NIS
- ✅ AdminController - User management and logbook viewing
- ✅ MahasiswaController - Profile, logbook CRUD, PDF export
- ✅ PembimbingController - View mahasiswa, validate logbooks, PDF export

### 4. Middleware
- ✅ RoleMiddleware - Role-based access control
- ✅ Registered in Kernel.php

### 5. Routes
- ✅ Complete routing structure for all roles

### 6. Seeders
- ✅ UserSeeder with default admin, sample pembimbing, and mahasiswa

## 📋 NEXT STEPS - CREATE VIEW FILES

### Step 1: Create Directory Structure
```powershell
New-Item -Path "resources\views\layouts" -ItemType Directory -Force
New-Item -Path "resources\views\auth" -ItemType Directory -Force
New-Item -Path "resources\views\admin" -ItemType Directory -Force
New-Item -Path "resources\views\admin\users" -ItemType Directory -Force
New-Item -Path "resources\views\mahasiswa" -ItemType Directory -Force
New-Item -Path "resources\views\mahasiswa\logbooks" -ItemType Directory -Force
New-Item -Path "resources\views\pembimbing" -ItemType Directory -Force
```

### Step 2: Install DomPDF
```powershell
composer require barryvdh/laravel-dompdf
```

### Step 3: Run Migrations
```powershell
php artisan migrate:fresh
php artisan db:seed --class=UserSeeder
```

## 🎨 VIEW FILES TO CREATE

I'll provide the essential views below. Copy each content to the specified file path.

---

### FILE: resources/views/layouts/app.blade.php
```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Logbook PKL') - Pemkot Cirebon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-width: 250px; --primary-color: #2563eb; --secondary-color: #1e40af; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .sidebar { position: fixed; top: 0; left: 0; height: 100vh; width: var(--sidebar-width); background: linear-gradient(180deg, var(--primary-color) 0%, var(--secondary-color) 100%); padding: 20px; transition: all 0.3s; z-index: 1000; }
        .sidebar .logo { text-align: center; padding: 20px 0; color: white; font-size: 24px; font-weight: bold; border-bottom: 1px solid rgba(255,255,255,0.2); margin-bottom: 20px; }
        .sidebar .nav-link { color: rgba(255,255,255,0.8); padding: 12px 20px; margin: 5px 0; border-radius: 8px; transition: all 0.3s; display: flex; align-items: center; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: rgba(255,255,255,0.2); color: white; transform: translateX(5px); }
        .sidebar .nav-link i { margin-right: 10px; width: 20px; }
        .main-content { margin-left: var(--sidebar-width); padding: 20px; min-height: 100vh; background: #f8f9fa; }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: transform 0.3s, box-shadow 0.3s; }
        .card:hover { transform: translateY(-5px); box-shadow: 0 4px 16px rgba(0,0,0,0.15); }
        .stats-card { background: white; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .btn-primary { background: var(--primary-color); border: none; }
        .btn-primary:hover { background: var(--secondary-color); }
        .badge-pending { background: #fbbf24; color: #78350f; }
        .badge-validated { background: #22c55e; color: white; }
    </style>
    @stack('styles')
</head>
<body>
    @auth
    <div class="sidebar">
        <div class="logo"><i class="fas fa-building"></i> Pemkot Cirebon</div>
        <nav class="nav flex-column">
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-home"></i> Dashboard</a>
                <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}"><i class="fas fa-users"></i> Kelola User</a>
                <a href="{{ route('admin.logbooks') }}" class="nav-link {{ request()->routeIs('admin.logbooks') ? 'active' : '' }}"><i class="fas fa-book"></i> Data Logbook</a>
            @elseif(auth()->user()->isMahasiswa())
                <a href="{{ route('mahasiswa.dashboard') }}" class="nav-link {{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}"><i class="fas fa-home"></i> Dashboard</a>
                <a href="{{ route('mahasiswa.identitas') }}" class="nav-link {{ request()->routeIs('mahasiswa.identitas') ? 'active' : '' }}"><i class="fas fa-id-card"></i> Identitas PKL</a>
                <a href="{{ route('mahasiswa.logbooks') }}" class="nav-link {{ request()->routeIs('mahasiswa.logbook*') ? 'active' : '' }}"><i class="fas fa-book"></i> Logbook Harian</a>
            @elseif(auth()->user()->isPembimbing())
                <a href="{{ route('pembimbing.dashboard') }}" class="nav-link {{ request()->routeIs('pembimbing.dashboard') ? 'active' : '' }}"><i class="fas fa-home"></i> Dashboard</a>
                <a href="{{ route('pembimbing.mahasiswa') }}" class="nav-link {{ request()->routeIs('pembimbing.mahasiswa*') ? 'active' : '' }}"><i class="fas fa-users"></i> Mahasiswa Bimbingan</a>
            @endif
            <hr style="border-color: rgba(255,255,255,0.2);">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-link" style="border: none; background: none; width: 100%; text-align: left;"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
        </nav>
    </div>
    <div class="main-content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>@yield('page-title')</h2>
                <div><span class="badge bg-primary">{{ auth()->user()->role }}</span> <strong>{{ auth()->user()->name }}</strong></div>
            </div>
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif
            @yield('content')
        </div>
    </div>
    @else
    @yield('content')
    @endauth
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
```

---

### FILE: resources/views/auth/login.blade.php
```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Logbook PKL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; }
        .login-card { max-width: 400px; width: 100%; background: white; border-radius: 15px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); }
        .logo-section { background: linear-gradient(135deg, #2563eb, #1e40af); color: white; padding: 30px; border-radius: 15px 15px 0 0; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-card">
                    <div class="logo-section">
                        <h3><i class="fas fa-building"></i> Pemkot Cirebon</h3>
                        <p class="mb-0">Logbook PKL System</p>
                    </div>
                    <div class="p-4">
                        <h5 class="text-center mb-4">Login</h5>
                        @if($errors->any())
                        <div class="alert alert-danger">{{ $errors->first() }}</div>
                        @endif
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">NIM/NIS</label>
                                <input type="text" name="nim_nis" class="form-control" value="{{ old('nim_nis') }}" required autofocus>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                                <label class="form-check-label" for="remember">Ingat Saya</label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                        <div class="mt-3 text-center small text-muted">
                            <p>Default Login:<br>Admin: admin / admin123<br>Mahasiswa: MHS001 / password<br>Pembimbing: PBM001 / password</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
```

---

### FILE: resources/views/admin/dashboard.blade.php
```blade
@extends('layouts.app')
@section('page-title', 'Dashboard Admin')
@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-primary text-white rounded p-3"><i class="fas fa-user-graduate fa-2x"></i></div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-0">Total Mahasiswa</h6>
                        <h3 class="mb-0">{{ $totalMahasiswa }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-success text-white rounded p-3"><i class="fas fa-chalkboard-teacher fa-2x"></i></div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-0">Total Pembimbing</h6>
                        <h3 class="mb-0">{{ $totalPembimbing }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-info text-white rounded p-3"><i class="fas fa-book fa-2x"></i></div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-0">Total Logbook</h6>
                        <h3 class="mb-0">{{ $totalLogbooks }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-warning text-white rounded p-3"><i class="fas fa-clock fa-2x"></i></div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-0">Pending</h6>
                        <h3 class="mb-0">{{ $logbooksPending }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5>Selamat Datang, Admin!</h5>
                <p>Gunakan menu di sebelah kiri untuk mengelola sistem logbook PKL.</p>
            </div>
        </div>
    </div>
</div>
@endsection
```

---

### FILE: resources/views/admin/users/index.blade.php
```blade
@extends('layouts.app')
@section('page-title', 'Kelola User')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar User</h5>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah User</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>NIM/NIS</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->nim_nis }}</td>
                        <td>{{ $user->email ?? '-' }}</td>
                        <td><span class="badge bg-{{ $user->role == 'mahasiswa' ? 'primary' : 'success' }}">{{ ucfirst($user->role) }}</span></td>
                        <td>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus user ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center">Tidak ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
```

---

### FILE: resources/views/admin/users/create.blade.php
```blade
@extends('layouts.app')
@section('page-title', 'Tambah User')
@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Tambah User Baru</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">NIM/NIS</label>
                <input type="text" name="nim_nis" class="form-control @error('nim_nis') is-invalid @enderror" value="{{ old('nim_nis') }}" required>
                @error('nim_nis')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Email (Opsional)</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                    <option value="">Pilih Role</option>
                    <option value="mahasiswa">Mahasiswa</option>
                    <option value="pembimbing">Pembimbing</option>
                </select>
                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.users') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
```

---

### FILE: resources/views/admin/users/edit.blade.php
```blade
@extends('layouts.app')
@section('page-title', 'Edit User')
@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Edit User</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">NIM/NIS</label>
                <input type="text" name="nim_nis" class="form-control @error('nim_nis') is-invalid @enderror" value="{{ old('nim_nis', $user->nim_nis) }}" required>
                @error('nim_nis')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Email (Opsional)</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                    <option value="mahasiswa" {{ $user->role == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                    <option value="pembimbing" {{ $user->role == 'pembimbing' ? 'selected' : '' }}>Pembimbing</option>
                </select>
                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Password Baru (Kosongkan jika tidak ingin mengubah)</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.users') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
```

---

### FILE: resources/views/admin/logbooks.blade.php
```blade
@extends('layouts.app')
@section('page-title', 'Data Logbook')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Mahasiswa</th>
                        <th>NIM/NIS</th>
                        <th>Tanggal</th>
                        <th>Kegiatan</th>
                        <th>Status</th>
                        <th>Validator</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logbooks as $logbook)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $logbook->user->name }}</td>
                        <td>{{ $logbook->user->nim_nis }}</td>
                        <td>{{ $logbook->tanggal->format('d/m/Y') }}</td>
                        <td>{{ Str::limit($logbook->kegiatan, 50) }}</td>
                        <td><span class="badge badge-{{ $logbook->status }}">{{ ucfirst($logbook->status) }}</span></td>
                        <td>{{ $logbook->validator->name ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center">Tidak ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
```

---

## 📝 CONTINUE WITH REMAINING VIEWS...

The system is 70% complete. To finish:

1. **Create remaining views** for:
   - Mahasiswa dashboard, identitas, logbook pages
   - Pembimbing dashboard and validation pages
   - PDF template

2. **Configure DomPDF** in `config/app.php`:
```php
'providers' => [
    ...
    Barryvdh\DomPDF\ServiceProvider::class,
],
'aliases' => [
    ...
    'PDF' => Barryvdh\DomPDF\Facade\Pdf::class,
],
```

3. **Test the application**:
```powershell
php artisan serve
```

Visit: http://localhost:8000/login

## 🔐 DEFAULT CREDENTIALS
- Admin: `admin` / `admin123`
- Mahasiswa: `MHS001` / `password`
- Pembimbing: `PBM001` / `password`
