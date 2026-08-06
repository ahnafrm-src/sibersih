<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sanggahan;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SanggahanController extends Controller
{
    /**
     * Menampilkan daftar sanggahan di dashboard Admin/Guru Piket
     */
    public function index()
    {
        // Load relasi laporan, ruangan, dan kelas terduga
        $sanggahan = Sanggahan::with(['laporan.ruangan', 'laporan.kelasTerduga', 'verifikator'])
            ->latest()
            ->paginate(10);

        return view('admin.sanggahan.index', compact('sanggahan'));
    }

    /**
     * Menyimpan sanggahan baru yang diajukan oleh siswa/perwakilan kelas
     */
    public function store(Request $request)
    {
        $request->validate([
            'laporan_id'    => 'required|exists:laporan,id',
            'diajukan_oleh' => 'required|string|max:100',
            'alasan'        => 'required|string|min:10',
        ]);

        DB::transaction(function () use ($request) {
            // Buat record sanggahan
            Sanggahan::create([
                'laporan_id'        => $request->laporan_id,
                'diajukan_oleh'     => $request->diajukan_oleh,
                'alasan'            => $request->alasan,
                'status_verifikasi' => 'menunggu',
            ]);

            // Otomatis ubah status laporan terkait menjadi 'disengketakan'
            $laporan = Laporan::findOrFail($request->laporan_id);
            $laporan->update(['status' => 'disengketakan']);
        });

        return back()->with('success', 'Sanggahan berhasil dikirim dan akan ditinjau!');
    }

    /**
     * Verifikasi sanggahan oleh Admin/Guru Piket (Terima / Tolak)
     */
    public function verifikasi(Request $request, Sanggahan $sanggahan)
    {
        $request->validate([
            'status_verifikasi'  => 'required|in:diterima,ditolak',
            'catatan_verifikasi' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $sanggahan) {
            $sanggahan->update([
                'status_verifikasi'  => $request->status_verifikasi,
                'diverifikasi_oleh'  => Auth::id(),
                'catatan_verifikasi' => $request->catatan_verifikasi,
            ]);

            // Jika sanggahan DITERIMA, status laporan berubah jadi 'selesai' / poin batal dipotong
            // Jika DITOLAK, status laporan kembali ke 'ditindak' / poin tetap dipotong
            $statusLaporan = ($request->status_verifikasi === 'diterima') ? 'selesai' : 'ditindak';
            $sanggahan->laporan->update(['status' => $statusLaporan]);
        });

        return back()->with('success', 'Verifikasi sanggahan berhasil diperbarui.');
    }
}