<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    $posts = Post::with('comments')->latest()->get();
    return view('home', compact('posts'));
});

Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like');
Route::post('/posts/{post}/comments', [PostController::class, 'comment'])->name('posts.comment');
