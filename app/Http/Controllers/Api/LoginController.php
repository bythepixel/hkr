<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if(!Auth::validate($credentials)) {
            throw new AuthenticationException();
        }

        $user = User::where('email', $request->get('email'))->firstOrFail();
        $user->rollApiKey();

        return response()->json($user);
    }

    public function logout()
    {
        $user = Auth::user();

        if($user) {
            $user->api_token = null;
            $user->save();
        }

        return response()->json(['success' => true]);
    }
}
