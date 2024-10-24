<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OwnerLoginController extends Controller
{
    public function login(Request $request)
    {
        // Validate the form data
        $request->validate([
            'id_user' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = [
            filter_var($request->input('id_user'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username' => $request->input('id_user'),
            'password' => $request->input('password'),
        ];

        if (Auth::attempt($credentials)) {
            // Authentication passed, redirect to owner dashboard
            return redirect()->route('owner.dashboard');
        }

        // Authentication failed
        return back()->withErrors([
            'id_user' => 'The provided credentials do not match our records.',
        ]);
    }

    public function dashboard()
    {
        return view('dashboardOwner');
    }
}
