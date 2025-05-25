<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        // Get posts with author relationship
        $posts = collect([
            [
                'id' => 1,
                'title' => 'Getting Started with Laravel 12',
                'author' => 'John Doe',
                'date' => 'Feb 15, 2023',
                'sends' => 1250,
                'opens' => 68,
                'status' => 'Published'
            ],
            [
                'id' => 2,
                'title' => 'Mastering Tailwind CSS 4',
                'author' => 'Jane Smith',
                'date' => 'Mar 22, 2023',
                'sends' => 984,
                'opens' => 75,
                'status' => 'Published'
            ],
            [
                'id' => 3,
                'title' => 'Building Modern Blog Systems',
                'author' => 'Mike Johnson',
                'date' => 'Apr 5, 2023',
                'sends' => 0,
                'opens' => 0,
                'status' => 'Draft'
            ],
            [
                'id' => 4,
                'title' => 'Advanced Authentication Techniques',
                'author' => 'John Doe',
                'date' => 'Apr 18, 2023',
                'sends' => 0,
                'opens' => 0,
                'status' => 'Draft'
            ],
            [
                'id' => 5,
                'title' => 'Optimizing Database Performance',
                'author' => 'Sarah Williams',
                'date' => 'May 10, 2023',
                'sends' => 1587,
                'opens' => 82,
                'status' => 'Published'
            ],
            [
                'id' => 6,
                'title' => 'Implementing Real-time Features with WebSockets',
                'author' => 'Mike Johnson',
                'date' => 'May 25, 2023',
                'sends' => 763,
                'opens' => 59,
                'status' => 'Published'
            ],
            [
                'id' => 7,
                'title' => 'Creating Custom Laravel Packages',
                'author' => 'Jane Smith',
                'date' => 'Jun 3, 2023',
                'sends' => 0,
                'opens' => 0,
                'status' => 'Scheduled'
            ],
            [
                'id' => 8,
                'title' => 'Advanced Filtering Techniques in Laravel',
                'author' => 'John Doe',
                'date' => 'Jun 12, 2023',
                'sends' => 0,
                'opens' => 0,
                'status' => 'Scheduled'
            ],
            [
                'id' => 9,
                'title' => 'Implementing Multi-Image Upload with Laravel',
                'author' => 'Sarah Williams',
                'date' => 'Jun 15, 2023',
                'sends' => 0,
                'opens' => 0,
                'status' => 'Draft'
            ],
            [
                'id' => 10,
                'title' => 'The Future of Web Development',
                'author' => 'Mike Johnson',
                'date' => 'Jun 28, 2023',
                'sends' => 0,
                'opens' => 0,
                'status' => 'Scheduled'
            ]
        ]);

        // Get all authors for filter
        $authors = collect([
            ['id' => 1, 'name' => 'John Doe'],
            ['id' => 2, 'name' => 'Jane Smith'],
            ['id' => 3, 'name' => 'Mike Johnson'],
            ['id' => 4, 'name' => 'Sarah Williams']
        ]);

        // Get all tags for filter
        $tags = collect([
            ['id' => 1, 'name' => 'Laravel'],
            ['id' => 2, 'name' => 'Tailwind'],
            ['id' => 3, 'name' => 'PHP'],
            ['id' => 4, 'name' => 'JavaScript'],
            ['id' => 5, 'name' => 'CSS'],
            ['id' => 6, 'name' => 'Database'],
            ['id' => 7, 'name' => 'API'],
            ['id' => 8, 'name' => 'Security']
        ]);

        return view('admin.dashboard', compact('posts', 'authors', 'tags'));
    }
} 