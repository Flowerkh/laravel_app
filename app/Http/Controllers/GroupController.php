<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
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

    public function group_auth()
    {
        $tr = array();
        $tr_html = "";
        $menu_list = DB::table('menu AS m')
            ->join('sub_menu AS sm','m.m_idx','=','sm.m_idx')
            ->select('sm.m_idx','sm.s_idx','m.title as m_title','sm.title as s_title')
            ->where([['m.use_yn','=','1'],['sm.use_yn','=','1']])
            ->get();

        foreach ($menu_list as $k => $v) {
            $tr[$v->m_title][] = "<tr><td>{$v->m_title}</td><td>{$v->s_title}</td><td class='chk'><input type='checkbox' value='1' data-smenu='{$v->s_idx}'></td><td class='chk'><input type='checkbox' value='2' data-smenu='{$v->s_idx}'></td><td class='chk'><input type='checkbox' value='4' data-smenu='{$v->s_idx}'></td><td class='chk'><input type='checkbox' value='8' data-smenu='{$v->s_idx}'></td><td class='chk'><input type='checkbox' value='16' data-smenu='{$v->s_idx}'></td><td class='chk'><input type='checkbox' value='32' data-smenu='{$v->s_idx}'></td></tr>";
        }

        foreach ($tr as $k => $v) {
            $rows = count($v);
            if ($rows > 1) {
                $v = preg_replace('#<tr><td>.+?</td>#', '<tr>', $v);
                $v[0] = preg_replace('/<tr>/', "<tr><td rowspan=\"$rows\">$k</td>", $v[0]);
            }
            $tr_html .= implode('', $v);
        }

        return view('contents/group_auth',['menu_list'=>$tr_html]);
    }

    public function group_insert(Request $request)
    {
        $flag = 'fail';
        $msg = 'error 1992097';
        //insert group
        $g_insert = DB::table('group')->insert([
            'title' => $request->title,
            'team' => $request->team,
            'use_yn' => 1
        ]);
        if($g_insert) {
            $g_idx = DB::getPdo()->lastInsertId();
            foreach(array_filter($request['res']) AS $s_idx => $data) {
                $auth = 0;
                foreach($data AS $val) {
                    $auth += $val;
                }
                //insert group_auth_mapping
                DB::table('group_auth_mapping')->insert([
                    'g_idx' => $g_idx,
                    's_idx' => $s_idx,
                    'auth' => $auth
                ]);
                $flag = 'ok';
                $msg = '정상 처리되었습니다.';
            }
        }
        return response()->json([
            'result' => $flag,
            'msg' => $msg,
        ], 200);
    }
}
