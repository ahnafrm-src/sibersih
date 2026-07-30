<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data_kelas = Kelas::with(['jadwalPelajaran', 'laporan', 'skorMingguan'])->get();

        return view('admin.kelas.index', compact('data_kelas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'nama_kelas' => 'required|'
        ]);

        Kelas::create($validated);

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kelas $kelas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kelas $kelas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kelas $kelas)
    {
        //
        $validated = $request->validate([
            'nama_kelas' => 'required|'
        ]);

        $kelas->update($validated);

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kelas $kelas)
    {
        //
        $kelas->delete();

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil dihapus');
    }
}
