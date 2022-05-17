<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function testIndex()
    {
        $ad_group = DB::table('gecl_admin.test')->select('*')->get();

        return view('/contents/test', ['ad_group'=>$ad_group]);
    }
}
