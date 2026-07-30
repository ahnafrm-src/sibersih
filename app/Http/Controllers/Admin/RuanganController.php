<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RuanganController extends Controller
{
    public function index(): View
    {
        $ruangan = Ruangan::orderBy('nama_ruangan')->paginate(10);

        return view('admin.ruangan.index', compact('ruangan'));
    }

    public function create(): View
    {
        return view('admin.ruangan.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_ruangan' => 'required|string|max:50|unique:ruangan,nama_ruangan',
        ]);

        Ruangan::create($request->only('nama_ruangan'));

        return redirect()
            ->route('admin.ruangan.index')
            ->with('success', 'Ruangan berhasil ditambahkan.');
    }

    public function edit(Ruangan $ruangan): View
    {
        return view('admin.ruangan.edit', compact('ruangan'));
    }

    public function update(Request $request, Ruangan $ruangan): RedirectResponse
    {
        $request->validate([
            'nama_ruangan' => 'required|string|max:50|unique:ruangan,nama_ruangan,' . $ruangan->id,
        ]);

        $ruangan->update($request->only('nama_ruangan'));

        return redirect()
            ->route('admin.ruangan.index')
            ->with('success', 'Ruangan berhasil diperbarui.');
    }

    public function destroy(Ruangan $ruangan): RedirectResponse
    {
        $ruangan->delete();

        return redirect()
            ->route('admin.ruangan.index')
            ->with('success', 'Ruangan berhasil dihapus.');
    }
}