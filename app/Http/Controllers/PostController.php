<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //Get all posts
    public function index()
    {
        return Post::with(['user:id,username', 'comments:id,post_id,comments'])
            ->paginate(5);
    }

    //Get a post by id
    public function show($id)
    {
        return Post::with('comments.user')->findOrFail($id);
    }

    //Create a new post
    public function store(Request $request)
    {
        return Post::create($request->all());
    }

    //Update a post
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->update($request->all());

        return $post;
    }
}
