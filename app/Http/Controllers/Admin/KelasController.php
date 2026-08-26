<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data kelas beserta wali kelas dan relasi pendukung lainnya
        $data_kelas = Kelas::with(['waliKelas', 'jadwalPelajaran', 'laporan', 'skorMingguan'])->get();

        // Ambil data guru yang belum ditugaskan sebagai Wali Kelas di kelas mana pun
        $gurus = User::where('role', 'guru')
                     ->whereDoesntHave('kelasWali')
                     ->get();

        return view('admin.kelas.index', compact('data_kelas', 'gurus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kelas'    => 'required|string|max:255',
            'wali_kelas_id' => 'nullable|exists:users,id|unique:kelas,wali_kelas_id',
        ], [
            'wali_kelas_id.unique' => 'Guru ini sudah menjadi Wali Kelas di kelas lain!'
        ]);

        Kelas::create($validated);

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil ditambahkan');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kelas $kelas)
    {
        $validated = $request->validate([
            'nama_kelas'    => 'required|string|max:255',
            'wali_kelas_id' => 'nullable|exists:users,id|unique:kelas,wali_kelas_id,' . $kelas->id,
        ], [
            'wali_kelas_id.unique' => 'Guru ini sudah menjadi Wali Kelas di kelas lain!'
        ]);

        $kelas->update($validated);

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kelas $kelas)
    {
        $kelas->delete();

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil dihapus');
    }
}