<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    //CODE
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        if ($request->login === 'admin' && $request->password === 'admin') {
            Session::put('is_logged_in', true);
            return redirect('/'); // bosh sahifaga
        }

        return back()->withErrors(['login' => 'Login yoki parol noto‘g‘ri']);
    }

    public function logout()
    {
        Session::forget('is_logged_in');
        return redirect('/login');
    }
}
