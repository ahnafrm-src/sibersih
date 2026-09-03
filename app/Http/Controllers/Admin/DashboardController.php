<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ruangan;
use App\Models\Laporan;
use App\Models\JadwalPelajaran;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $ruangan = Ruangan::with('laporanTerakhir.kelasTerduga')->get();

        $laporanTerbaru = Laporan::with(['ruangan', 'kelasTerduga'])
            ->latest('waktu_lapor')
            ->take(5)
            ->get();

        // Top 5 kelas paling kotor (paling banyak dapat laporan)
        $kelasTermalas = Laporan::selectRaw('kelas_terduga_id, COUNT(*) as total')
            ->whereNotNull('kelas_terduga_id')
            ->groupBy('kelas_terduga_id')
            ->orderByDesc('total')
            ->take(5)
            ->with('kelasTerduga')
            ->get();

        // Top 5 pelapor paling rajin
        $pelaporRajin = Laporan::selectRaw('nama_pelapor, kelas_pelapor, COUNT(*) as total')
            ->groupBy('nama_pelapor', 'kelas_pelapor')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'ruangan',
            'laporanTerbaru',
            'kelasTermalas',
            'pelaporRajin'
        ));
    }
}
