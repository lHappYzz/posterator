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

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CKEditorController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Auth::routes(['verify' => true]);

Route::group(['prefix'=>'admin', 'middleware'=>['auth', 'role:admin']], function(){
    Route::get('/', [DashboardController::class, 'index'])->name('admin.index');
    Route::resource('/category', CategoryController::class, ['as'=>'admin']);
    Route::resource('/user', UserController::class, ['as'=>'admin']);
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

Route::get('/', [PagesController::class, 'mainPage'])->name('user.page.main');

Route::group(['prefix' => 'profile', 'middleware' => ['auth', 'verified']], function (){
    Route::get('/', [PagesController::class, 'profile'])->name('user.page.profile');
    Route::get('/posts', [ProfileController::class, 'userPosts'])->name('user.page.profile.posts');
    Route::get('/edit', [ProfileController::class, 'profileEdit'])->name('user.page.profile.edit');
    Route::put('/update/{user}', [ProfileController::class, 'update'])->name('user.page.profile.update');

    Route::resource('/post', PostController::class)->except('show');
    Route::post('/post/publish', [PostController::class, 'publish'])->name('post.publish');
    Route::post('/comment', [PostController::class, 'storeComment'])->name('comment.store');
    Route::post('/uploads', [CKEditorController::class, 'uploadImg'])->name('image.upload');
});

Route::get('/post/{post}', [PostController::class, 'show'])->middleware('can.view-post')->name('post.show');


