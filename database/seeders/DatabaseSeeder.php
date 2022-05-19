<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // instead of making new category everytime we make a new post
        // create a limited amount of categories first
        // then randomly pick one when we make a new post
        $categories = ['Work', 'Personal', 'Hobby'];
        foreach ($categories as $category) {
            Category::factory()->create([
                'name' => $category,
                'slug' => strtolower($category)
            ]);
        };

        // create 10 new posts whenever we seed the database
        Post::factory(10)->create();
        // and create 3 draft posts
        Post::factory(3)->create(['status' => 'DRAFT']);
    }
}
