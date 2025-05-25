<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Post::with(['user', 'category', 'tags'])
            ->published()
            ->orderBy('published_at', 'desc');
            
        // Apply filters
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->whereIn('slug', (array) $request->category);
            });
        }
        
        if ($request->filled('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->whereIn('slug', (array) $request->tag);
            });
        }
        
        if ($request->filled('author')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->whereIn('id', (array) $request->author);
            });
        }
        
        if ($request->filled('date_from')) {
            $query->where('published_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->where('published_at', '<=', $request->date_to);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }
        
        // Sort
        $sort = $request->sort ?? 'latest';
        switch ($sort) {
            case 'popular':
                $query->orderBy('view_count', 'desc');
                break;
            case 'oldest':
                $query->orderBy('published_at', 'asc');
                break;
            default:
                $query->orderBy('published_at', 'desc');
        }
        
        $posts = $query->paginate(10)->withQueryString();
        $categories = Category::all();
        $tags = Tag::withCount('posts')->orderBy('posts_count', 'desc')->take(20)->get();
        
        return view('posts.index', compact('posts', 'categories', 'tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Post::class);
        
        $categories = Category::all();
        $tags = Tag::all();
        
        return view('posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Post::class);
        
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:posts'],
            'category_id' => ['required', 'exists:categories,id'],
            'excerpt' => ['nullable', 'string'],
            'content' => ['required', 'string'],
            'featured_image' => ['nullable', 'image', 'max:2048'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['exists:tags,id'],
            'is_published' => ['boolean'],
            'published_at' => ['nullable', 'date'],
        ]);
        
        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }
        
        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')
                ->store('featured-images', 'public');
        }
        
        // Set published_at if post is published and date not provided
        if ($validated['is_published'] && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }
        
        // Create post
        $post = auth()->user()->posts()->create([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'category_id' => $validated['category_id'],
            'excerpt' => $validated['excerpt'],
            'content' => $validated['content'],
            'featured_image' => $validated['featured_image'] ?? null,
            'is_published' => $validated['is_published'],
            'published_at' => $validated['published_at'],
        ]);
        
        // Attach tags
        if (!empty($validated['tags'])) {
            $post->tags()->attach($validated['tags']);
        }
        
        return redirect()->route('posts.show', $post->slug)
            ->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        if (!$post->is_published && !auth()->check()) {
            abort(404);
        }
        
        $post->load(['user', 'category', 'tags', 'comments' => function ($query) {
            $query->approved()->with('user')->orderBy('created_at', 'desc');
        }]);
        
        $post->incrementViewCount();
        
        $relatedPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->where(function ($query) use ($post) {
                $query->where('category_id', $post->category_id)
                    ->orWhereHas('tags', function ($q) use ($post) {
                        $q->whereIn('tags.id', $post->tags->pluck('id'));
                    });
            })
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();
            
        return view('posts.show', compact('post', 'relatedPosts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        
        $categories = Category::all();
        $tags = Tag::all();
        
        return view('posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);
        
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('posts')->ignore($post->id)],
            'category_id' => ['required', 'exists:categories,id'],
            'excerpt' => ['nullable', 'string'],
            'content' => ['required', 'string'],
            'featured_image' => ['nullable', 'image', 'max:2048'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['exists:tags,id'],
            'is_published' => ['boolean'],
            'published_at' => ['nullable', 'date'],
        ]);
        
        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }
        
        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            
            $validated['featured_image'] = $request->file('featured_image')
                ->store('featured-images', 'public');
        }
        
        // Set published_at if post is being published for the first time
        if ($validated['is_published'] && !$post->is_published && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }
        
        // Update post
        $post->update([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'category_id' => $validated['category_id'],
            'excerpt' => $validated['excerpt'],
            'content' => $validated['content'],
            'featured_image' => $validated['featured_image'] ?? $post->featured_image,
            'is_published' => $validated['is_published'],
            'published_at' => $validated['published_at'],
        ]);
        
        // Sync tags
        $post->tags()->sync($validated['tags'] ?? []);
        
        return redirect()->route('posts.show', $post->slug)
            ->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        
        // Delete featured image
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }
        
        $post->delete();
        
        return redirect()->route('posts.index')
            ->with('success', 'Post deleted successfully.');
    }
}
