<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create() {
        Auth::guard('web')->logout();
        return inertia('Auth/Login');
    }

    public function store(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);


        $remember = $request->input('remember', false); 

        if (Auth::guard('web')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return response()->json(['redirect_to' => '/dashboard']);
        }

        return response()->json(['password' => 'Incorrect password or email'], 422);

    }

    public function destroy(Request $request) {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login.create');
    }
}
