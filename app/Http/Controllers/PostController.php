<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Catalog;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        $posts = Post::all();

        return response()->json([
            'posts' => $posts,
        ]);
    }

    public function getPostByCatalog($catalogId) {
        $posts = Post::where('catalog_id', $catalogId)->get();

        return response()->json($posts);
    }

    public function show($id) {
        $post = Post::findOrFail($id);

        return response()->json($post);
    }

    public function lastest() {
        $lastest = Post::latest()->get();

        return response()->json($lastest);
    }
}
