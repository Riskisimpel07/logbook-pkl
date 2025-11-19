<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class MahasiswaController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $totalLogbooks = $user->logbooks()->count();
        $logbooksPending = $user->logbooks()->where('status', 'pending')->count();
        $logbooksValidated = $user->logbooks()->where('status', 'validated')->count();

        return view('mahasiswa.dashboard', compact('totalLogbooks', 'logbooksPending', 'logbooksValidated'));
    }

    public function identitas()
    {
        $user = Auth::user();
        return view('mahasiswa.identitas', compact('user'));
    }

    public function updateIdentitas(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'sekolah_kampus' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'sekolah_kampus' => $request->sekolah_kampus,
            'jurusan' => $request->jurusan,
        ];

        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($user->foto) {
                Storage::delete('public/' . $user->foto);
            }

            $path = $request->file('foto')->store('foto_mahasiswa', 'public');
            $data['foto'] = $path;
        }

        $user->update($data);

        return redirect()->route('mahasiswa.identitas')->with('success', 'Identitas berhasil diupdate');
    }

    public function logbooks()
    {
        $user = Auth::user();
        $logbooks = $user->logbooks()->latest()->get();
        return view('mahasiswa.logbooks.index', compact('logbooks'));
    }

    public function createLogbook()
    {
        return view('mahasiswa.logbooks.create');
    }

    public function storeLogbook(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'kegiatan' => 'required|string',
            'foto_kegiatan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'user_id' => Auth::id(),
            'tanggal' => $request->tanggal,
            'kegiatan' => $request->kegiatan,
            'status' => 'pending',
        ];

        if ($request->hasFile('foto_kegiatan')) {
            $path = $request->file('foto_kegiatan')->store('foto_kegiatan', 'public');
            $data['foto_kegiatan'] = $path;
        }

        Logbook::create($data);

        return redirect()->route('mahasiswa.logbooks')->with('success', 'Logbook berhasil ditambahkan');
    }

    public function editLogbook($id)
    {
        $logbook = Logbook::where('user_id', Auth::id())->findOrFail($id);
        return view('mahasiswa.logbooks.edit', compact('logbook'));
    }

    public function updateLogbook(Request $request, $id)
    {
        $logbook = Logbook::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'tanggal' => 'required|date',
            'kegiatan' => 'required|string',
            'foto_kegiatan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'tanggal' => $request->tanggal,
            'kegiatan' => $request->kegiatan,
            'status' => 'pending', // Reset status to pending
            'validated_by' => null,
        ];

        if ($request->hasFile('foto_kegiatan')) {
            // Delete old photo if exists
            if ($logbook->foto_kegiatan) {
                Storage::delete('public/' . $logbook->foto_kegiatan);
            }

            $path = $request->file('foto_kegiatan')->store('foto_kegiatan', 'public');
            $data['foto_kegiatan'] = $path;
        }

        $logbook->update($data);

        return redirect()->route('mahasiswa.logbooks')->with('success', 'Logbook berhasil diupdate');
    }

    public function deleteLogbook($id)
    {
        $logbook = Logbook::where('user_id', Auth::id())->findOrFail($id);

        // Only allow delete if status is pending
        if ($logbook->status === 'validated') {
            return back()->with('error', 'Tidak bisa menghapus logbook yang sudah divalidasi');
        }

        // Delete photo if exists
        if ($logbook->foto_kegiatan) {
            Storage::delete('public/' . $logbook->foto_kegiatan);
        }

        $logbook->delete();

        return redirect()->route('mahasiswa.logbooks')->with('success', 'Logbook berhasil dihapus');
    }

    public function downloadPdf()
    {
        $user = Auth::user();
        $logbooks = $user->logbooks()->orderBy('tanggal')->get();

        $pdf = Pdf::loadView('mahasiswa.logbooks.pdf', compact('user', 'logbooks'));
        return $pdf->download('logbook-' . $user->nim_nis . '.pdf');
    }
}
