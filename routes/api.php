<?php

use App\Http\Controllers\CategoryApiController;
use App\Http\Controllers\CommentApiController;
use App\Http\Controllers\PostApiController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return auth()->user();
    });
    Route::post('/logout', [SessionController::class, 'logout']);

    Route::post('/posts', [PostApiController::class, 'store']);
    Route::put('/posts/{post}', [PostApiController::class, 'update']);
    Route::delete('/posts/{post}', [PostApiController::class, 'destroy']);
    #comments
    Route::post('/comments', [CommentApiController::class, 'store']);
    #end comments

});
#posts
Route::get('/posts', [PostApiController::class, 'index']);
Route::get('/posts/{post}', [PostApiController::class, 'show']);
#end posts

Route::get('/comments', [CommentApiController::class, 'index']);


#categories
Route::get('/categories', [CategoryApiController::class, 'index']);
#end categories

#guest routes
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [SessionController::class, 'login']);
#end guest routes

#testing route
Route::get('/test', function () {
    return 'testing';
});
