<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Logbook;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin account
        User::create([
            'name' => 'Administrator',
            'nim_nis' => 'admin',
            'role' => 'admin',
            'email' => 'admin@logbook.com',
            'password' => Hash::make('admin123'),
        ]);

        // Create sample pembimbing
        $pembimbing = User::create([
            'name' => 'Pembimbing 1',
            'nim_nis' => 'PBM001',
            'role' => 'pembimbing',
            'email' => 'pembimbing1@logbook.com',
            'password' => Hash::make('password'),
        ]);

        // Create sample mahasiswa
        $mahasiswa = User::create([
            'name' => 'Mahasiswa 1',
            'nim_nis' => 'MHS001',
            'role' => 'mahasiswa',
            'email' => 'mahasiswa1@logbook.com',
            'password' => Hash::make('password'),
            'sekolah_kampus' => 'Universitas Example',
            'jurusan' => 'Teknik Informatika',
        ]);

        // Assign pembimbing to mahasiswa
        $mahasiswa->pembimbing()->attach($pembimbing->id);

        // Create sample logbooks untuk mahasiswa
        Logbook::create([
            'user_id' => $mahasiswa->id,
            'tanggal' => now()->subDays(2),
            'kegiatan' => 'Hari pertama PKL, perkenalan dengan staff dan pembimbing lapangan. Diberikan penjelasan mengenai tugas dan tanggung jawab selama PKL.',
            'status' => 'pending',
        ]);

        Logbook::create([
            'user_id' => $mahasiswa->id,
            'tanggal' => now()->subDays(1),
            'kegiatan' => 'Mempelajari sistem administrasi pemerintahan. Membantu input data surat masuk dan keluar menggunakan sistem informasi kepegawaian.',
            'status' => 'pending',
        ]);

        Logbook::create([
            'user_id' => $mahasiswa->id,
            'tanggal' => now(),
            'kegiatan' => 'Membantu mempersiapkan dokumen untuk rapat koordinasi. Belajar tentang prosedur pembuatan laporan kegiatan pemerintahan.',
            'status' => 'pending',
        ]);
    }
}
