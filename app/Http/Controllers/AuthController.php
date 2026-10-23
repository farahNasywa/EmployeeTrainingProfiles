<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|max:20',
        ]);
        if(Auth::attempt($request->only('email', 'password'), $request->remember)){
            if(Auth::user()->role == 'user') return redirect('/user/dashboard');
            return redirect('/admin/dashboard');
        }
        return back()->with('failed', 'Email atau Password salah');
    }

    public function logout()
    {
        Auth::logout(Auth::user());
        return redirect('/');
    }
}
