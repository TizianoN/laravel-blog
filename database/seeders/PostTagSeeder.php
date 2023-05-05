<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;

use Faker\Generator as Faker;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $tags = Tag::all()->pluck('id')->toArray(); // [1, 2, ... 7]

        for($i = 1; $i < 40; $i++) {
            $post = Post::find($i);
            $post->tags()->attach($faker->randomElements($tags, random_int(0, 3)));
        }
    }
}