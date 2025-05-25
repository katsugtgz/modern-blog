<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Comment::class);
        
        $comments = Comment::with(['user', 'post'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('admin.comments.index', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'content' => ['required', 'string'],
            'parent_id' => ['nullable', 'exists:comments,id'],
        ]);
        
        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'parent_id' => $validated['parent_id'],
            'content' => $validated['content'],
            'is_approved' => true, // Adjust this based on your moderation needs
        ]);
        
        return back()->with('success', 'Comment posted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);
        
        $validated = $request->validate([
            'content' => ['required', 'string'],
        ]);
        
        $comment->update([
            'content' => $validated['content'],
        ]);
        
        return back()->with('success', 'Comment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        
        $comment->delete();
        
        return back()->with('success', 'Comment deleted successfully.');
    }
    
    /**
     * Approve a comment.
     */
    public function approve(Comment $comment)
    {
        $this->authorize('update', $comment);
        
        $comment->update(['is_approved' => true]);
        
        return back()->with('success', 'Comment approved successfully.');
    }
    
    /**
     * Reject a comment.
     */
    public function reject(Comment $comment)
    {
        $this->authorize('update', $comment);
        
        $comment->update(['is_approved' => false]);
        
        return back()->with('success', 'Comment rejected successfully.');
    }
}
