<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use Socialite;

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

    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        $user = Socialite::driver($provider)->user();
        \Log::info('user', [$user]);
        \Log::info($user->token);

        return redirect()->away("http://localhost:8000?token=$user->token");
    }

}