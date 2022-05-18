<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BoardController;

Route::get('/', function() {return view('login'); })->name('login');

Route::post('/login', 'AuthController@loginAdmin');
Route::post('/logout', 'AuthController@logout')->name('logout');

Route::middleware('auth')->group(function() {
    Route::get('/main', [HomeController::class, 'index'])->name('main');

    Route::get('/hello', [HomeController::class, 'hello']);

    //그룹 페이지
    Route::get('/group', [HomeController::class, 'group'])->name('group'); //리스트
    Route::post('/group_list', 'HomeController@group_list');
    Route::get('/group_del/{idx}', 'HomeController@group_del'); //삭제

    Route::get('/test', 'TestController@testIndex');

    Route::get('/board', [BoardController::class, 'index']);
});
