<?php

namespace App\Services;

use App\Models\JadwalPelajaran;
use Carbon\Carbon;

class AutoAssignmentService
{
    /**
     * Cari kelas yang menempati ruangan berdasarkan waktu laporan.
     */
    public function assignKelas(int $ruanganId, ?Carbon $waktuLapor = null): ?int
    {
        $waktu = $waktuLapor ?? Carbon::now();

        // Konversi nama hari dari Carbon ke Bahasa Indonesia
        $hariMap = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
        ];

        $hariIni = $hariMap[$waktu->format('l')] ?? null;

        if (!$hariIni) {
            return null; // Hari Minggu/libur
        }

        $jamLapor = $waktu->format('H:i:s');

        // Cari jadwal yang sedang/pernah berlangsung di ruangan tersebut
        $jadwal = JadwalPelajaran::where('ruangan_id', $ruanganId)
            ->where('hari', $hariIni)
            ->whereTime('jam_mulai', '<=', $jamLapor)
            ->whereTime('jam_selesai', '>=', $jamLapor)
            ->first();

        return $jadwal ? $jadwal->kelas_id : null;
    }
}
