<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function login (Request $request) {
        $userid = $request->input('id');
        $userpw = $request->input('pw');

        $result = collect(DB::select('SELECT '));

        return redirect('');
    }
}
