<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    public function viewLogin()
    {
        return view('frontend.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        //dd($credentials);
        if (Auth::guard('web')->attempt($credentials)) {
            cart()->moveCartToDatabase();
            return redirect()->route('index');
        }

        return redirect()->back()->withErrors(['login' => 'Thông tin đăng nhập không đúng.'])->withInput();
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('index');
    }
}
