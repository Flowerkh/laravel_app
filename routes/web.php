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
        Route::get('/', 'GroupController@group')->name('group'); //그룹 확인 리스트
        Route::get('/auth', 'GroupController@groupAuth');
        Route::get('/auth/{gp}', 'GroupController@groupAuthGet');
        Route::post('/duplicate', 'GroupController@groupDuplicate'); //제목 중복검사
        Route::post('/copy', 'GroupController@groupCopy'); //그룹 복사
        Route::put('/insert', 'GroupController@groupInsert'); //그룹 추가
        Route::put('/modify', 'GroupController@groupUpdate'); //그룹 수정
        Route::delete('/del', 'GroupController@groupDel'); //그룹 삭제

        Route::prefix('/member')->group(function() {
            Route::post('/list', 'GroupController@groupList'); //그룹에 속한 admin 리스트 확인
            Route::put('/insert', 'GroupController@groupAddid'); //그룹 권한 아이디 추가
            Route::delete('/del', 'GroupController@groupListDel'); //리스트 삭제
        });
    });

    //메뉴페이지
    Route::prefix('/menu')->group(function() {
        Route::post('/list','MenuController@list');
        Route::get('/list/{page}','MenuController@page');
    });

    //관리자&사원 리스트
    Route::prefix('member')->group(function() {
        Route::get('/','memberController@List');
        Route::post('/info','memberController@memberInfo');
    });

    //테스트
    Route::get('/hello', [HomeController::class, 'hello']);
    Route::get('/test', 'TestController@testIndex');

    Route::get('/board', [BoardController::class, 'index']);
});
