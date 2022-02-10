<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeApiController extends Controller
{
    public function like()
    {
        $likeCheck = Like::where([
            'user_id' => auth()->id(),
            'post_id' => request('post_id')
        ])->first();

        if ($likeCheck) {
            Like::where([
                'user_id' => auth()->id(),
                'post_id' => request('post_id')
            ])->delete();
            return 'deleted';
        } else {
            $like = Like::create([
                'user_id' => auth()->id(),
                'post_id' => request('post_id')
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => $like
            ]);
        }
    }

    // public function isLike($user_id, $post_id)
    // {
    //     $like = Like::where('user_id', $user_id)->where('post_id', $post_id)->count();

    //     if ($like) {
    //         Like::where('user_id', $user_id)->where('post_id', $post_id)->delete();
    //         return 'delete';
    //     } else {
    //         return false;
    //     }
    // }
}
