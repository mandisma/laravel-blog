<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::factory(15)
            ->withThumbnail()
            ->for(User::factory()->state([
                'name' => 'Admin',
            ]), 'author')
            ->has(
                Status::factory()->count(1)
            )
            ->create();
    }
}
