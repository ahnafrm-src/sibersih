<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Ruangan;
use App\Services\AutoAssignmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LaporanController extends Controller
{
    // Tampilkan form lapor kebersihan
    public function create()
    {
        $ruangans = Ruangan::all();
        return view('lapor.create', compact('ruangans'));
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
            'pelapor_id'       => Auth::id() ?? 1,
            'ruangan_id'       => $request->ruangan_id,
            'foto'             => $path,
            'waktu_lapor'      => $waktuLapor,
            'kelas_terduga_id' => $kelasTerdugaId,
            'status'           => 'baru',
        ]);

        return back()->with('success', 'Laporan berhasil terkirim! Terima kasih telah menjaga kebersihan.');
    }
}