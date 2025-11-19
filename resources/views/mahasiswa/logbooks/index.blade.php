@extends('layouts.app')
@section('page-title', 'Logbook Harian')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center bg-white">
        <h5 class="mb-0">Daftar Logbook Harian</h5>
        <div class="d-flex gap-2">
            <a href="{{ route('mahasiswa.logbook.pdf') }}" class="btn btn-danger"><i class="fas fa-file-pdf"></i> Download PDF</a>
            <a href="{{ route('mahasiswa.logbook.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Logbook</a>
        </div>
    </div>
    <div class="card-body">
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
                        <td>{{ Str::limit($logbook->kegiatan, 60) }}</td>
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
                            <a href="{{ route('mahasiswa.logbook.edit', $logbook->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if($logbook->status == 'pending')
                            <form action="{{ route('mahasiswa.logbook.delete', $logbook->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus logbook ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center">Belum ada logbook. <a href="{{ route('mahasiswa.logbook.create') }}">Tambah logbook pertama</a></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
