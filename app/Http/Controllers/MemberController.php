<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MenuController;

class MemberController extends Controller
{
    public function List() {
        $menu_list = MenuController::menuList();
        $user_list = DB::select("SELECT u_idx,email,u_name,team FROM admin_user WHERE use_yn = 1");

        return view('contents/member/member',['menu_list'=>$menu_list,'user_list'=>$user_list]);
    }

    //유저 상세 정보
    public function memberInfo(Request $request) {
        session()->get('u_idx');
        $result = 'ok';
        $user_info = DB::select("SELECT u_idx,email,u_name,team FROM admin_user WHERE use_yn = 1 AND u_idx = {$request['u_idx']}");

        if(empty($user_info)) $result = 'fail';
        return response()->json([
            'result' => $result,
            'user_info' => $user_info[0]
        ], 200);
    }
}
