<?php

namespace App\Http\Controllers;


use App\Entities\Post;

class PostController
{

    public function index()
    {
        $posts = Post::published()->with('attachment')->paginate(10);
        return view('blog.index', compact('posts'));
    }

    public function show(Post $post)
    {
        return view('blog.show', compact('post'));
    }
}