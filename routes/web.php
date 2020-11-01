<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/', 'WEB\GamesController@newGameIndex');
    Route::post('/new_game', "WEB\GamesController@newGameStore");
//    Route::get('/dashboard', function() { return view('dashboard.dashboard'); });
    Route::get('/dashboard', "WEB\DashboardsController@dashboardIndex");
    Route::get('/profile', function() { return view('users.profile'); });
    Route::get('/history', function() { return view('history.history'); });
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
