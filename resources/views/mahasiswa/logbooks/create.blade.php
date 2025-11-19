@extends('layouts.app')
@section('page-title', 'Tambah Logbook')
@section('content')
<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">Tambah Logbook Harian</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('mahasiswa.logbook.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                @error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Kegiatan <span class="text-danger">*</span></label>
                <textarea name="kegiatan" class="form-control @error('kegiatan') is-invalid @enderror" rows="5" required>{{ old('kegiatan') }}</textarea>
                @error('kegiatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Deskripsikan kegiatan PKL Anda hari ini</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Foto Kegiatan (Opsional)</label>
                <input type="file" name="foto_kegiatan" class="form-control @error('foto_kegiatan') is-invalid @enderror" accept="image/*">
                @error('foto_kegiatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Format: JPG, PNG (Max: 2MB)</small>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Logbook</button>
                <a href="{{ route('mahasiswa.logbooks') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
