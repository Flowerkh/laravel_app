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

    public function group_copy(Request $request)
    {
        $copy_cnt = DB::select("SELECT COUNT(*) AS cnt FROM gecl_admin.group WHERE title LIKE '%".$request['title']."%'");
        $copy_int = (int)($copy_cnt[0]->cnt);

        DB::table('group')->insert([
            'title' => $request['title']."_COPY".($copy_int+1),
            'team' => $request['team'],
            'use_yn' => '1'
        ]);
        $g_idx = DB::getPdo()->lastInsertId();
        $result = DB::insert("INSERT INTO group_auth_mapping ( g_idx,s_idx,auth) SELECT {$g_idx} AS 'g_idx',s_idx,auth FROM group_auth_mapping WHERE g_idx = {$request['idx']}");
        if($result) {
            $data_list = DB::select("SELECT * FROM gecl_admin.group WHERE title = '".$request['title']."_COPY".($copy_int+1)."'");
            $flag = 'ok';
        } else {
            $data_list = '';
            $flag = 'fail';
        }
        return response()->json([
            'data'=>$data_list[0],
            'result'=>$flag
        ],200);
    }

    public function group_del(Request $request)
    {
        $result = DB::table('group')
            ->where('g_idx','=',$request->idx)
            ->update(['use_yn' => 0]);
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
        $menu_list = $this->Select_menuList();

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

    public function group_auth_get($gp)
    {
        $tr = array();$arr = array();$tr_html = "";

        $menu_list = $this->Select_menuList();
        $per_list = DB::table('group_auth_mapping AS gam')
            ->leftJoin('permission AS p','gam.auth','&','p.bit')
            ->select('gam.s_idx','p.bit')
            ->where('gam.g_idx','=',$gp)
            ->get();

        foreach ($per_list as $d) {
            $arr[$d->s_idx][$d->bit] = $d->bit;
        }

        foreach ($menu_list as $k => $v) {
            $r='';$w='';$m='';$d='';$u='';$x='';
            if(!empty($arr[$v->s_idx][1])) $r="checked";
            if(!empty($arr[$v->s_idx][2])) $w="checked";
            if(!empty($arr[$v->s_idx][4])) $m="checked";
            if(!empty($arr[$v->s_idx][8])) $x="checked";
            if(!empty($arr[$v->s_idx][16])) $u="checked";
            if(!empty($arr[$v->s_idx][32])) $d="checked";
            $tr[$v->m_title][] = "<tr><td>{$v->m_title}</td><td>{$v->s_title}</td><td class='chk'><input type='checkbox' value='1' data-smenu='{$v->s_idx}' {$r}></td><td class='chk'><input type='checkbox' value='2' data-smenu='{$v->s_idx}' {$w}></td><td class='chk'><input type='checkbox' value='4' data-smenu='{$v->s_idx}' {$m}></td><td class='chk'><input type='checkbox' value='8' data-smenu='{$v->s_idx}' {$x}></td><td class='chk'><input type='checkbox' value='16' data-smenu='{$v->s_idx}' {$u}></td><td class='chk'><input type='checkbox' value='32' data-smenu='{$v->s_idx}' {$d}></td></tr>";
        }

        foreach ($tr as $k => $v) {
            $rows = count($v);
            if ($rows > 1) {
                $v = preg_replace('#<tr><td>.+?</td>#', '<tr>', $v);
                $v[0] = preg_replace('/<tr>/', "<tr><td rowspan=\"$rows\">$k</td>", $v[0]);
            }
            $tr_html .= implode('', $v);
        }
        $group_data = $this->Select_group($gp);

        return view('contents/group_auth',['menu_list'=>$tr_html,'gp'=>$gp,'group_data'=>$group_data[0]]);
    }

    public function group_insert(Request $request)
    {
        $flag = 'fail';
        $msg = 'error 1992097';
        $g_insert = $this->Insert_group($request);
        if($g_insert) {
            $g_idx = DB::getPdo()->lastInsertId();
            $result = $this->Insert_group_auth($g_idx,$request);
            if($result){
                $flag = 'ok';
                $msg = '정상 처리되었습니다.';
            }
        }
        return response()->json([
            'result' => $flag,
            'msg' => $msg,
        ], 200);
    }

    public function group_update(Request $request)
    {
        $flag = 'fail';
        $msg = 'error 1992006';
        $this->Update_group($request);
        $d_result = DB::table('group_auth_mapping')->where('g_idx','=',$request->gp)->delete();
        if($d_result) {
            $result = $this->Insert_group_auth($request->gp,$request);
            if($result) {
                $flag = 'ok';
                $msg = '정상 처리되었습니다.';
            }
        }

        return response()->json([
            'result' => $flag,
            'msg' => $msg,
        ], 200);
    }

    private function Select_group($g_idx) {
        return DB::table('group')
            ->where('g_idx','=',$g_idx)
            ->get();

    }
    private function Select_menuList() {
        return DB::table('menu AS m')
            ->join('sub_menu AS sm','m.m_idx','=','sm.m_idx')
            ->select('sm.m_idx','sm.s_idx','m.title as m_title','sm.title as s_title')
            ->where([['m.use_yn','=','1'],['sm.use_yn','=','1']])
            ->get();
    }

    private function Insert_group($request) {
        return DB::table('group')->insert([
            'title' => $request->title,
            'team' => $request->team,
            'use_yn' => 1
        ]);
    }

    private function Update_group($request) {
        return DB::table('group')
            ->where('g_idx','=',$request->gp)
            ->update([
            'title' => $request->title,
            'team' => $request->team,
            'use_yn' => 1
        ]);
    }

    private function Insert_group_auth($g_idx, $request) {
        $result = false;
        foreach(array_filter($request['res']) AS $s_idx => $data) {
            $auth = 0;
            foreach($data AS $val) {
                $auth += $val;
            }
            $result = DB::table('group_auth_mapping')->insert([
                'g_idx' => $g_idx,
                's_idx' => $s_idx,
                'auth' => $auth
            ]);
        }
        return $result;
    }
    public function group_duplicate(Request $request)
    {
        $result = 'fail';
        $cnt = DB::select("SELECT count(*) as cnt FROM gecl_admin.group WHERE title = '{$request['title']}'");
        if($cnt[0]->cnt==0) $result = 'ok';

        return response()->json([
            'result' => $result
        ], 200);
    }
}
