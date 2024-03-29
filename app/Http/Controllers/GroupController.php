<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MenuController;

class GroupController extends Controller
{
    public function group()
    {
        $where = [['use_yn','=',1],['team','=',session()->get('team')]];
        if(session()->get('team')=='ts1') $where = [['use_yn','=',1]];
        $menu_list = MenuController::menuList();
        $group_list = DB::table('gecl_admin.group')
            ->select('*')
            ->where($where)
            ->get();

        return view('contents/group_list', ['group_list'=>$group_list,'menu_list'=>$menu_list]);
    }

    public function groupList(Request $request)
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

    public function groupCopy(Request $request)
    {
        $copy_cnt = DB::select("SELECT COUNT(*) AS cnt FROM gecl_admin.group WHERE title LIKE '%".$request['title']."%'");
        $copy_int = (int)($copy_cnt[0]->cnt);

        DB::table('group')->insert([
            'title' => $request['title']."_COPY".($copy_int+1),
            'team' => session()->get('team'),
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

    public function groupDel(Request $request)
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

    public function groupListDel(Request $request)
    {
        $result = DB::table('user_group_mapping')->where('ug_idx','=',$request->ug_idx)->delete();

        return response()->json([
            'result' => $result
        ], 200);
    }

    public function groupAddid(Request $request)
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

    public function groupAuth()
    {
        $tr = array();
        $tr_html = "";
        $menu_list = $this->selectMenuList();

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
        unset($menu_list);
        $menu_list = MenuController::menuList();
        return view('contents/group_Auth',['tr_html'=>$tr_html,'menu_list'=>$menu_list]);
    }

    public function groupAuthGet($gp)
    {
        $tr = array();$arr = array();$tr_html = "";

        $menu_list = $this->selectMenuList();
        $per_list = DB::table('group_auth_mapping AS gam')
            ->leftJoin('permission AS p','gam.auth','&','p.bit')
            ->select('gam.s_idx','p.bit')
            ->where([['gam.g_idx','=',$gp]])
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
        $group_data = $this->selectGroup($gp);
        if((session()->get('team')!='ts1')){
            if((session()->get('team')!=$group_data[0]->team)) {return '<script>alert("해당 페이지 권한이 없습니다.");location.href="/group";</script>';exit;}
        }
        if(empty($group_data[0])) {return '<script>alert("삭제된 페이지입니다.");location.href="/group";</script>';exit;}
        unset($menu_list);
        $menu_list = MenuController::menuList();

        return view('contents/group_auth',['tr_html'=>$tr_html,'gp'=>$gp,'group_data'=>$group_data[0],'menu_list'=>$menu_list]);
    }

    public function groupInsert(Request $request)
    {
        $flag = 'fail';
        $msg = 'error 1992097';
        $g_insert = $this->InsertGroup($request);
        if($g_insert) {
            $g_idx = DB::getPdo()->lastInsertId();
            $result = $this->insertGroupauth($g_idx,$request);
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

    public function groupUpdate(Request $request)
    {
        $flag = 'fail';
        $msg = 'error 1992006';
        $this->UpdateGroup($request);
        $d_result = DB::table('group_auth_mapping')->where('g_idx','=',$request->gp)->delete();
        if($d_result) {
            $result = $this->insertGroupauth($request->gp,$request);
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

    private function selectGroup($g_idx) {
        return DB::table('group')
            ->where([['g_idx','=',$g_idx],['use_yn','=',1]])
            ->get();
    }

    private function selectMenuList() {
        return DB::table('menu AS m')
            ->join('sub_menu AS sm','m.m_idx','=','sm.m_idx')
            ->select('sm.m_idx','sm.s_idx','m.title as m_title','sm.title as s_title')
            ->where([['m.use_yn','=','1'],['sm.use_yn','=','1']])
            ->get();
    }

    private function InsertGroup($request) {
        $team = session()->get('team');
        if($request->team_o) $team = $request->team_o;

        return DB::table('group')->insert([
            'title' => $request->title,
            'team' => $team,
            'use_yn' => 1
        ]);
    }

    private function UpdateGroup($request) {
        $team = session()->get('team');
        if($request->team_o) $team = $request->team_o;

        return DB::table('group')
            ->where('g_idx','=',$request->gp)
            ->update([
            'title' => $request->title,
            'team' => $team,
            'use_yn' => 1
        ]);
    }

    private function insertGroupauth($g_idx, $request) {
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

    public function groupDuplicate(Request $request)
    {
        $result = 'fail';

        $cnt = DB::select("SELECT count(*) as cnt FROM gecl_admin.group WHERE title = '{$request['title']}' AND use_yn = 1");
        if($cnt[0]->cnt==0) $result = 'ok';
        if(trim($request['title'])=='') $result = 'trim';

        return response()->json([
            'result' => $result
        ], 200);
    }
}
