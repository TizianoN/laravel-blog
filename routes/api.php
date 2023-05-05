<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CommentController;

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

Route::apiResource('posts', PostController::class)->except('store', 'update', 'destroy');
Route::get('/category/{category_id}/posts', [PostController::class, 'getPostsByCategory']);

Route::get('post/{post_id}/comments', [CommentController::class, 'getCommentsByPost']);
Route::post('comments', [CommentController::class, 'store']);