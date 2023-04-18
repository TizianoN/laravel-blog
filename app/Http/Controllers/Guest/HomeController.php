<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $recent_posts = Post::where('is_published', 1)->orderBy('updated_at', 'DESC')->limit(8)->get();
        return view('guest.home', compact('recent_posts'));
    }
}