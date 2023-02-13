<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show Login Form
     */
    public function showLogin()
    {
        return view('auth.login');
    }


    /**
     * Authenticate the User
     *
     * @param Request $request
     */
    public function login(Request $request)
    {
        $input = $request->except('_token');

        if (Auth::attempt($input))
        {
            if (Auth::user()->user_type === 1) {
                return redirect()->route('admin.dashboard')->with('success', 'Welcome '.Auth::user()->name);
            }
            return back()->with('error', 'Kindly Login with Active Admin User.');
        }

        return back()->with('error', 'Please Enter Valid Email & Password');
    }


    /**
     * Logout the User
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
