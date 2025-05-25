<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\FilterPreset;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 'admin',
        ]);

        // Create regular user
        $regularUser = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Create more users
        User::factory(8)->create();

        // Create categories
        $categories = [
            'Technology' => 'Latest tech news and updates',
            'Travel' => 'Explore the world through our travel guides',
            'Food' => 'Delicious recipes and food inspiration',
            'Health' => 'Tips for a healthy lifestyle',
            'Business' => 'Business insights and entrepreneurship',
            'Science' => 'Discoveries and scientific breakthroughs',
        ];

        $categoryModels = [];
        foreach ($categories as $name => $description) {
            $categoryModels[] = Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => $description,
            ]);
        }

        // Create tags
        $tags = [
            'Laravel', 'PHP', 'JavaScript', 'CSS', 'HTML', 'Tailwind',
            'Vue.js', 'React', 'Alpine.js', 'Node.js', 'API', 'Database',
            'MongoDB', 'MySQL', 'PostgreSQL', 'DevOps', 'Docker', 'Cloud',
            'AWS', 'Azure', 'Google Cloud', 'Security', 'Performance', 'SEO',
        ];

        $tagModels = [];
        foreach ($tags as $name) {
            $tagModels[] = Tag::create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        }

        // Create posts
        $users = User::all();
        $totalUsers = $users->count();
        
        for ($i = 0; $i < 30; $i++) {
            $title = "Sample Post " . ($i + 1);
            $category = $categoryModels[array_rand($categoryModels)];
            $user = $users[rand(0, $totalUsers - 1)];
            
            $post = Post::create([
                'user_id' => $user->id,
                'category_id' => $category->id,
                'title' => $title,
                'slug' => Str::slug($title),
                'excerpt' => 'This is a sample excerpt for the post. It gives a brief overview of what the post is about.',
                'content' => $this->generateSampleContent(),
                'is_published' => true,
                'published_at' => now()->subDays(rand(1, 30)),
                'view_count' => rand(5, 1000),
            ]);
            
            // Attach random tags to post
            $randomTags = array_rand(array_flip(range(0, count($tagModels) - 1)), rand(2, 5));
            foreach ($randomTags as $tagIndex) {
                $post->tags()->attach($tagModels[$tagIndex]);
            }
            
            // Add comments to post
            $commentCount = rand(0, 10);
            for ($j = 0; $j < $commentCount; $j++) {
                $commentUser = $users[rand(0, $totalUsers - 1)];
                
                Comment::create([
                    'user_id' => $commentUser->id,
                    'post_id' => $post->id,
                    'content' => 'This is a sample comment on this post. ' . Str::random(50),
                    'is_approved' => true,
                ]);
            }
        }
        
        // Create filter presets for users
        FilterPreset::create([
            'user_id' => $adminUser->id,
            'name' => 'Tech Articles',
            'categories' => ['technology'],
            'tags' => ['laravel', 'php', 'javascript'],
            'sort_by' => ['field' => 'latest'],
        ]);
        
        FilterPreset::create([
            'user_id' => $regularUser->id,
            'name' => 'My Reading List',
            'categories' => ['health', 'food'],
            'tags' => [],
            'sort_by' => ['field' => 'latest'],
        ]);
    }
    
    /**
     * Generate sample content for blog posts.
     */
    private function generateSampleContent(): string
    {
        $paragraphs = [
            "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",

            "Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",

            "Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.",

            "Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit.",

            "At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga.",
        ];
        
        $content = "<h2>Introduction</h2>\n";
        $content .= "<p>{$paragraphs[0]}</p>\n\n";
        $content .= "<h3>Main Section</h3>\n";
        $content .= "<p>{$paragraphs[1]}</p>\n\n";
        $content .= "<p>{$paragraphs[2]}</p>\n\n";
        
        $content .= "<h3>Another Section</h3>\n";
        $content .= "<ul>\n<li>First item in the list</li>\n<li>Second important point</li>\n<li>Third element to consider</li>\n</ul>\n\n";
        
        $content .= "<p>{$paragraphs[3]}</p>\n\n";
        $content .= "<blockquote>{$paragraphs[4]}</blockquote>\n\n";
        $content .= "<h3>Conclusion</h3>\n";
        $content .= "<p>In conclusion, this is a sample blog post content that demonstrates various HTML elements that might be used in a typical blog post.</p>";
        
        return $content;
    }
}
