<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>LOGBOOK PRAKTIK KERJA LAPANGAN (PKL) SETDA KOTA CIREBON - {{ $user->name ?? $mahasiswa->name }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { display: flex; align-items: center; margin-bottom: 30px; border-bottom: 3px solid #333; padding-bottom: 10px; }
        .header-logo {
            width: 70px;
            height: 70px;
            margin-right: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .header-logo img {
            max-width: 60px;
            max-height: 60px;
        }
        .header-title {
            flex: 1;
            text-align: left;
        }
        .header-title h2 { margin: 5px 0; font-size: 18px; }
        .header-title h3 { margin: 5px 0; font-size: 15px; }
        .identitas { margin-bottom: 20px; }
        .identitas table { width: 100%; }
        .identitas td { padding: 5px; }
        .foto { text-align: center; margin: 10px 0; }
        .foto img { max-width: 150px; max-height: 150px; }
        table.logbook { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table.logbook th, table.logbook td { border: 1px solid #333; padding: 8px; vertical-align: middle; }
        table.logbook th { background: #f0f0f0; font-weight: bold; }
        table.logbook img { max-width: 80px; max-height: 80px; display: block; margin: 0 auto; }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-logo">
            <img src="{{ public_path('storage/berkas/lambang_kota_cirebon.png') }}" alt="Logo Kota Cirebon">
        </div>
        <div class="header-title">
            <h2>LOGBOOK PRAKTIK KERJA LAPANGAN (PKL)</h2>
            <h3>SETDA KOTA CIREBON</h3>
        </div>
    </div>

    <div class="identitas">
        <table>
            <tr>
                <td width="150"><strong>Nama</strong></td>
                <td width="10">:</td>
                <td>{{ $user->name ?? $mahasiswa->name }}</td>
                <td rowspan="4" width="200" style="text-align: center;">
                    @if(isset($user) && $user->foto)
                    <img src="{{ public_path('storage/' . $user->foto) }}" style="max-width: 120px; max-height: 150px;">
                    @elseif(isset($mahasiswa) && $mahasiswa->foto)
                    <img src="{{ public_path('storage/' . $mahasiswa->foto) }}" style="max-width: 120px; max-height: 150px;">
                    @endif
                </td>
            </tr>
            <tr>
                <td><strong>NIM/NIS</strong></td>
                <td>:</td>
                <td>{{ $user->nim_nis ?? $mahasiswa->nim_nis }}</td>
            </tr>
            <tr>
                <td><strong>Sekolah/Kampus</strong></td>
                <td>:</td>
                <td>{{ $user->sekolah_kampus ?? $mahasiswa->sekolah_kampus ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Jurusan</strong></td>
                <td>:</td>
                <td>{{ $user->jurusan ?? $mahasiswa->jurusan ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <table class="logbook">
        <thead>
            <tr>
                <th width="30">No</th>
                <th width="80">Tanggal</th>
                <th>Kegiatan</th>
                <th width="100">Foto Kegiatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logbooks as $logbook)
            <tr>
                <td style="text-align: center;">{{ $loop->iteration }}</td>
                <td style="text-align: center;">{{ $logbook->tanggal->format('d/m/Y') }}</td>
                <td>{{ $logbook->kegiatan }}</td>
                <td style="text-align: center;">
                    @if($logbook->foto_kegiatan)
                    <img src="{{ public_path('storage/' . $logbook->foto_kegiatan) }}" alt="Foto Kegiatan">
                    @else
                    <span style="color: #999;">Tidak ada foto</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center;">Belum ada data logbook</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 30px;">
        <p><strong>Dicetak pada:</strong> {{ date('d/m/Y H:i') }}</p>
    </div>
</body>
</html>
