<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function login() {
        if(Auth::check()) {
            return redirect(route('index'));
        }
        return view('auth/login');
    }

    public function authorization(Request $request) {
        $formFields = $request->only(['email', 'password']);
        if(Auth::attempt($formFields)) {
            return redirect()->route('index');
        }
        return redirect()->route('user.login');
        
    }

    public function logout() {
        Auth::logout();
        return redirect(route('index'));
    }
}
