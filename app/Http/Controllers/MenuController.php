<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function menuList()
    {
        $menu_list = DB::table('menu')
            ->select('*')
            ->where('use_yn','=',1)
            ->get();

        return $menu_list;
    }

    public function list(Request $request)
    {
        $result = 'ok';
        $sub_data = DB::select("SELECT * FROM gecl_admin.sub_menu WHERE m_idx = '{$request->num}' AND use_yn = 1");

        $html = '<div class="bg-white py-2 collapse-inner rounded">';
        foreach($sub_data AS $data) {
            $html .= '<a class="collapse-item" href="/menu/list/'.$data->page_link.'">'.$data->title.'</a>';
        }
        $html .= '</div>';

        return response()->json([
            'result' => $result,
            'html' =>$html
        ], 200);
    }

    public function page($page)
    {
        $menu_list = $this->menuList();
        $user_id = session()->get('u_idx');
        $where = " AND sm.use_yn = '1' AND ugm.u_idx = {$user_id} AND sm.page_link = '{$page}'AND g.team = '".session()->get('team')."'";
        if(session()->get('team')=='ts1') $where = '';

        $auth_list = DB::select("
            SELECT p.auth_name,p.bit FROM
        user_group_mapping AS ugm
            JOIN group_auth_mapping AS gam ON ugm.g_idx = gam.g_idx
            JOIN gecl_admin.group AS g ON g.g_idx = gam.g_idx
            JOIN sub_menu AS sm ON gam.s_idx = sm.s_idx
            JOIN permission AS p ON gam.auth & p.bit
            WHERE g.use_yn = '1' {$where}
            GROUP BY p.auth_name");

        foreach($auth_list AS $data) {
            $auth[$data->auth_name] = $data->bit;
        }
        if(session()->get('team')!='ts1') {
            if(empty($auth['r'])) {return '<script>alert("페이지 읽기 권한이 없습니다.");location.href="/group";</script>';exit;}
        }
        return view('page/'.$page, ['menu_list'=>$menu_list, 'auth'=>$auth]);
    }

}
