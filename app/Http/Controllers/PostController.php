<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'image'   => 'required|image|max:2048',
            'caption' => 'required|string|max:1000',
        ]);

        $path = $request->file('image')->store('posts', 'public');
        Post::create([
            'image' => $path,
            'caption' => $data['caption']
        ]);

        return redirect('/')->with('success', 'Post berhasil dibuat!');
    }

    public function like(Post $post)
    {
        $post->increment('likes');
        return response()->json(['likes' => $post->likes]);
    }

    public function comment(Post $post, Request $request)
    {
        $data = $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $names = ['Anon', 'Pengamat', 'Komentator', 'Pecinta', 'Observer', 'Viewer'];
        $name = $names[array_rand($names)];

        $post->comments()->create([
            'name' => $name,
            'content' => $data['content'],
        ]);

        return back()->with('success_comment', 'Komentar berhasil ditambahkan!');
    }
}
