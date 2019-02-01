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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/auth/token', 'Auth\AuthController@store');
Route::get('/social/auth/{provider}', 'Auth\AuthController@redirect');
Route::get('/social/auth/{provider}/callback', 'Auth\AuthController@callback');