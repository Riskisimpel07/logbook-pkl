<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Absensi Harian PKL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f2f4f8;
            animation: fadeIn .8s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .card {
            border-radius: 12px;
        }

        .btn-aksi {
            padding: 4px 10px;
            font-size: 13px;
        }
    </style>
</head>

<body>

    <div class="container py-4">

        <h2 class="text-center fw-bold mb-4">Absensi Harian PKL</h2>

        <div class="text-end mb-3">
            <a href="{{ route('absensi.create') }}" class="btn btn-primary">
                + Tambah Absensi
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card p-3 shadow-sm">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Peserta</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Jam Pulang</th>
                        <th>Kegiatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($data as $i => $row)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $row->peserta->nama ?? '-' }}</td>
                            <td>{{ $row->tanggal }}</td>
                            <td>{{ $row->jam_masuk }}</td>
                            <td>{{ $row->jam_pulang ?? '-' }}</td>
                            <td>{{ $row->kegiatan }}</td>
                            <td width="150">
                                <a href="{{ route('absensi.edit', $row->id) }}" class="btn btn-warning btn-sm btn-aksi">
                                    Edit
                                </a>

                                <form action="{{ route('absensi.destroy', $row->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('Hapus data ini?')" 
                                            class="btn btn-danger btn-sm btn-aksi">
                                            Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                Belum ada data absensi
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
</body>

</html>
