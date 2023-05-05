<?php

namespace App\Http\Controllers\Api;

use App\Models\Comment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|integer|exists:posts,id',
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $comment = new Comment();
        $comment->fill($request->all());
        $comment->save();

        return response()->json([
            'success' => 'true'
        ]);
    }

    /**
     * Display the specified resource filtered by id_post.
     *
     * @param  int  $id_post
     * @return \Illuminate\Http\Response
     */
    public function getCommentsByPost($post_id)
    {
        $comments = Comment::where('post_id', $post_id)
            ->orderBy('updated_at', 'ASC')
            ->paginate(3);

        return response()->json($comments);

    }
}