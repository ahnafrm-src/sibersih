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
            'name' => 'required|string|max:255',
            'nip'  => 'required|numeric|unique:users,nip',
        ]);

        User::create([ 
            'name'     => $request->name,
            'nip'      => $request->nip,
            'password' => bcrypt('password123'), // Password default jika diperlukan
            'role'     => 'guru',
        ]);

        return back()->with('success', 'Data guru berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $guru = User::findOrFail($id);
        $guru->delete();

        return back()->with('success', 'Data Guru berhasil dihapus!');
    }
}
