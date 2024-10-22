<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    Use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'thumbnail',
        'release_date',
        'genre',
        'average_rating'
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

        // Relationship with genres
        public function genres()
        {
            return $this->belongsToMany(Genre::class); // Adjust according to your genre relationship
        }
    
}
