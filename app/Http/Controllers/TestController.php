<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function testIndex()
    {
        $ad_group = DB::table('gecl_admin.admin_user')
            ->select('*')
            ->get();

        return view('/contents/test', ['ad_group'=>$ad_group]);
    }
}
