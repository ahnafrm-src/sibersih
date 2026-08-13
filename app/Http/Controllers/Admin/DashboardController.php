<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ruangan;
use App\Models\JadwalPelajaran;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $ruangan = Ruangan::with('laporanTerakhir.kelasTerduga')->get();

        return view('admin.dashboard', compact('ruangan'));
    }
}
