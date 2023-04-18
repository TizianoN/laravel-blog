<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Post;
use App\Models\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort = (!empty($sort_request = $request->get('sort'))) ? $sort_request : "updated_at";
        $order = (!empty($order_request = $request->get('order'))) ? $order_request : "DESC";
        
        $posts = Post::orderBy($sort, $order)->paginate(10)->withQueryString();
        return view('admin.posts.index', compact('posts', 'sort', 'order'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $post = new Post;
        $categories = Category::orderBy('label')->get();
        return view('admin.posts.form', compact('post', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'text' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg',
            'is_published' => 'boolean',
            'category_id' => 'nullable|exists:categories,id'
        ],
        [
            'title.required' => 'Il titolo è obbligatorio',
            'title.string' => 'Il titolo deve essere una stringa',
            'title.max' => 'Il titolo può avere massimo 20 caratteri',
            'text.required' => 'Il contenuto è obbligatorio',
            'text.string' => 'Il contenuto deve essere una stringa',
            'image.image' => 'Il file caricato deve essere un\'immagine',
            'image.mimes' => 'Le estensioni accettate per l\'immagine sono jpg, png, jpeg',
            'category_id.exists' => 'L\'id della categoria non è valido',
        ]);

        $data = $request->all();
        
        if(Arr::exists($data, 'image')) {
           $path = Storage::put('uplodas/posts', $data['image']);
           $data['image'] = $path;
        }

        $post = new Post;
        $post->fill($data);
        $post->slug = Post::generateUniqueSlug($post->title);
        $post->save();

        return to_route('admin.posts.show', $post)
            ->with('message_content', "Post $post->id creato con successo");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::orderBy('label')->get();
        return view('admin.posts.form', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'text' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg',
            'is_published' => 'boolean',
            'category_id' => 'nullable|exists:categories,id'
        ],
        [
            'title.required' => 'Il titolo è obbligatorio',
            'title.string' => 'Il titolo deve essere una stringa',
            'title.max' => 'Il titolo può avere massimo 20 caratteri',
            'text.required' => 'Il contenuto è obbligatorio',
            'text.string' => 'Il contenuto deve essere una stringa',
            'image.image' => 'Il file caricato deve essere un\'immagine',
            'image.mimes' => 'Le estensioni accettate per l\'immagine sono jpg, png, jpeg',
            'category_id.exists' => 'L\'id della categoria non è valido',
        ]);

        $data = $request->all();
        $data["slug"] = Post::generateUniqueSlug($data["title"]);
        $data["is_published"] = $request->has("is_published") ? 1 : 0;
        
        if(Arr::exists($data, 'image')) {
            if($post->image) Storage::delete($post->image);
            $path = Storage::put('uplodas/posts', $data['image']);
            $data['image'] = $path;
        }
        
        $post->update($data);

        return to_route('admin.posts.show', $post)
            ->with('message_content', "Post $post->id modificato con successo");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $id_post = $post->id;
        
        $post->delete();
        
        return to_route('admin.posts.index')
            ->with('message_type', "danger")
            ->with('message_content', "Post $id_post spostato nel cestino");
    }

    /**
     * Display a listing of the trashed resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function trash(Request $request) {
        $sort = (!empty($sort_request = $request->get('sort'))) ? $sort_request : "updated_at";
        $order = (!empty($order_request = $request->get('order'))) ? $order_request : "DESC";
        
        $posts = Post::onlyTrashed()->orderBy($sort, $order)->paginate(10)->withQueryString();
        return view('admin.posts.trash', compact('posts', 'sort', 'order'));
    }

    /**
     * Force delete the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(Int $id)
    {
        $post = Post::where('id', $id)->onlyTrashed()->first();
                
        if($post->image) Storage::delete($post->image);
        $post->forceDelete();
        
        return to_route('admin.posts.trash')
            ->with('message_type', "danger")
            ->with('message_content', "Post $id eliminato definitivamente");
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function restore(Int $id)
    {
        $post = Post::where('id', $id)->onlyTrashed()->first();
        $post->restore();
        
        return to_route('admin.posts.index')
            ->with('message_content', "Post $id ripristinato");
    }
}