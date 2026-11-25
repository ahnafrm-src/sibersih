<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ruangan;
use App\Models\Laporan;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        //
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

        return response()->json([
            "ruangan" => $ruangan,
            "laporan_terbaru" => $laporanTerbaru,
            "kelas_termalasa" => $kelasTermalas,
            "pelapor_rajin" => $pelaporRajin
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
