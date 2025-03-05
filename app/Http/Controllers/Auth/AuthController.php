<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SigninRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('Auth.signin');
    }

    public function signIn(SigninRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if(Auth::attempt($credentials)){
            return redirect()->route('dashboard.index')->with('success', "Login successfull");
        }else{
            return redirect()->route('auth.index')->with('error', "Invalid username or password");
        }
    }
}
