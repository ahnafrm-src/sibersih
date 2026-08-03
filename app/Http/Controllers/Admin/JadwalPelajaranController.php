<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class JadwalPelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelasByTingkat = Kelas::withCount('jadwalPelajaran')
            ->orderBy('nama_kelas')
            ->get()
            ->groupBy('tingkat'); // [10 => [...], 11 => [...], 12 => [...]]

        return view('admin.jadwal-pelajaran.index', compact('kelasByTingkat'));
    }

    // Detail jadwal satu kelas — dikelompokkan per hari
    public function show(Kelas $kelas)
    {
        $jadwalByHari = JadwalPelajaran::with('ruangan')
            ->where('kelas_id', $kelas->id)
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('hari');

        $listRuangan = Ruangan::orderBy('nama_ruangan')->get();
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        return view('admin.jadwal-pelajaran.show', compact('kelas', 'jadwalByHari', 'listRuangan', 'hariList'));
    }

    // Simpan slot baru — terikat ke kelas tertentu
    public function store(Request $request, Kelas $kelas)
    {
        $request->validate([
            'ruangan_id'  => 'required|exists:ruangan,id',
            'hari'        => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai'   => 'required|date_format:H:i|after_or_equal:06:45|before_or_equal:15:00',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai|before_or_equal:15:00',
        ]);

        JadwalPelajaran::create([
            'kelas_id'    => $kelas->id,
            'ruangan_id'  => $request->ruangan_id,
            'hari'        => $request->hari,
            'jam_mulai'   => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        return back()->with('success', 'Slot jadwal berhasil ditambahkan.');
    }

    // Hapus satu slot jadwal
    public function destroy(Kelas $kelas, JadwalPelajaran $jadwalPelajaran)
    {
        $jadwalPelajaran->delete();

        return back()->with('success', 'Slot jadwal berhasil dihapus.');
    }
}
