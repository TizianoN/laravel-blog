<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
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
        for($i = 0; $i < 40; $i++) {
            $post = new Post;
            $post->title = $faker->catchPhrase();
            $post->slug = Str::of($post->title)->slug('-');
            // $post->image = $faker->imageUrl(640, 480, 'animals', true);
            $post->text = $faker->paragraph(45);
            $post->save();
        }
    }
}