<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login($request) {
        $credentials = $request->validate([
            'email' => ['required'],
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
        //팀 세션 저장
        $user_data = DB::select("SELECT * FROM gecl_admin.admin_user WHERE email = '{$request['email']}'");
        session(['team' => $user_data[0]->team]);
        session(['u_idx' => $user_data[0]->u_idx]);

        return response()->json([
            'result' => 'ok',
            'message' => '로그인에 성공 하였습니다.',
        ], 200);
    }

    public function logout(Request $request)
    {
        Auth::logout();
//        $request->session()->invalfidate();
//        $request->session()->regenerateToken();

        return redirect('/');
    }
}
