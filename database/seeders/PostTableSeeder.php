<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;

class PostTableSeeder extends Seeder
{
    public function run()
    {
        // Get all users and categories
        $users = User::all();
        $categories = Category::all();

        // Define sizes
        $sizes = ['S', 'M', 'L', 'XL', 'XXL'];

        // Define statuses
        $statuses = ['pending', 'success', 'cancel'];

        // Create 100 sample posts
        for ($i = 0; $i < 100; $i++) {
            Post::create([
                'title' => 'Post ' . $i,
                'content' => 'This is content for post ' . $i,
                'image' => 'https://via.placeholder.com/150', // You can replace it with your own image url
                'user_id' => $users->random()->id, // Get random user id
                'category_id' => $categories->random()->id, // Get random category id
                'price' => rand(1, 1000), // Random price between 1 and 1000
                'gender' => rand(0, 1) ? 'male' : 'female', // Random gender
                'note' => 'This is a note for post ' . $i,
                'quantity' => rand(1, 100), // Random quantity between 1 and 100
                'material' => 'Material ' . $i,
                'size' => $sizes[array_rand($sizes)], // Random size
                'status' => $statuses[array_rand($statuses)], // Random status
            ]);
        }
    }
}
