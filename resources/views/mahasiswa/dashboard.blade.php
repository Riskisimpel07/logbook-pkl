@extends('layouts.app')
@section('page-title', 'Dashboard Mahasiswa')
@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-primary text-white rounded p-3"><i class="fas fa-book fa-2x"></i></div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-0">Total Logbook</h6>
                        <h3 class="mb-0">{{ $totalLogbooks }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
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
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-success text-white rounded p-3"><i class="fas fa-check-circle fa-2x"></i></div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-0">Tervalidasi</h6>
                        <h3 class="mb-0">{{ $logbooksValidated }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h5><i class="fas fa-info-circle"></i> Selamat Datang!</h5>
                <p>Silakan lengkapi identitas PKL Anda dan mulai mengisi logbook harian.</p>
                <div class="d-flex gap-2">
                    <a href="{{ route('mahasiswa.identitas') }}" class="btn btn-primary"><i class="fas fa-id-card"></i> Isi Identitas</a>
                    <a href="{{ route('mahasiswa.logbook.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Tambah Logbook</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5><i class="fas fa-user"></i> Profil</h5>
                <p class="mb-1"><strong>NIM/NIS:</strong> {{ auth()->user()->nim_nis }}</p>
                <p class="mb-1"><strong>Nama:</strong> {{ auth()->user()->name }}</p>
                @if(auth()->user()->sekolah_kampus)
                <p class="mb-1"><strong>Kampus:</strong> {{ auth()->user()->sekolah_kampus }}</p>
                <p class="mb-0"><strong>Jurusan:</strong> {{ auth()->user()->jurusan }}</p>
                @else
                <p class="text-muted mb-0"><small>Identitas belum lengkap</small></p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
