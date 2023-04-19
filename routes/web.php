<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CategoryController;

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

Route::get('/user', function () {
    return view('welcome');
});

// Route::get('/view', function () {
//     $data=[1,2,3,4,5];
//     return  response()->json([
//         'success'=>true,
//         'view'=>view('random',compact('data'))->render()
//     ]);
// })->name('ajaxView');

Auth::routes();

Route::get('/view', [App\Http\Controllers\HomeController::class, 'index'])->name('ajaxView');
Route::get('/view/user', [App\Http\Controllers\HomeController::class, 'userView'])->name('ajaxViewUser');
Route::get('/view/user-edit/{id}', [App\Http\Controllers\HomeController::class, 'edit'])->name('edit_ajaxUser');
Route::PUT('/view/user-update/{id}', [App\Http\Controllers\HomeController::class, 'update'])->name('update_ajaxUser');
Route::controller(UserController::class)->group(function () {
    Route::get('/home/chat','index')->name('chat');
    Route::get('/home','post')->name('home');
    Route::post('/home/chat','saveChat')->name('saveChat');
    Route::post('/load-chat','loadChat')->name('loadChat');
    Route::get('/userProfile','userProfile')->name('userProfile');
    Route::post('/ProfileChange/photo/{id}','ProfileChange')->name('ProfileChange');
    Route::PUT('/ProfileChange/{id}','user_password')->name('user_password');
});

Route::prefix('admin')->group(function(){
    Route::controller(CategoryController::class)->group(function(){
        Route::get('/category','index')->name('category');
        Route::get('/category/create','create')->name('category.create');
        Route::post('/category','store')->name('category.store');
        Route::get('/category/edit/{id}','edit')->name('category.edit');
        Route::put('/category/{id}','update')->name('category.update');
        Route::get('/category/delete/{id}','delete')->name('category.destroy');
    });

    Route::controller(PostController::class)->group(function(){
        Route::get('/post','index')->name('post');
        Route::get('/post/create','create')->name('post.create');
        Route::post('/post','store')->name('post.store');
        Route::get('/post/edit/{id}','edit')->name('post.edit');
        Route::put('/post/{id}','update')->name('post.update');
        Route::get('/post/delete/{id}','delete')->name('post.destroy');
    });

    Route::controller(LikeController::class)->group(function(){
        Route::post('/home/like/{id}','likeStore')->name('likeStore');
        Route::delete('/home/unlike/{id}','likeDelete')->name('likeDelete');

    });
    Route::controller(CommentController::class)->group(function(){
        Route::post('/home/comment/{id}','commentPost')->name('post.comment');
        Route::get('/home/comment/edit/{id}','commentEdit')->name('comment.edit');
        Route::put('/home/comment/update/{id}','commentUpdate')->name('comment.update');
        // Route::delete('/home/unlike/{id}','likeDelete')->name('likeDelete');

    });


});
