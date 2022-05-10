<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login($request) {

        $credentials = $request->validate([
            'id' => ['required'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials)) return false;

        return true;
    }

    public function loginAdmin(Request $request) {
        if (!$this->login($request)) {
            return response()->json([
                'result' => 'fail',
                'message' => '로그인에 실패 하였습니다.'
            ], 200);
        }

        return response()->json([
            'result' => 'ok',
            'return_url'=> url()->previous(),
        ], 200);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
