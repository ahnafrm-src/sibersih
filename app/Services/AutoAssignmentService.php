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

        // 1. Cek apakah ada kelas yang SEDANG berlangsung saat ini
        $jadwalAktif = JadwalPelajaran::where('ruangan_id', $ruanganId)
            ->where('hari', $hariIni)
            ->whereTime('jam_mulai', '<=', $jamLapor)
            ->whereTime('jam_selesai', '>=', $jamLapor)
            ->first();

        if ($jadwalAktif) {
            return $jadwalAktif->kelas_id;
        }

        // 2. Jika tidak ada (mungkin jam istirahat/pergantian kelas), 
        // ambil kelas TERAKHIR yang baru saja selesai di ruangan tersebut pada hari itu
        $jadwalTerakhir = JadwalPelajaran::where('ruangan_id', $ruanganId)
            ->where('hari', $hariIni)
            ->whereTime('jam_selesai', '<=', $jamLapor)
            ->orderBy('jam_selesai', 'desc') // Ambil yang paling mendekati jam lapor
            ->first();

        return $jadwalTerakhir ? $jadwalTerakhir->kelas_id : null;
    }
}
