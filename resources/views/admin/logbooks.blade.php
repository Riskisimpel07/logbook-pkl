@extends('layouts.app')
@section('page-title', 'Data Logbook')
@section('content')
<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">Semua Logbook (Read Only)</h5>
    </div>
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
                        <td><strong>{{ $logbook->user->nim_nis }}</strong></td>
                        <td>{{ $logbook->tanggal->format('d/m/Y') }}</td>
                        <td>{{ Str::limit($logbook->kegiatan, 50) }}</td>
                        <td><span class="badge badge-{{ $logbook->status }}">{{ ucfirst($logbook->status) }}</span></td>
                        <td>{{ $logbook->validator->name ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center">Tidak ada data logbook</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
