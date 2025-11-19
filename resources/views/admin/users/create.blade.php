@extends('layouts.app')
@section('page-title', 'Tambah User')
@section('content')
<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">Tambah User Baru</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">NIM/NIS <span class="text-danger">*</span></label>
                <input type="text" name="nim_nis" class="form-control @error('nim_nis') is-invalid @enderror" value="{{ old('nim_nis') }}" required>
                @error('nim_nis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Akan digunakan untuk login</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Email (Opsional)</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Role <span class="text-danger">*</span></label>
                <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                    <option value="">Pilih Role</option>
                    <option value="mahasiswa">Mahasiswa/Siswa</option>
                    <option value="pembimbing">Pembimbing</option>
                </select>
                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Password <span class="text-danger">*</span></label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Minimal 6 karakter</small>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                <a href="{{ route('admin.users') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
