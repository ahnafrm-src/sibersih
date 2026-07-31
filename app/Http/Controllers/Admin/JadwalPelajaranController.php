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
    public function index(Request $request)
    {
        //
        $query = JadwalPelajaran::with(['Kelas', 'Ruangan']);

        if($request->filled('kelas_id')){
            $query->whereHas('Kelas', function ($query) use ($request){
                return $query->where('id', $request->kelas_id);
            });
        }

        $listKelas = Kelas::all();
        $jadwalPelajaran = $query->get();

        return view('admin.jadwal-pelajaran.index', compact('jadwalPelajaran', 'listKelas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $listKelas = Kelas::all();
        $listRuangan = Ruangan::all();

        return view('admin.jadwal-pelajaran.create', compact('listKelas', 'listRuangan'));
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
    public function show(JadwalPelajaran $jadwalPelajaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JadwalPelajaran $jadwalPelajaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JadwalPelajaran $jadwalPelajaran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JadwalPelajaran $jadwalPelajaran)
    {
        //
    }
}
