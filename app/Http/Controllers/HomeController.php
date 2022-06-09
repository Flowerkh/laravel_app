<?php
namespace App\Http\Controllers;

use App\Http\Controllers\MenuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $menu_list = MenuController::menuList();

        return view('welcome', ['menu_list'=>$menu_list]);
    }

    public function hello()
    {
        $menu_list = MenuController::menuList();

        return view('contents/hello', ['menu_list'=>$menu_list]);
    }

}
