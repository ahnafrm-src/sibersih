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
            'ruangan_id'     => 'required|exists:ruangan,id',
            'foto'           => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'waktu_kejadian' => 'nullable|date',
        ]);

        // Upload foto ke storage (folder storage/app/public/laporan-foto)
        $path = $request->file('foto')->store('laporan-foto', 'public');

        // Gunakan waktu kejadian yang diinputkan user (atau waktu sekarang jika kosong)
        $waktuLapor = $request->filled('waktu_kejadian')
            ? Carbon::parse($request->waktu_kejadian)
            : Carbon::now();

        // Cari otomatis kelas yang menempati ruangan berdasarkan waktu kejadian
        $kelasTerdugaId = $assignmentService->assignKelas($request->ruangan_id, $waktuLapor);

        // Fallback: tidak ketemu jadwal yang cocok
        if (is_null($kelasTerdugaId)) {
            $waktuFormatted = $waktuLapor->locale('id')->translatedFormat('l, d F Y \p\u\k\u\l H:i');
            $ruangan = Ruangan::find($request->ruangan_id);

            return back()
                ->withInput()
                ->withErrors([
                    'waktu_kejadian' => "Tidak ditemukan jadwal untuk {$ruangan->nama_ruangan} pada {$waktuFormatted}. Periksa kembali waktu kejadian, atau hubungi admin jika jadwal belum diinput."
                ]);
        }

        Laporan::create([
            'ruangan_id'       => $request->ruangan_id,
            'foto'             => $path,
            'waktu_lapor'      => $waktuLapor,
            'kelas_terduga_id' => $kelasTerdugaId,
            'nama_pelapor'     => $request->nama_pelapor,
            'kelas_pelapor'    => $request->kelas_pelapor,
            'status'           => 'baru',
        ]);

        // Redirect ke halaman sukses
        return redirect()->route('lapor.sukses');
    }

    // Tampilkan halaman sukses lapor
    public function sukses()
    {
        return view('lapor.sukses');
    }
}
