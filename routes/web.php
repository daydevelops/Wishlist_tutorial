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
Route::get('/wish/new/','WishController@create');
Route::get('/friend','FriendController@index');
Route::post('/friend/{user}','FriendController@store');
Route::delete('/friend/{user}','FriendController@destroy');
Route::get('/wishlist/search','WishListController@search');
Route::get('/wishlist/{user}','WishListController@show');
Route::post('/wish','WishController@store');
Route::delete('/wish/{wish}','WishController@destroy');
Route::patch('/wish/{wish}/purchase','WishController@purchase');
Route::patch('/wish/{wish}/unpurchase','WishController@unpurchase');
Auth::routes();