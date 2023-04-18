<?php

use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Guest\HomeController as GuestHomeController;

use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CategoryController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [GuestHomeController::class, 'index']);

Route::get('/home', [PostController::class, 'index'])->middleware('auth')->name('home');

Route::middleware('auth')
    ->prefix('/admin')
    ->name('admin.')
    ->group(function() {
        // # softdeletes and trash for posts resource
        Route::get('/posts/trash', [PostController::class, 'trash'])->name('posts.trash');
        Route::put('/posts/{post}/restore', [PostController::class, 'restore'])->name('posts.restore');
        Route::delete('/posts/{post}/force-delete', [PostController::class, 'forceDelete'])->name('posts.force-delete');

        // # posts resource
        Route::resource('posts', PostController::class);

        // # categories resource
        Route::resource('categories', CategoryController::class)->except(['show']);
    });

Route::middleware('auth')
    ->prefix('/profile') // * tutti gli url hanno il prefisso "/profile"
    ->name('profile.') // * tutti i nomi delle rotte hanno il prefisso "profile".
    ->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

require __DIR__ . '/auth.php';