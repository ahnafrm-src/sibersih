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
            'status' => 'required|in:baru,ditindak,disengketakan,selesai',
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
}