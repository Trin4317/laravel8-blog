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
        // truncate the table before reseeding again to avoid duplicate
        User::truncate();
        Post::truncate();
        Category::truncate();

        $user = User::factory()->create();

        // temporarily create seed data without using Factory
        $personal = Category::create([
            'name' => 'Personal',
            'slug' => 'personal'
        ]);

        $work = Category::create([
            'name' => 'Work',
            'slug' => 'work'
        ]);

        $hobby = Category::create([
            'name' => 'Hobby',
            'slug' => 'hobby'
        ]);

        Post::create([
            'category_id'=> $work->id,
            'user_id'=> $user->id,
            'slug'=> "my-first-post",
            'title'=> "My First Post",
            'excerpt'=> "She wanted rainbow hair.",
            'body'=> "<p>She wanted rainbow hair. That's what she told the hairdresser. It should be deep rainbow colors, too. She wasn't interested in pastel rainbow hair. She wanted it deep and vibrant so there was no doubt that she had done this on purpose.</p>"
        ]);

        Post::create([
            'category_id'=> $personal->id,
            'user_id'=> $user->id,
            'slug'=> "my-second-post",
            'title'=> "My Second Post",
            'excerpt'=> "Terrance knew that sometimes it was simply best to stay out of it.",
            'body'=> "<p>Terrance knew that sometimes it was simply best to stay out of it. He kept repeating this to himself as he watched the scene unfold. He knew that nothing good would come of him getting involved. It was far better for him to stay on the sidelines and observe. He kept yelling this to himself inside his head as he walked over to the couple and punched the man in the face.</p>"
        ]);

        Post::create([
            'category_id'=> $hobby->id,
            'user_id'=> $user->id,
            'slug'=> "my-third-post",
            'title'=> "My Third Post",
            'excerpt'=> "They told her that this was her once chance to show the world what she was made of.",
            'body'=> "<p>They told her that this was her once chance to show the world what she was made of. She believed them at the time. It was the big stage and she knew the world would be there to see. The only one who had disagreed with this sentiment was her brother. He had told her that you don't show the world what you're made of when they are all watching, you show that in your actions when nobody was looking. It was looking more and more like her brother was correct.</p>"
        ]);
    }
}
