<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page with featured content.
     */
    public function index()
    {
        $latestPosts = Post::with(['user', 'category'])
            ->published()
            ->orderBy('published_at', 'desc')
            ->take(5)
            ->get();
            
        $popularPosts = Post::with(['user', 'category'])
            ->published()
            ->orderBy('view_count', 'desc')
            ->take(5)
            ->get();
            
        $categories = Category::withCount('posts')->orderBy('posts_count', 'desc')->take(10)->get();
        $tags = Tag::withCount('posts')->orderBy('posts_count', 'desc')->take(15)->get();
            
        return view('home', compact('latestPosts', 'popularPosts', 'categories', 'tags'));
    }
}
