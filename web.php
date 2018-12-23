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


Route::get('/','HomeController@show');
Route::post('/','ShopController@selectForm');

Route::get('/register','RegisterController@showForm');
Route::post('/register','RegisterController@findChoice');

Route::get('/register/optionalForm','RegisterController@showOptionalForm');
Route::post('/register/optionalForm','RegisterController@findChoice');

Route::get('/login','Auth\LoginController@showForm');
Route::post('/login','Auth\LoginController@selectForm');

Route::get('/client/profil','ProfileController@show');
Route::post('/client/profil','ProfileController@selectForm');

Route::get('/vendeur/profil','ProfileController@show');





