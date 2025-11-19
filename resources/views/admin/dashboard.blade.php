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
                <h5><i class="fas fa-info-circle"></i> Selamat Datang, Admin!</h5>
                <p>Gunakan menu di sebelah kiri untuk mengelola sistem logbook PKL Balaikota Cirebon.</p>
            </div>
        </div>
    </div>
</div>
@endsection
