<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Ruangan;
use App\Models\Kelas;
use App\Services\AutoAssignmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LaporanController extends Controller
{
        // Tampilkan daftar laporan
    public function index()
    {
        $laporans = Laporan::with(['ruangan', 'kelasTerduga'])
            ->latest('waktu_lapor')
            ->get();

        return view('lapor.index', compact('laporans'));
    }

    
    // Tampilkan form lapor kebersihan
    public function create()
    {
        $ruangans = Ruangan::all();
        $kelases  = Kelas::orderBy('nama_kelas')->get(); 
        return view('lapor.create', compact('ruangans', 'kelases'));
    }

    // Proses simpan laporan + jalankan auto assignment
    public function store(Request $request, AutoAssignmentService $assignmentService)
    {
        $request->validate([
            'ruangan_id' => 'required|exists:ruangan,id',
            'foto'       => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload foto ke storage (folder storage/app/public/laporan-foto)
        $path = $request->file('foto')->store('laporan-foto', 'public');
        $waktuLapor = Carbon::now();

        // Cari otomatis kelas yang menempati ruangan saat jam ini
        $kelasTerdugaId = $assignmentService->assignKelas($request->ruangan_id, $waktuLapor);

        Laporan::create([
            'ruangan_id'       => $request->ruangan_id,
            'foto'             => $path,
            'waktu_lapor'      => $waktuLapor,
            'kelas_terduga_id' => $kelasTerdugaId,
            'nama_pelapor'     => $request->nama_pelapor,   // ganti dari pelapor_id
            'kelas_pelapor'    => $request->kelas_pelapor,
            'status'           => 'baru',
        ]);

        return back()->with('success', 'Laporan berhasil terkirim! Terima kasih telah menjaga kebersihan.');
    }
}