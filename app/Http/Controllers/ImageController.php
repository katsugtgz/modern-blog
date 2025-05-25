<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as ImageIntervention;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Image::class);
        
        $query = Image::with('post');
        
        if ($request->filled('post_id')) {
            $query->where('post_id', $request->post_id);
        }
        
        $images = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('admin.images.index', compact('images'));
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
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => ['required', 'exists:posts,id'],
            'image' => ['required', 'image', 'max:5120'], // 5MB limit
            'alt_text' => ['nullable', 'string', 'max:255'],
            'caption' => ['nullable', 'string', 'max:255'],
        ]);
        
        // Authorize access to the post
        $post = Post::findOrFail($request->post_id);
        $this->authorize('update', $post);
        
        // Get the uploaded file
        $file = $request->file('image');
        $originalName = $file->getClientOriginalName();
        $mimeType = $file->getMimeType();
        $size = $file->getSize() / 1024; // Size in KB
        
        // Generate unique filename
        $fileName = time() . '_' . $originalName;
        
        // Get image dimensions
        $dimensions = getimagesize($file->getRealPath());
        $width = $dimensions[0];
        $height = $dimensions[1];
        
        // Store original image
        $path = $file->storeAs('post-images/' . $post->id, $fileName, 'public');
        
        // Create thumbnail directory if it doesn't exist
        $thumbnailDir = 'public/post-images/' . $post->id . '/thumbnails';
        if (!Storage::exists($thumbnailDir)) {
            Storage::makeDirectory($thumbnailDir);
        }
        
        // Create and save thumbnail
        $thumbnail = ImageIntervention::make($file->getRealPath())
            ->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->save(storage_path('app/' . $thumbnailDir . '/' . $fileName));
        
        // Get the highest sort order for this post
        $maxSortOrder = Image::where('post_id', $post->id)->max('sort_order') ?? -1;
        
        // Create image record
        $image = Image::create([
            'post_id' => $post->id,
            'path' => $path,
            'original_filename' => $originalName,
            'alt_text' => $request->alt_text,
            'caption' => $request->caption,
            'sort_order' => $maxSortOrder + 1,
            'mime_type' => $mimeType,
            'size_in_kb' => $size,
            'width' => $width,
            'height' => $height,
        ]);
        
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'image' => $image,
                'url' => $image->url,
                'thumbnail_url' => $image->thumbnail_url,
            ]);
        }
        
        return back()->with('success', 'Image uploaded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Image $image)
    {
        $this->authorize('view', $image);
        
        return view('admin.images.show', compact('image'));
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
    public function update(Request $request, Image $image)
    {
        $this->authorize('update', $image);
        
        $validated = $request->validate([
            'alt_text' => ['nullable', 'string', 'max:255'],
            'caption' => ['nullable', 'string', 'max:255'],
        ]);
        
        $image->update($validated);
        
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'image' => $image,
            ]);
        }
        
        return back()->with('success', 'Image updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {
        $this->authorize('delete', $image);
        
        // Delete image files
        Storage::disk('public')->delete($image->path);
        
        // Delete thumbnail
        $path_parts = pathinfo($image->path);
        $thumbnail_path = $path_parts['dirname'] . '/thumbnails/' . $path_parts['basename'];
        Storage::disk('public')->delete($thumbnail_path);
        
        // Delete database record
        $image->delete();
        
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
            ]);
        }
        
        return back()->with('success', 'Image deleted successfully.');
    }
    
    /**
     * Reorder images.
     */
    public function reorder(Request $request, Image $image)
    {
        $this->authorize('update', $image);
        
        $validated = $request->validate([
            'sort_order' => ['required', 'integer', 'min:0'],
        ]);
        
        $image->update([
            'sort_order' => $validated['sort_order'],
        ]);
        
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
            ]);
        }
        
        return back()->with('success', 'Image reordered successfully.');
    }
}
