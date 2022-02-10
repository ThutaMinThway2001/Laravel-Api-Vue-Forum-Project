<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Carbon\Carbon as CarbonCarbon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Trait\Post as PostTrait;

class PostApiController extends Controller
{
    use PostTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest();

        $posts->when(request('search'), function ($query) {
            $query->where('title', 'like', '%' . request('search') . '%')
                ->orWhere('detail', 'like', '%' . request('search') . '%');
        })->get();

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $posts->get(),

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $attributes = $request->validated();
        $attributes['user_id'] = auth()->id();

        $post = Post::create($attributes);

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $post
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return response()->json([
            'success' => 200,
            'data' => $post,
            'message' => 'success',
            'randomPost' => Post::inRandomOrder()->first()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        $attributes = $request->validated();
        $updatePost = $post->update($attributes);

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $updatePost
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json([
            'status' => 200,
            'message' => 'success',
        ]);
    }
}
