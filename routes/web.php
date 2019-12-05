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

Route::get('/','WishListController@index');
Route::get('/home','WishListController@index');
Route::get('/wishlist/{user}','WishListController@show');

Auth::routes();