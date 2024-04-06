<?php

namespace Database\Seeders;

use App\Models\Tweet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateLikesCountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tweets = Tweet::all();
        foreach ($tweets as $tweet) {
            $tweet->update([
                "likes_count" => $tweet->likes()->count()
            ]);
        }
    }
}
