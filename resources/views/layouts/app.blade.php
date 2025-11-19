<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Logbook PKL') - Pemkot Cirebon</title>
    <!-- Favicon and OpenGraph image (uses image in public storage/berkas) -->
    <link rel="icon" type="image/png" href="{{ asset('storage/berkas/lambang_kota_cirebon.png') }}">
    <link rel="shortcut icon" href="{{ asset('storage/berkas/lambang_kota_cirebon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('storage/berkas/lambang_kota_cirebon.png') }}">
    <!-- fallback if file uses different casing on developer machine -->
    <link rel="icon" type="image/png" href="{{ asset('storage/berkas/Lambang_Kota_Cirebon.png') }}">
    <meta property="og:image" content="{{ asset('storage/berkas/lambang_kota_cirebon.png') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:image" content="{{ asset('storage/berkas/lambang_kota_cirebon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-width: 250px; --primary-color: #2563eb; --secondary-color: #1e40af; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 33%, #f7f8fa 66%, #e0eafc 100%);
            animation: bgColorChange 20s ease-in-out infinite;
            transition: background 2s ease;
        }
        @keyframes bgColorChange {
            0% { background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%); }
            33% { background: linear-gradient(135deg, #f7f8fa 0%, #e0eafc 100%); }
            66% { background: linear-gradient(135deg, #dbe6e4 0%, #b7cbe2 100%); }
            100% { background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%); }
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            padding: 20px;
            transition: all 0.3s;
            z-index: 1000;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        @media (max-width: 768px) {
            .sidebar {
                background: url('/storage/berkas/gambar2.jpeg') no-repeat center center;
                background-size: cover;
                animation: none;
            }
        }
        .sidebar .logo {
            text-align: center;
            padding: 20px 0 10px 0;
            color: #fff;
            font-size: 24px;
            font-weight: bold;
            border-bottom: 1px solid rgba(255,255,255,0.2);
            margin-bottom: 10px;
            text-shadow: 0 2px 8px rgba(0,0,0,0.25);
        }
        .sidebar .logo img {
            height: 48px;
            margin-bottom: 8px;
            filter: drop-shadow(0 2px 8px rgba(0,0,0,0.25));
        }
        .sidebar .nav-link {
            color: #fff;
            padding: 12px 20px;
            margin: 5px 0;
            border-radius: 8px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            text-shadow: 0 1px 4px rgba(0,0,0,0.18);
            background: rgba(0,0,0,0.18);
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: rgba(0,0,0,0.32);
            color: #fff;
            transform: translateX(5px);
        }
        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
        }
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            min-height: 100vh;
            background: rgba(255,255,255,0.85);
            border-radius: 20px 0 0 20px;
            transition: background 2s ease;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 20px;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 16px rgba(0,0,0,0.15);
        }
        .btn-primary { background: var(--primary-color); border: none; }
        .btn-primary:hover { background: var(--secondary-color); }
        .badge-pending { background: #fbbf24; color: #78350f; }
        .badge-validated { background: #22c55e; color: white; }
        @media (max-width: 900px) {
            .main-content { margin-left: 0; border-radius: 0; }
            .sidebar { width: 100vw; height: auto; position: static; flex-direction: row; justify-content: space-between; }
            .sidebar .logo { border-bottom: none; margin-bottom: 0; padding: 10px; }
        }
        @media (max-width: 768px) {
            .sidebar { flex-direction: row; width: 100vw; height: auto; position: static; padding: 10px; }
            .main-content { margin-left: 0; border-radius: 0; padding: 10px; }
        }
    </style>
    @stack('styles')
</head>
<body>
    @auth
    <div class="sidebar">
        <div class="logo">
            <img src="/storage/berkas/lambang_kota_cirebon.png" alt="Logo Kota Cirebon"><br>
            E-Logbook PKL<P> Setda Kota Cirebon
        </div>
        <nav class="nav flex-column">
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-home"></i> Dashboard</a>
                <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}"><i class="fas fa-users"></i> Kelola User</a>
                <a href="{{ route('admin.assign.pembimbing') }}" class="nav-link {{ request()->routeIs('admin.assign*') ? 'active' : '' }}"><i class="fas fa-user-tie"></i> Assign Pembimbing</a>
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
                <div>
                    <span class="badge bg-primary">
                        {{ auth()->user()->role == 'mahasiswa' ? 'Mahasiswa/Siswa' : ucfirst(auth()->user()->role) }}
                    </span>
                    <strong>{{ auth()->user()->name }}</strong>
                </div>
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
