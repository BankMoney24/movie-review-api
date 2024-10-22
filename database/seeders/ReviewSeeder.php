<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Movie;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all()->pluck('id');
        $movies = Movie::all()->pluck('id');

        foreach(range(1, 10) as $index){
            Review::create([
                'user_id' => $users->random(),
                'movie_id' => $movies->random(),
                'rating' => rand(1, 5),
                'comment' => 'This is a sample comment for review' . $index,
            ]);
        }
    }
}
