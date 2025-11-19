<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Peserta PKL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fa;
            animation: fadeIn 0.8s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .card {
            border-radius: 14px;
            animation: slideIn 0.6s ease-in-out;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .preview-img {
            width: 120px;
            height: 120px;
            border-radius: 10px;
            object-fit: cover;
            display: none;
        }
    </style>
</head>

<body>

    <div class="container py-4">

        <h2 class="mb-4 text-center fw-bold">Tambah Peserta PKL</h2>

        <div class="card shadow p-4">

            <form action="{{ route('identitas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Nama Peserta</label>
                    <div class="col-sm-9">
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">NIM / NIS</label>
                    <div class="col-sm-9">
                        <input type="text" name="nim" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Asal Sekolah</label>
                    <div class="col-sm-9">
                        <input type="text" name="asal_sekolah" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Tanggal Mulai</label>
                    <div class="col-sm-9">
                        <input type="date" name="tanggal_mulai" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-4">
                    <label class="col-sm-3 col-form-label">Tanggal Selesai</label>
                    <div class="col-sm-9">
                        <input type="date" name="tanggal_selesai" class="form-control" required>
                    </div>
                </div>

                <!-- Upload Foto -->
                <div class="row mb-4">
                    <label class="col-sm-3 col-form-label">Foto Peserta</label>
                    <div class="col-sm-9">
                        <input type="file" name="foto" class="form-control" accept="image/*" onchange="previewFoto(this)">
                        <img id="preview" class="preview-img mt-3">
                    </div>
                </div>

                <div class="text-end">
                    <a href="{{ route('identitas.index') }}" class="btn btn-secondary">Kembali</a>
                    <button class="btn btn-primary">Simpan</button>
                </div>

            </form>
        </div>

    </div>

    <script>
        function previewFoto(input) {
            const preview = document.getElementById('preview');
            const file = input.files[0];

            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
            }
        }
    </script>

</body>

</html>
