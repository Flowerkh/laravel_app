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
    Route::get('/group', 'GroupController@group')->name('group'); //리스트
    Route::get('/group_auth', 'GroupController@group_auth');
    Route::get('/group_auth/{gp}', 'GroupController@group_auth_get');
    Route::post('/group_list', 'GroupController@group_list');
    Route::post('/group_copy', 'GroupController@group_copy');
    Route::put('/group_add_id', 'GroupController@group_add_id'); //그룹 권한 아이디 추가
    Route::delete('/group_del', 'GroupController@group_del'); //삭제
    Route::delete('/group_list_del', 'GroupController@group_list_del'); //리스트 삭제
    Route::put('/group_insert', 'GroupController@group_insert'); //그룹 추가
    Route::put('/group_modify', 'GroupController@group_update'); //그룹 수정

    //테스트
    Route::get('/hello', [HomeController::class, 'hello']);
    Route::get('/test', 'TestController@testIndex');

    Route::get('/board', [BoardController::class, 'index']);
});
