@extends('layouts.app')
@section('page-title', 'Kelola User')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center bg-white">
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
                        <td><strong>{{ $user->nim_nis }}</strong></td>
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
                    <tr><td colspan="6" class="text-center">Tidak ada data user</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
