@extends('layouts.app')
@section('page-title', 'Identitas PKL')
@section('content')
<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">Identitas Peserta PKL</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('mahasiswa.identitas.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">NIM/NIS</label>
                        <input type="text" class="form-control" value="{{ $user->nim_nis }}" disabled>
                        <small class="text-muted">NIM/NIS tidak dapat diubah</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sekolah/Kampus <span class="text-danger">*</span></label>
                        <input type="text" name="sekolah_kampus" class="form-control @error('sekolah_kampus') is-invalid @enderror" value="{{ old('sekolah_kampus', $user->sekolah_kampus) }}" required>
                        @error('sekolah_kampus')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jurusan <span class="text-danger">*</span></label>
                        <input type="text" name="jurusan" class="form-control @error('jurusan') is-invalid @enderror" value="{{ old('jurusan', $user->jurusan) }}" required>
                        @error('jurusan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Foto Peserta PKL</label>
                        <div class="text-center mb-3">
                            @if($user->foto)
                            <img src="{{ asset('storage/' . $user->foto) }}" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                            @else
                            <div class="bg-light p-5 rounded">
                                <i class="fas fa-user fa-5x text-muted"></i>
                            </div>
                            @endif
                        </div>
                        <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                        @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="text-muted">Format: JPG, PNG (Max: 2MB)</small>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Identitas</button>
        </form>
    </div>
</div>
@endsection
