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
        return view('page/'.$page, ['menu_list'=>$menu_list,'page'=>$page]);
    }

}
