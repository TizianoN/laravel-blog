<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Category;

use Faker\Generator as Faker;

use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $categories = Category::all()->pluck('id')->toArray(); // [1, 2, ...]

        for($i = 0; $i < 100; $i++) {
            $category_id = (random_int(0, 3) >= 1) ? $faker->randomElement($categories) : null;

            $post = new Post;
            $post->category_id = $category_id;
            // $post->category_id = 1;
            $post->title = $faker->catchPhrase();
            $post->slug = Str::of($post->title)->slug('-');
            $post->text = $faker->paragraph(45);
            $post->is_published = random_int(0, 1);
            // $post->is_published = 0;
            $post->save();
        }
    }
}