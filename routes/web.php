<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\LoginController;

Route::get('/hello', [HomeController::class, 'hello']);
Route::get('/test', 'TestController@testIndex');

Route::get('/board', [BoardController::class, 'index']);

Route::get('/', function() {return view('login'); })->name('login');

Route::middleware('auth')->group(function() {
    Route::get('/main', [HomeController::class, 'index']);
});
Route::get('/login', 'LoginController@index');
