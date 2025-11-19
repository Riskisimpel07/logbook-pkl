<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Identitas;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Absensi::with('peserta')
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('absensi.index', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $absensi = Absensi::findOrFail($id);
        $peserta = Identitas::all(); // untuk dropdown jika diperlukan

        return view('absensi.edit', compact('absensi', 'peserta'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'peserta_id' => 'required',
            'tanggal' => 'required|date',
            'jam_masuk' => 'required',
            'jam_pulang' => 'nullable',
            'kegiatan' => 'nullable|string'
        ]);

        $absensi = Absensi::findOrFail($id);

        $absensi->update([
            'peserta_id' => $request->peserta_id,
            'tanggal' => $request->tanggal,
            'jam_masuk' => $request->jam_masuk,
            'jam_pulang' => $request->jam_pulang,
            'kegiatan' => $request->kegiatan
        ]);

        return redirect()->route('absensi.index')->with('success', 'Data berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Absensi::findOrFail($id)->delete();

        return redirect()->route('absensi.index')->with('success', 'Data berhasil dihapus!');
    }
}
