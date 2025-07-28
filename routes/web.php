<?php

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Models\Comment;

// Tampilkan landing page dengan semua postingan dan komentar
Route::get('/', function () {
    $posts = Post::with('comments')->latest()->get();
    return view('home', compact('posts'));
});

// Simpan postingan baru
Route::post('/posts', function (Request $request) {
    $data = $request->validate([
        'image'   => 'required|image|max:2048',
        'caption' => 'required|string|max:1000',
    ]);
    $path = $request->file('image')->store('posts', 'public');
    Post::create(['image' => $path, 'caption' => $data['caption']]);
    return redirect('/')->with('success', 'Post berhasil dibuat!');
});

// Tambah like
Route::post('/posts/{post}/like', function (Post $post) {
    $post->increment('likes');
    return response()->json(['likes' => $post->likes]);
});

// Tambah komentar
Route::post('/posts/{post}/comments', function (Post $post, Request $request) {
    $data = $request->validate(['content' => 'required|string|max:500']);
    $names = ['Anon','Pengamat','Komentator','Pecinta','Observer','Viewer'];
    $name = $names[array_rand($names)];
    $post->comments()->create(['name' => $name, 'content' => $data['content']]);
    return back()->with('success_comment', 'Komentar berhasil ditambahkan!');
});