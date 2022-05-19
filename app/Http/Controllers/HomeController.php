<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }
    public function hello()
    {
        return view('contents/hello');
    }

    public function group()
    {
        $group_list = DB::table('gecl_admin.group')
            ->select('*')
            ->where('use_yn','=',1)
            ->get();

        return view('contents/group_list', ['group_list'=>$group_list]);
    }

    public function group_list(Request $request)
    {
        $group_list = DB::table('user_group_mapping AS ugm')
            ->join('admin_user AS au','ugm.u_idx','=','au.u_idx')
            ->select('ugm.ug_idx','au.email','au.u_name','au.team')
            ->where('ugm.g_idx','=',$request['idx'])
            ->get();

        return response()->json([
            'result' => $group_list
        ], 200);
    }

    public function group_del(Request $request)
    {
        $result = DB::table('group')->where('g_idx','=',$request->idx)->update(['use_yn' => 0]);
        $result ? $msg = '정상 처리되었습니다.' : $msg = "error 199201";;
        return response()->json([
            'result' => $result,
            'msg' => $msg
        ], 200);
    }

    public function group_list_del(Request $request)
    {
        $result = DB::table('user_group_mapping')->where('ug_idx','=',$request->ug_idx)->delete();

        return response()->json([
            'result' => $result
        ], 200);
    }

    public function group_add_id(Request $request)
    {
        $flag = 'fail';
        $result_data = '';
        $select_chk = DB::table('user_group_mapping')->where([['email','=',$request->id],['g_idx','=',$request->g_idx]])->get();
        if(count($select_chk) == 0) {
            $flag = 'fail';
            $select = DB::table('admin_user')->where('email','=',$request->id)->get();
            if(count($select) > 0 ) {
                $flag = 'ok';
                $msg = '정상 처리되었습니다.';
                DB::table('user_group_mapping')->insert([
                    'u_idx' => $select[0]->u_idx,
                    'email' => $select[0]->email,
                    'g_idx' => $request->g_idx
                ]);
                $result_data = $select;
                $result_data['ug_idx'] = DB::getPdo()->lastInsertId();
            }else{
                $msg = 'error 199202';
            }
        } else {
            $msg = 'error 199212';
        }

        return response()->json([
            'result' => $flag,
            'msg' => $msg,
            'user_data' => $result_data
        ], 200);
    }
}
