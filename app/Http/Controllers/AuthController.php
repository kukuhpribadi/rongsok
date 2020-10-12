<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        if (auth()->check()) {
            return redirect(route('getDataBulanIni'));
        }
        return view('auth.login');
    }

    public function postlogin(Request $request)
    {
        if (Auth::attempt($request->only('username', 'password'))) {
            return redirect(route('getDataBulanIni'));
        }
        return redirect()->back();
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('login'));
    }
}
