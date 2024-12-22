<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    //@desc Show login form
    //@route GET /login
    public function login():View
    {
        return view('auth.login');
    }

    //@desc Authenticate user
    //@route POST /login
    public function authenticate(Request $request):RedirectResponse
    {
        $credentials = $request->validate([
            'username' => 'required|max:255',
            'password' => 'required|min:6'
        ]);

        //Attempt to authenticate
        if(Auth::attempt($credentials)){
            // Regenerate the session to prevent fixation attacks
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'))->with('success', 'You are logged in');
        }
        //If auth fails, redirect back with errors
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.'
        ])->onlyInput('username');
    }

    //@desc Logout user
    //@route POST /logout
    public function logout(Request $request):RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken(); //regenerate CSRF token

        return redirect()->route('login')->with('success', 'You are logged out');
    }
}
