@extends('layouts.app')
@section('page-title', 'Edit Logbook')
@section('content')
<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">Edit Logbook Harian</h5>
    </div>
    <div class="card-body">
        @if($logbook->status == 'validated')
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i> <strong>Perhatian!</strong> Jika Anda mengedit logbook yang sudah divalidasi, status validasi akan hilang dan harus divalidasi ulang oleh pembimbing.
        </div>
        @endif
        <form action="{{ route('mahasiswa.logbook.update', $logbook->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', $logbook->tanggal->format('Y-m-d')) }}" required>
                @error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Kegiatan <span class="text-danger">*</span></label>
                <textarea name="kegiatan" class="form-control @error('kegiatan') is-invalid @enderror" rows="5" required>{{ old('kegiatan', $logbook->kegiatan) }}</textarea>
                @error('kegiatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Foto Kegiatan</label>
                @if($logbook->foto_kegiatan)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $logbook->foto_kegiatan) }}" style="max-width: 200px;" class="img-thumbnail">
                    <p class="text-muted small mb-0">Foto saat ini</p>
                </div>
                @endif
                <input type="file" name="foto_kegiatan" class="form-control @error('foto_kegiatan') is-invalid @enderror" accept="image/*">
                @error('foto_kegiatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto</small>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Logbook</button>
                <a href="{{ route('mahasiswa.logbooks') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
