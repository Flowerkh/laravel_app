<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BoardController;

Route::get('/', function() {return view('login'); })->name('login');

Route::post('/login', 'AuthController@loginAdmin');
Route::post('/logout', 'AuthController@logout')->name('logout');

Route::middleware('auth')->group(function() {
    Route::get('/main', [HomeController::class, 'index'])->name('main');

    //그룹 페이지
    Route::get('/group', [HomeController::class, 'group'])->name('group'); //리스트
    Route::post('/group_list', 'HomeController@group_list');
    Route::put('/group_add_id', 'HomeController@group_add_id'); //그룹 권한 아이디 추가
    Route::delete('/group_del', 'HomeController@group_del'); //삭제
    Route::delete('/group_list_del', 'HomeController@group_list_del'); //리스트 삭제

    //테스트
    Route::get('/hello', [HomeController::class, 'hello']);
    Route::get('/test', 'TestController@testIndex');

    Route::get('/board', [BoardController::class, 'index']);
});
