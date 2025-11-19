<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Identitas;

class IdentitasController extends Controller
{
    // =====================
    // TAMPILKAN DAFTAR
    // =====================
    public function index()
    {
        $data = Identitas::orderBy('created_at', 'desc')->get();
        return view('identitas.index', compact('data'));
    }

    // =====================
    // HALAMAN TAMBAH
    // =====================
    public function create()
    {
        return view('identitas.create');
    }

    // =====================
    // SIMPAN DATA BARU
    // =====================
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nim' => 'required|unique:identitas',
            'asal_sekolah' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
            'foto' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $namaFile = null;

        if ($request->hasFile('foto')) {
            $namaFile = time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('foto_peserta'), $namaFile);
        }

        Identitas::create([
            'nama' => $request->nama,
            'nim' => $request->nim,
            'asal_sekolah' => $request->asal_sekolah,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'foto' => $namaFile
        ]);

        return redirect()->route('identitas.index')->with('success', 'Peserta berhasil ditambahkan!');
    }

    // =====================
    // HALAMAN EDIT
    // =====================
    public function edit($id)
    {
        $data = Identitas::findOrFail($id);
        return view('identitas.edit', compact('data'));
    }

    // =====================
    // UPDATE DATA
    // =====================
    public function update(Request $request, $id)
    {
        $data = Identitas::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'nim' => 'required|unique:identitas,nim,' . $id,
            'asal_sekolah' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
            'foto' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $namaFile = $data->foto;

        if ($request->hasFile('foto')) {
            // hapus foto lama jika ada
            if ($namaFile && file_exists(public_path('foto_peserta/' . $namaFile))) {
                unlink(public_path('foto_peserta/' . $namaFile));
            }

            $namaFile = time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('foto_peserta'), $namaFile);
        }

        $data->update([
            'nama' => $request->nama,
            'nim' => $request->nim,
            'asal_sekolah' => $request->asal_sekolah,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'foto' => $namaFile
        ]);

        return redirect()->route('identitas.index')->with('success', 'Data peserta berhasil diperbarui!');
    }

    // =====================
    // HAPUS DATA
    // =====================
    public function destroy($id)
    {
        $data = Identitas::findOrFail($id);

        // hapus foto jika ada
        if ($data->foto && file_exists(public_path('foto_peserta/' . $data->foto))) {
            unlink(public_path('foto_peserta/' . $data->foto));
        }

        $data->delete();

        return redirect()->route('identitas.index')->with('success', 'Peserta berhasil dihapus!');
    }
}
