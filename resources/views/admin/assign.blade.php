@extends('layouts.app')
@section('page-title', 'Assign Pembimbing')
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Assign Pembimbing ke Mahasiswa</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.assign.pembimbing') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Pilih Mahasiswa <span class="text-danger">*</span></label>
                        <select name="mahasiswa_id" class="form-select" required>
                            <option value="">-- Pilih Mahasiswa --</option>
                            @foreach(\App\Models\User::where('role', 'mahasiswa')->get() as $mhs)
                            <option value="{{ $mhs->id }}">{{ $mhs->name }} ({{ $mhs->nim_nis }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pilih Pembimbing <span class="text-danger">*</span></label>
                        <select name="pembimbing_id" class="form-select" required>
                            <option value="">-- Pilih Pembimbing --</option>
                            @foreach(\App\Models\User::where('role', 'pembimbing')->get() as $pmb)
                            <option value="{{ $pmb->id }}">{{ $pmb->name }} ({{ $pmb->nim_nis }})</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Assign Pembimbing</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Daftar Assignment</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Mahasiswa</th>
                            <th>Pembimbing</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Models\User::where('role', 'mahasiswa')->with('pembimbing')->get() as $mhs)
                        <tr>
                            <td>{{ $mhs->name }}</td>
                            <td>
                                @if($mhs->pembimbing->count() > 0)
                                    {{ $mhs->pembimbing->first()->name }}
                                @else
                                    <span class="text-muted">Belum ada</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
