<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;

class AuthController extends Controller
{

    public function store(Request $request)
    {
        $authenticated = Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);

        if ($authenticated) {
            $user = User::whereEmail($request->email)->first();
            $token = $user->createToken($request->email)->accessToken;
            return response()->json(['token' => $token]);
        }
    }

}