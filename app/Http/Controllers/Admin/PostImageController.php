<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostImage;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPostImagesByPost(Post $post)
    {
        return view('admin.post-images.index', compact('post'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createPostImageByPost(Post $post)
    {
        $post_image = new PostImage();
        return view('admin.post-images.form', compact('post', 'post_image'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        
        $this->validation($data);

        if(Arr::exists($data, 'image')) {
           $path = Storage::put("uplodas/post-images/post-{$data['post_id']}", $data['image']);
           $data['image'] = $path;
        }

        $post_image = new PostImage;
        $post_image->fill($data);
        $post_image->save();

        return to_route('admin.post-images.by-post', $post_image->post);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PostImage  $postImage
     * @return \Illuminate\Http\Response
     */
    public function show(PostImage $postImage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PostImage  $postImage
     * @return \Illuminate\Http\Response
     */
    public function edit(PostImage $post_image)
    {
        $post = $post_image->post;
        return view('admin.post-images.form', compact('post', 'post_image'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PostImage  $postImage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PostImage $postImage)
    {
        $this->validation($request->all());
        
        $data = $request->all();

        if(Arr::exists($data, 'image')) {
            if($postImage->image) Storage::delete($postImage->image);
            $path = Storage::put('uplodas/posts', $data['image']);
            $data['image'] = $path;
        }

        $postImage->update($data);

        return to_route('admin.post-images.by-post', $postImage->post)
            ->with('message_content', "Immagine modificata con successo");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PostImage  $postImage
     * @return \Illuminate\Http\Response
     */
    public function destroy(PostImage $postImage)
    {
        
        if($postImage->image) Storage::delete($postImage->image);
        
        $postImage->delete();

        return redirect()
            ->back()
            ->with('message_type', "danger")
            ->with('message_content', "Post image eliminata");

    }
    
    /**
     * Delete the image of the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function deleteImage(PostImage $postImage)
    {
        if($postImage->image) Storage::delete($postImage->image);
        $postImage->image = null;
        $postImage->save();

        return redirect()
            ->back()
            ->with('message_type', "danger")
            ->with('message_content', "Immagine eliminata");
    }

    private function validation($data) {
        return Validator::make(
            $data,
            [
                'title' => 'required|string|max:100',
                'content' => 'required|string',
                'image' => 'nullable|image|mimes:jpg,png,jpeg',
            ],
            [
                'title.required' => 'Il titolo è obbligatorio',
                'title.string' => 'Il titolo deve essere una stringa',
                'title.max' => 'Il titolo può avere massimo 20 caratteri',
                'content.required' => 'Il contenuto è obbligatorio',
                'content.string' => 'Il contenuto deve essere una stringa',
                'image.image' => 'Il file caricato deve essere un\'immagine',
                'image.mimes' => 'Le estensioni accettate per l\'immagine sono jpg, png, jpeg',
            ]
        )->validate();
    }
}