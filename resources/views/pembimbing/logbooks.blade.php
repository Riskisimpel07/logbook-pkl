@extends('layouts.app')
@section('page-title', 'Logbook - ' . $mahasiswa->name)
@section('content')

{{-- DEBUG INFO --}}
<div class="alert alert-info">
    <strong>DEBUG:</strong> Total Logbook: {{ $logbooks->count() }} | 
    Mahasiswa ID: {{ $mahasiswa->id }} | 
    Pembimbing ID: {{ auth()->user()->id }}
</div>

<div class="card mb-3">
    <div class="card-body">
        <h5>Informasi Mahasiswa</h5>
        <div class="row">
            <div class="col-md-6">
                <p class="mb-1"><strong>Nama:</strong> {{ $mahasiswa->name }}</p>
                <p class="mb-1"><strong>NIM/NIS:</strong> {{ $mahasiswa->nim_nis }}</p>
            </div>
            <div class="col-md-6">
                <p class="mb-1"><strong>Sekolah/Kampus:</strong> {{ $mahasiswa->sekolah_kampus ?? '-' }}</p>
                <p class="mb-1"><strong>Jurusan:</strong> {{ $mahasiswa->jurusan ?? '-' }}</p>
            </div>
        </div>
        <div class="mt-3">
            <a href="{{ route('pembimbing.mahasiswa') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
            <a href="{{ route('pembimbing.mahasiswa.pdf', $mahasiswa->id) }}" class="btn btn-danger btn-sm"><i class="fas fa-file-pdf"></i> Download PDF</a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">Daftar Logbook Harian</h5>
    </div>
    <div class="card-body">
        @if($logbooks->count() == 0)
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i> Mahasiswa ini belum membuat logbook. Silakan minta mahasiswa untuk input logbook terlebih dahulu.
        </div>
        @endif
        
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Kegiatan</th>
                        <th>Foto</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logbooks as $logbook)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $logbook->tanggal->format('d/m/Y') }}</td>
                        <td>{{ Str::limit($logbook->kegiatan, 80) }}</td>
                        <td>
                            @if($logbook->foto_kegiatan)
                            <a href="{{ asset('storage/' . $logbook->foto_kegiatan) }}" target="_blank">
                                <img src="{{ asset('storage/' . $logbook->foto_kegiatan) }}" style="width: 50px; height: 50px; object-fit: cover;" class="rounded">
                            </a>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($logbook->status == 'pending')
                            <span class="badge badge-pending"><i class="fas fa-clock"></i> Pending</span>
                            @else
                            <span class="badge badge-validated"><i class="fas fa-check"></i> Tervalidasi</span>
                            @endif
                        </td>
                        <td>
                            @if($logbook->status == 'pending')
                            <form action="{{ route('pembimbing.logbook.validate', $logbook->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin validasi logbook ini?')">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">
                                    <i class="fas fa-check"></i> Validasi
                                </button>
                            </form>
                            @else
                            <span class="text-success"><i class="fas fa-check-circle"></i> Sudah divalidasi</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center">Belum ada logbook</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
