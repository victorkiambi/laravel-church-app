<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //Get all posts
    public function index(): JsonResponse
    {
        $posts = Post::with(['user:id,username', 'comments:id,post_id,comments'])
            ->paginate(5);
        $totalPages = $posts->lastPage();
        return response()->json([
            'content' => $posts,
            'totalPages' => $totalPages
        ]);
    }

    //Get a post by id
    public function show($id): JsonResponse
    {
        $post = Post::with('comments.user')->findOrFail($id);
        return response()->json($post);
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
