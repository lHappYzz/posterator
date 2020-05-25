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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::group(['prefix'=>'admin', 'namespace'=>'Admin', 'middleware'=>['auth', 'role:admin']], function(){
    Route::get('/', 'DashboardController@index')->name('admin.index');
    Route::resource('/category', 'CategoryController', ['as'=>'admin']);
    Route::resource('/user', 'UserController', ['as'=>'admin']);
});

Route::get('/', 'PagesController@mainPage')->name('user.page.main');
Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/post', 'PostController');


Route::post('/comment', 'PostController@storeComment')->name('comment.store');


