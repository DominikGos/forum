<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'email' => $request->email,
        ]);


        return redirect()->route('login.form')->with('register-success', 'User registration complete');
    }
}
