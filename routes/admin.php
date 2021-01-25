<?php

use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\PostThumbnailController;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', function () {
    return Inertia\Inertia::render('Dashboard');
})->name('dashboard');


Route::resource('posts', PostController::class);
Route::post('posts/{post}/publish', [PostController::class, 'publish'])->name('posts.publish');
Route::delete('posts/{post}/thumbnail', [PostThumbnailController::class, 'destroy'])->name('posts_thumbnail.destroy');
