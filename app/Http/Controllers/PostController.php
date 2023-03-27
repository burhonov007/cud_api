<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator ;

//use Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $post = Post::all();
        return response()->json([
            "success" => true,
            "message" => "Posts List",
            "data" => $post
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|string'
        ]);
        if ($validator->fails()) {
            return $this->sendErrors('Validation Error.', $validator->errors());
        }
        $post = Post::create($input);
        return response()->json([
            "success" => true,
            "message" => "Post created successfully.",
            "data" => $post
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $post = Post::find($id);
        if (is_null($post)) {
            return response()->json(['error' => 'Post not found']);
        }
        return response()->json([
            "success" => true,
            "message" => "Post retrieved successfully.",
            "data" => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Post $post)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|string',
            'likes' => ''
        ]);

        if ($validator->fails()) {
            return response()->json([
                'Validation Error.' => $validator->errors()
            ]);
        }

        $post->title = $input['title'];
        $post->description = $input['description'];
        $post->image = $input['image'];
        $post->likes = $input['likes'];
        $post->save();
        return response()->json([
            "success" => true,
            "message" => "Post updated successfully.",
            "data" => $post
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Post $post)
    {
        if (is_null($post)) {
            return response()->json(['error' => 'Post not found ']);
        }
        $post->delete();
        return response()->json([
            "success" => true,
            "message" => "Post deleted successfully.",
            "deleted post data" => $post
        ]);
    }
}
