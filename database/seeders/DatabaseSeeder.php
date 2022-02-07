<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $thuta = User::factory()->create(['name' => 'thuta']);
        $n5 = Category::factory()->create(['name' => 'n5', 'slug' => 'n5']);
        Post::factory()->create(['user_id' => $thuta->id, 'category_id' => $n5->id]);
        Comment::factory()->create();
    }
}
