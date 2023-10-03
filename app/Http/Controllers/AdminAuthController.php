<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function viewLogin()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        //dd($credentials);
        if (Auth::guard('admin')->attempt($credentials)) {

            return redirect()->route('admin.dashboard');
        }

        return redirect()->back()->withErrors(['login' => 'Thông tin đăng nhập không đúng.'])->withInput();
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
