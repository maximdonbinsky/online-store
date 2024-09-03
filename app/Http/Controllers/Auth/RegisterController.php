<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function registration() {
        if(Auth::check()) {
            return redirect(route('orders'));
        }
        return view('auth/register');
    }

    public function save(Request $request) {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if(User::where('email', $validate['email'])->exists()) {
            return redirect(route('user.login'))->withErrors([
                'email' => 'Такой пользователь существует!'
            ]);
        }
        $user = User::create($validate);
        if($user) {
            Auth::login($user);
            return redirect(route('index'));
        }
        else {
            return redirect(route('user.login'))->withErrors([
                'worm_errors' => 'Произошла ошибка при сохранении пользователя'
            ]);
        }
    }
}
