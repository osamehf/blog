<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('posts')->group(function() {
    Route::GET('', [PostController::class, 'getPosts']);

    Route::POST('', [PostController::class, 'postPost']);

    Route::prefix('{post}')->group(function() {
        Route::GET('', [PostController::class, 'getPost']);

        Route::PATCH('', [PostController::class, 'patchPost']);

        Route::DELETE('', [PostController::class, 'deletePost']);

        Route::prefix('comments')->group(function() {
            Route::GET('', [PostController::class, 'getPostComments']);

            Route::POST('', [PostController::class, 'postPostComment']);

            Route::DELETE('{comment}', [PostController::class, 'deletePostComment']);
        });
    });
});
