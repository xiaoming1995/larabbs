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

Route::get('/','TopicsController@index')->name('root')->middleware('category');
Route::get('about','PagesController@about')->name('about');
Auth::routes();

//用户
Route::resource('users','UsersController',['only'=>['show','update','edit']])->middleware('activation');
Route::get('attention/{user_id}','UsersController@attention')->name('user.attention');
Route::get('user_list/{user}/{type}','UsersController@attentions_or_followers_list')->name('user.list');

Route::get('signup/confirm/{token}','UsersController@activation')->name('confirm_email');
Route::get('user/activation/{user}','UsersController@activation_view')->name('users.activation');
Route::get('user/SendActivationEmail/{user}','UsersController@send_activation_email')->name('users.send.email');

//文章
Route::resource('topics', 'TopicsController', ['only' => ['index','create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('categories','CategoriesController',['only'=>['show']]);
Route::get('topics/{topic}/{slug?}','TopicsController@show')->name('topics.show');


Route::post('upload_image', 'TopicsController@uploadImage')->name('topics.upload_image');
Route::resource('replies', 'RepliesController', ['only' => ['store','destroy']]);

Route::resource('notifications', 'NotificationsController', ['only' => ['index']]);
Route::get('permission-denied', 'PagesController@permissionDenied')->name('permission-denied');
