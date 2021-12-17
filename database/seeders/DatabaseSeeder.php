<?php

namespace Database\Seeders;

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
        $this->postSeeder();
        $this->commentSeeder();
    }

    public function postSeeder()
    {
        for($i=1; $i <= 10; $i++) {
            Post::factory()->create();
        }
    }

    public function commentSeeder()
    {
        for($i=1; $i <= 10; $i++) {
            Comment::factory()->create();
        }
    }
}
