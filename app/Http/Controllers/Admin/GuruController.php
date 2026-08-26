<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GuruController extends Controller
{
    public function index()
    {
        // Ambil hanya user yang memiliki role 'guru'
        $gurus = User::where('role', 'guru')->latest()->get();
        return view('admin.guru.index', compact('gurus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        // Simpan data guru dengan password acak otomatis di belakang layar
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make(Str::random(16)), // Password otomatis terisi agar database aman
            'role'     => 'guru',
        ]);

        return back()->with('success', 'Data Guru berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $guru = User::findOrFail($id);
        $guru->delete();

        return back()->with('success', 'Data Guru berhasil dihapus!');
    }
}