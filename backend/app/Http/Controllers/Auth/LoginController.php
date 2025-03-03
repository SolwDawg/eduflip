<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\LoginAction;
use App\Data\Auth\LoginData;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function store(LoginData $data)
    {
        $token = LoginAction::run($data);

        $cookie = cookie(
            name: config('site.cookie_name'),
            value: $token,
            minutes: time() + 60 * 60 * 24 * 60,
        );

        return response()->json([
            'token' => $token,
            'token_type' => 'Bearer',
        ])->cookie($cookie);
    }

    public function destroy(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response(null, 204)->withCookie(config('site.cookie_name'));
        // return response(null, 204)->withCookie(config('site.cookie_name'), '', 0, '/', null, false, true);
    }
}
