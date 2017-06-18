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

//Route::get('/', function () {
//    return view('welcome');
//});

//Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('extract', 'FilesController@index');
Route::post('extract', 'FilesController@extract');

Route::get('login','Auth\LoginController@showLoginForm');
Route::post('login','Auth\LoginController@login');
Route::post('logout','Auth\LoginController@logout');

Route::get('upload','FilesController@index');
Route::post('upload','FilesController@upload');

Route::get('user','UsersController@index');