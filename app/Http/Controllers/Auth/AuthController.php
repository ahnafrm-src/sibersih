<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    //
    public function showLogin(){
        return view('admin.login');
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|'
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();

            return view('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau Password salah'
        ])->onlyInput('email');
    }
}
