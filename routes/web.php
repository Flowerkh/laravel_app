<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BoardController;

Route::get('/', function() {return view('login'); })->name('login');

Route::post('/login', 'AuthController@loginAdmin');
Route::post('/logout', 'AuthController@logout')->name('logout');

Route::middleware('auth')->group(function() {
    Route::get('/main', [HomeController::class, 'index']);

    Route::get('/hello', [HomeController::class, 'hello']);
    Route::get('/group', [HomeController::class, 'group']);
    Route::get('/test', 'TestController@testIndex');
    Route::get('/board', [BoardController::class, 'index']);
});
