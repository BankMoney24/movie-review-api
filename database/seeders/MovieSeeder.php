<?php
namespace Database\Seeders;

use App\Models\Movie;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Movie::create([
            'title' => 'Inception',
            'description' => 'A skilled thief is given a chance at redemption if he can successfully perform inception.',
            'thumbnail' => 'path/to/inception.jpg',
            'release_date' => '2010-07-16',
            'genre' => 'Sci-Fi',  // Ensure this is valid according to your schema
            'average_rating' => 8.8,
        ]);

        Movie::create([
            'title' => 'The Godfather',
            'description' => 'An organized crime dynasty\'s aging patriarch transfers control of his clandestine empire to his reluctant son.',
            'thumbnail' => 'path/to/godfather.jpg',
            'release_date' => '1972-03-24',
            'genre' => 'Drama',    // Ensure this is valid according to your schema
            'average_rating' => 9.2,
        ]);

        // Add more movies as needed
    }
}
