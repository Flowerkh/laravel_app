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

    public function group_del($idx)
    {
        DB::table('group')->where('g_idx','=',$idx)->update(['use_yn' => 0]);

        return redirect('/group');
    }

}
