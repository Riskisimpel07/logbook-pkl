<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar Identitas Peserta PKL</title>
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

        .foto {
            width: 60px;
            height: 60px;
            border-radius: 6px;
            object-fit: cover;
        }
    </style>

</head>

<body>
    <div class="container py-4">

        <h2 class="mb-4 text-center fw-bold">Daftar Peserta PKL</h2>

        <!-- Tombol tambah -->
        <div class="text-end mb-3">
            <a href="{{ route('identitas.create') }}" class="btn btn-primary">
                + Tambah Peserta
            </a>
        </div>

        <!-- Jika ada pesan sukses -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card p-3 shadow-sm">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>NIM / NIS</th>
                        <th>Asal Sekolah</th>
                        <th>Tanggal PKL</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($data as $i => $row)
                        <tr>
                            <td>{{ $i + 1 }}</td>

                            <td>
                                @if($row->foto)
                                    <img src="{{ asset('foto_peserta/' . $row->foto) }}" class="foto">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td>{{ $row->nama }}</td>
                            <td>{{ $row->nim }}</td>
                            <td>{{ $row->asal_sekolah }}</td>
                            <td>{{ $row->tanggal_mulai }} s/d {{ $row->tanggal_selesai }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                Belum ada peserta PKL
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</body>

</html>
