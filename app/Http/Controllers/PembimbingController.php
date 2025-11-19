<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Logbook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PembimbingController extends Controller
{
    public function dashboard()
    {
        $pembimbing = Auth::user();
        $mahasiswaCount = $pembimbing->mahasiswaBimbingan()->count();
        $logbooksPending = Logbook::whereHas('user.pembimbing', function($query) use ($pembimbing) {
            $query->where('users.id', $pembimbing->id);
        })->where('status', 'pending')->count();

        return view('pembimbing.dashboard', compact('mahasiswaCount', 'logbooksPending'));
    }

    public function mahasiswaList()
    {
        $pembimbing = Auth::user();
        $mahasiswas = $pembimbing->mahasiswaBimbingan()->get();
        return view('pembimbing.mahasiswa', compact('mahasiswas'));
    }

    public function mahasiswaLogbooks($mahasiswaId)
    {
        $pembimbing = Auth::user();
        $mahasiswa = User::findOrFail($mahasiswaId);

        // Check if this mahasiswa is under this pembimbing
        if (!$mahasiswa->pembimbing->contains($pembimbing->id)) {
            abort(403, 'Unauthorized');
        }

        $logbooks = $mahasiswa->logbooks()->orderBy('tanggal', 'desc')->get();
        return view('pembimbing.logbooks', compact('mahasiswa', 'logbooks'));
    }

    public function validateLogbook($id)
    {
        $logbook = Logbook::findOrFail($id);
        $pembimbing = Auth::user();

        // Check if this logbook belongs to mahasiswa under this pembimbing
        if (!$logbook->user->pembimbing->contains($pembimbing->id)) {
            abort(403, 'Unauthorized');
        }

        $logbook->update([
            'status' => 'validated',
            'validated_by' => $pembimbing->id,
        ]);

        return back()->with('success', 'Logbook berhasil divalidasi');
    }

    public function downloadPdf($mahasiswaId)
    {
        $pembimbing = Auth::user();
        $mahasiswa = User::findOrFail($mahasiswaId);

        // Check if this mahasiswa is under this pembimbing
        if (!$mahasiswa->pembimbing->contains($pembimbing->id)) {
            abort(403, 'Unauthorized');
        }

        $logbooks = $mahasiswa->logbooks()->orderBy('tanggal')->get();

        $pdf = Pdf::loadView('mahasiswa.logbooks.pdf', compact('mahasiswa', 'logbooks'))
                  ->setPaper('a4', 'portrait');
        
        return $pdf->download('logbook-' . $mahasiswa->nim_nis . '.pdf');
    }
}
