<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::truncate();

        $faker = Faker::create();
        
        foreach(range(1,100) as $index){
            $post = Post::create([
                'title'   => $faker->sentence(),
                'user_id' => User::all()->random()->id,
                'created_at' => $faker->dateTime()
            ]);
        }
    }
}
