<?php

namespace App\Http\Controllers\Api;

use App\Models\Movie;
use Validator;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
    public function view_movies_reviews(Request $request){
        $movies = Movie::with(['reviews.user']) 
            ->get()
            ->map(function ($movie) {
                $averageRating = $movie->reviews->avg('rating'); // Calculate average rating

                return [
                    'id' => $movie->id,
                    'title' => $movie->title, 
                    'reviews' => $movie->reviews->map(function ($review) {
                        return [
                            'id' => $review->id,
                            'user' => [
                                'id' => $review->user->id,
                                'name' => $review->user->name, 
                            ],
                            'rating' => $review->rating,
                            'comment' => $review->comment,
                            'created_at' => $review->created_at,
                            'updated_at' => $review->updated_at,
                        ];
                    }),
                    'average_rating' => $averageRating,
                ];
            });

        return response()->json($movies);
    }   

    public function search_movies(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'query' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $query = $request->input('query');

        $movies = Movie::where('title', 'like', "%{$query}%")
            ->orWhere('genre', 'like', "%{$query}%") 
            ->get();

        return response()->json($movies);
    }

    public function post_review(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'movie_id' => 'required|numeric|exists:movies,id',
            'review' => 'required|string|max:255',
            'rating' => 'required|numeric|min:0|max:5'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $review = Review::create([
            'user_id' => $request->user()->id,
            'movie_id' => $request->input('movie_id'),
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment')
        ]);

        if($review){
            return response()->json([
                'Success' => 'comment added successfully'
            ]);
        }

    } 

    public function view_not_approved_reviews(){
        $reviews = Review::with(['user', 'movie'])->where('approved', 'N')->get();

        $formattedReviews = $reviews->map(function ($review) {
            return [
                'id' => $review->id,
                'user' => [
                    'id' => $review->user->id,
                    'name' => $review->user->name, 
                ],
                'movie' => [
                    'id' => $review->movie->id,
                    'title' => $review->movie->title,
                ],
                'rating' => $review->rating,
                'comment' => $review->comment,
                'created_at' => $review->created_at,
                'updated_at' => $review->updated_at,
            ];
        });
    
        return response()->json($formattedReviews);

    }

    public function approve_review(Request $request){
        $validator = Validator::make($request->all(), [
            'review_id' => 'required|numeric|exists:reviews,id',
            'approved' => 'required|in:Y,N'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $review = Review::find($request->review_id);

        $review->approved = $request->approved;
        

        if($review->save()){
            return response()->json(["message" => "Review status updated sucessfully.", "review" => $review]);
        }
        else{
            return response()->json(['message' => 'falied to update review status']);
        }
        
    }

}
