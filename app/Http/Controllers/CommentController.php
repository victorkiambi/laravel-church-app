<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //Get all comments
    public function index()
    {
        return Comment::all();
    }

    //Get a comment by id
    public function show($id)
    {
        return Comment::find($id);
    }

    //Create a new comment
    public function store(Request $request)
    {
        return Comment::create($request->all());
    }

    //Update a comment
    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);
        $comment->update($request->all());

        return $comment;
    }
}
