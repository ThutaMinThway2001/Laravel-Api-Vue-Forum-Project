<?php

namespace App\Trait;

use App\Models\Like;

trait Post
{
    public function getLikeDetail($post_id)
    {
        $like = Like::where('user_id', auth()->id())->where('post_id', $post_id)->first();
        if ($like) {
            $is_liked = 'true';
        } else {
            $is_liked = 'false';
        }
        $like_count = Like::where('post_id', $post_id)->count();
        $data['is_liked'] = $is_liked;
        $data['like_count'] = $like_count;
        return $data;
    }
}
