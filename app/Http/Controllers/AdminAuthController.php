<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function viewlogin()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request){
        $credential = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        $user = Auth::guard('admin')->attempt($credential);

        if($user){
            return redirect()->route('products.index');
        }

        return redirect()->back()->withErrors(['login' => 'Login failed'])->withInput();
    }
}
