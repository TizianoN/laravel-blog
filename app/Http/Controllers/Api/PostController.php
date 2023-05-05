<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::where('is_published', true)
            ->with('category', 'tags')
            ->orderBy('updated_at', 'DESC')
            ->paginate(6);

        foreach($posts as $post) {
            $post->image = $post->getImageUri();
        }
            
        return response()->json(compact('posts'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->with('category', 'tags')->first();
        if(!$post) return response(null, 404);

        $post->image = $post->getImageUri();

        return response()->json($post);
    }

    /**
     * Display the specified resource filtered by id_category.
     *
     * @param  int  $id_category
     * @return \Illuminate\Http\Response
     */
    public function getPostsByCategory($category_id)
    {
        $posts = Post::where('category_id', $category_id)
            ->where('is_published', true)
            ->with('category', 'tags', 'images')
            ->orderBy('updated_at', 'DESC')
            ->paginate(6);

        $category = Category::find($category_id);
            
        foreach($posts as $post) {
            $post->image = $post->getImageUri();
        }
            
        return response()->json(compact('posts', 'category'));
    }

}