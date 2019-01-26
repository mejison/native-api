<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\PostImage;

class PostController extends Controller
{
    public function getAll(Request $request) {
        return response()->json(['data' => Post::get()->map(function($p) {
            return [
                'id' => $p->id,
                'user_id' => $p->user_id,
                'images' => $p->images,
                'description' => $p->description,
                'location' => $p->location,
                'created_at' => $p->created_at,
                'updated_at' => $p->updated_at,
            ];
        }), 'message' => "Succesfuly finded."]);
    }

    public function getOne(Post $post) {
        return response()->json(['data' =>  [
            'id' => $post->id,
            'user_id' => $post->user_id,
            'images' => $post->images,
            'description' => $post->description,
            'location' => $post->location,
            'created_at' => $post->created_at,
            'updated_at' => $post->updated_at,
        ],
        'message' => "Succesfuly finded."]);
    }

    public function create(Request $request, $user) {        
        $post = new Post;
        $post->user_id = $user;
        $post->description = $request->description;
        $post->location = [];
        $post->save();
                
        if ( ! empty($request->images)) {
            collect($request->images)->each(function($i) use (&$images, $post) {
                $filename = $i->getClientOriginalName();
                $filename = base_path() . uniqid() . $filename;
                $path = $i->move(storage_path('app/public'), $filename);
                $img = new PostImage;
                $img->post_id = $post->id;
                $img->path = $path;
                $img->save();                            
            });
        }

        $user = User::find($user)->first();
        $user->posts()->attach($post);

        return response()->json(['data' => $post, 'message' => "Succesfuly created."], 201);
    }

    public function getByUser($user) {
        $user = User::find($user)->first();
        return response()->json(['data' => $user->posts->map(function($p) {
            return [
                'id' => $p->id,
                'user_id' => $p->user_id,
                'images' => $p->images,
                'description' => $p->description,
                'location' => $p->location,
                'created_at' => $p->created_at,
                'updated_at' => $p->updated_at,
            ];
        }), 'message' => "Succesfuly finded."]);
    }
}