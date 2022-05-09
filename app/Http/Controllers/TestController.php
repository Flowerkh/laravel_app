<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function testIndex()
    {
        $td = DB::select('select * from test');
        return view('/contents/test', ['td'=>$td]);
    }
}
