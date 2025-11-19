@extends('layouts.app')
@section('page-title', 'Dashboard Pembimbing')
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-primary text-white rounded p-3"><i class="fas fa-users fa-2x"></i></div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-0">Mahasiswa Bimbingan</h6>
                        <h3 class="mb-0">{{ $mahasiswaCount }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-warning text-white rounded p-3"><i class="fas fa-clock fa-2x"></i></div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-0">Logbook Pending</h6>
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
                <h5><i class="fas fa-info-circle"></i> Selamat Datang, Pembimbing!</h5>
                <p>Gunakan menu di sebelah kiri untuk melihat daftar mahasiswa bimbingan dan memvalidasi logbook mereka.</p>
                <a href="{{ route('pembimbing.mahasiswa') }}" class="btn btn-primary"><i class="fas fa-users"></i> Lihat Mahasiswa Bimbingan</a>
            </div>
        </div>
    </div>
</div>
@endsection
