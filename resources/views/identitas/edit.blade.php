<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Data Peserta PKL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .card {
            border-radius: 12px;
        }

        .preview-foto {
            width: 120px;
            height: 120px;
            border-radius: 10px;
            object-fit: cover;
            border: 2px solid #ddd;
        }
    </style>
</head>

<body>

    <div class="container py-4">

        <h2 class="mb-4 text-center fw-bold">Edit Data Peserta PKL</h2>

        <div class="card p-4 shadow-sm">

            <form action="{{ route('identitas.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama Peserta</label>
                    <input type="text" name="nama" class="form-control" value="{{ $data->nama }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">NIM / NIS</label>
                    <input type="text" name="nim" class="form-control" value="{{ $data->nim }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Asal Sekolah</label>
                    <input type="text" name="asal_sekolah" class="form-control" value="{{ $data->asal_sekolah }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Mulai PKL</label>
                        <input type="date" name="tanggal_mulai" class="form-control"
                            value="{{ $data->tanggal_mulai }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Selesai PKL</label>
                        <input type="date" name="tanggal_selesai" class="form-control"
                            value="{{ $data->tanggal_selesai }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto Peserta (Opsional)</label>
                    <input type="file" name="foto" class="form-control">

                    <div class="mt-3">
                        @if($data->foto)
                        <p class="fw-bold">Foto Saat Ini:</p>
                        <img src="{{ asset('foto_peserta/' . $data->foto) }}" class="preview-foto">
                        @else
                        <p class="text-muted">Belum ada foto</p>
                        @endif
                    </div>
                </div>

                <div class="text-end">
                    <a href="{{ route('identitas.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Update Data</button>
                </div>

            </form>

        </div>

    </div>

</body>

</html>
