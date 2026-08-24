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

        return view('admin.dashboard', compact('ruangan', 'laporanTerbaru'));
    }
}
