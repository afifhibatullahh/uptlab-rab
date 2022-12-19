<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Session;

class Auth extends Controller
{
    //
    public function index()
    {
        if (FacadesAuth::check()) return \redirect('/');

        return view('auth.login');
    }

    public function login(Request $request)
    {
        Session::flash('email', $request->email);
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);

        $dataLogin = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (FacadesAuth::attempt($dataLogin)) {
            return \redirect('/')->with('success', 'Selamat Datang');
        } else {
            return \redirect('login')->withErrors('Email dan password yang dimasukkan tidak valid');
        }
    }

    public function logout()
    {
        FacadesAuth::logout();
        return \redirect('login')->with('success', 'Berhasil logout');
    }
}
