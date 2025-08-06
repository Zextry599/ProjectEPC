<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\Models\User;
use Illuminate\Http\Request;

class AuthManageController extends Controller
{
    // Show View Login
    public function viewLogin()
    {
    	$users = User::all()
    	->count();

    	return view('login', compact('users'));
    }

    // Verify Login
    public function verifyLogin(Request $request)
{
    $credentials = $request->only('username', 'password');
    $user = \App\Models\User::where('username', $credentials['username'])->first();

    if ($user) {
        if ($user->status === 'deactive') {
            Session::flash('login_failed', 'Akun Anda telah dinonaktifkan. Silahkan Hubungi Admin!');
            return redirect('/login');
        }

        if (Auth::attempt($credentials)) {
            return redirect('/dashboard');
        }
    }

    Session::flash('login_failed', 'Username atau password salah');
    return redirect('/login');
}


    // Logout Process
    public function logoutProcess()
    {
    	Auth::logout();

    	return redirect('/login');
    }
}