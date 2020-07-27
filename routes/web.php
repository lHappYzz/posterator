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

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::group(['prefix'=>'admin', 'namespace'=>'Admin', 'middleware'=>['auth', 'role:admin']], function(){
    Route::get('/', 'DashboardController@index')->name('admin.index');
    Route::resource('/category', 'CategoryController', ['as'=>'admin']);
    Route::resource('/user', 'UserController', ['as'=>'admin']);
    Route::get('/clear/cache', function() {
        try {
            Artisan::call('cache:clear');
            Artisan::call('config:cache');
            Artisan::call('view:clear');
            Artisan::call('route:clear');
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return 'Cache successfully cleared';
    });
});

Route::get('/', 'PagesController@mainPage')->name('user.page.main');

Route::group(['prefix' => 'profile', 'middleware' => 'auth'], function (){
    Route::get('/', 'PagesController@profile')->name('user.page.profile');
    Route::get('/posts', 'ProfileController@userPosts')->name('user.page.profile.posts');
    Route::get('/edit', 'ProfileController@profileEdit')->name('user.page.profile.edit');
    Route::put('/update/{user}', 'ProfileController@update')->name('user.page.profile.update');
});

Route::resource('/post', 'PostController')->except('show');
Route::get('/post/{post}', 'PostController@show')->middleware('can.view-post')->name('post.show');
Route::post('/post/publish', 'PostController@publish')->name('post.publish');
Route::post('/comment', 'PostController@storeComment')->name('comment.store');
Route::post('/uploads', 'CKEditorController@uploadImg')->name('image.upload');


