<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Menampilkan daftar semua laporan di dashboard admin
     */
    public function index()
    {
        $laporan = Laporan::with(['ruangan', 'kelasTerduga', 'pelapor'])
            ->latest()
            ->paginate(10);

        return view('admin.laporan.index', compact('laporan'));
    }

    /**
     * Mengubah status laporan
     */
    public function updateStatus(Request $request, Laporan $laporan)
    {
        $request->validate([
            'status' => 'required|in:baru,ditindak,selesai',
        ]);

        $laporan->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Status laporan berhasil diperbarui!');
    }

    /**
     * Hapus laporan jika perlu
     */
    public function destroy(Laporan $laporan)
    {
        $laporan->delete();
        return back()->with('success', 'Laporan berhasil dihapus.');
    }

    /**
     * Menampilkan detail laporan
     */
    public function show(Laporan $laporan)
    {
        $laporan->load(['ruangan', 'kelasTerduga', 'pelapor']);
        $kelas = \App\Models\Kelas::orderBy('nama_kelas')->get();

        return view('admin.laporan.show', compact('laporan', 'kelas'));
    }

    /**
     * Koreksi kelas terduga secara manual oleh admin
     */
    public function koreksiKelas(Request $request, Laporan $laporan)
    {
        $request->validate([
            'kelas_terduga_id' => 'required|exists:kelas,id',
            'catatan_koreksi'  => 'required|string|min:5',
        ]);

        $laporan->update([
            'kelas_terduga_id' => $request->kelas_terduga_id,
            'catatan_koreksi'  => $request->catatan_koreksi,
        ]);

        return back()->with('success', 'Kelas terduga berhasil dikoreksi.');
    }
}
