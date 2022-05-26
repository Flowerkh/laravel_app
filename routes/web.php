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
    Route::prefix('/group')->group(function() {
        Route::get('/group', 'GroupController@group')->name('group'); //그룹 확인 리스트
        Route::get('/auth', 'GroupController@group_auth');
        Route::get('/auth/{gp}', 'GroupController@group_auth_get');
        Route::post('/list', 'GroupController@group_list'); //그룹에 속한 admin 리스트 확인
        Route::post('/duplicate', 'GroupController@group_duplicate'); //제목 중복검사
        Route::post('/copy', 'GroupController@group_copy'); //그룹 복사
        Route::put('/add_id', 'GroupController@group_add_id'); //그룹 권한 아이디 추가
        Route::put('/insert', 'GroupController@group_insert'); //그룹 추가
        Route::put('/modify', 'GroupController@group_update'); //그룹 수정
        Route::delete('/del', 'GroupController@group_del'); //그룹 삭제
        Route::delete('/UserList_del', 'GroupController@group_list_del'); //리스트 삭제
    });


    //테스트
    Route::get('/hello', [HomeController::class, 'hello']);
    Route::get('/test', 'TestController@testIndex');

    Route::get('/board', [BoardController::class, 'index']);
});
