<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Absensi Harian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #eef2f7;
            animation: fadeIn 0.7s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .card {
            border-radius: 12px;
        }

        .btn {
            border-radius: 8px;
        }
    </style>
</head>

<body>

    <div class="container py-4">

        <h2 class="text-center fw-bold mb-4">Tambah Absensi Harian</h2>

        <div class="card shadow-sm p-4">

            <form action="{{ route('absensi.store') }}" method="POST">
                @csrf

                <!-- Peserta -->
                <div class="mb-3">
                    <label class="form-label">Nama Peserta</label>
                    <select name="peserta_id" class="form-select" required>
                        <option value="">-- Pilih Peserta --</option>
                        @foreach($peserta as $p)
                            <option value="{{ $p->id }}">{{ $p->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tanggal -->
                <div class="mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" required>
                </div>

                <!-- Jam Masuk -->
                <div class="mb-3">
                    <label class="form-label">Jam Masuk</label>
                    <input type="time" name="jam_masuk" class="form-control" required>
                </div>

                <!-- Jam Pulang -->
                <div class="mb-3">
                    <label class="form-label">Jam Pulang</label>
                    <input type="time" name="jam_pulang" class="form-control">
                </div>

                <!-- Kegiatan -->
                <div class="mb-3">
                    <label class="form-label">Kegiatan Hari Ini</label>
                    <textarea name="kegiatan" class="form-control" rows="4" placeholder="Tuliskan kegiatan hari ini..." required></textarea>
                </div>

                <div class="text-end">
                    <a href="{{ route('absensi.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>

            </form>
        </div>
    </div>

</body>

</html>
