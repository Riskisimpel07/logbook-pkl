@extends('layouts.app')
@section('page-title', 'Mahasiswa Bimbingan')
@section('content')
<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">Daftar Mahasiswa Bimbingan</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>NIM/NIS</th>
                        <th>Sekolah/Kampus</th>
                        <th>Jurusan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mahasiswas as $mahasiswa)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $mahasiswa->name }}</td>
                        <td><strong>{{ $mahasiswa->nim_nis }}</strong></td>
                        <td>{{ $mahasiswa->sekolah_kampus ?? '-' }}</td>
                        <td>{{ $mahasiswa->jurusan ?? '-' }}</td>
                        <td>
                            <a href="{{ route('pembimbing.mahasiswa.logbooks', $mahasiswa->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-book"></i> Lihat Logbook
                            </a>
                            <a href="{{ route('pembimbing.mahasiswa.pdf', $mahasiswa->id) }}" class="btn btn-sm btn-danger">
                                <i class="fas fa-file-pdf"></i> PDF
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center">Tidak ada mahasiswa bimbingan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
