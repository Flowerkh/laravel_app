<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

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
        return view('contents/group_list');
    }
}
