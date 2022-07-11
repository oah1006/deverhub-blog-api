<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Catalog;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request) {
        $posts = Post::query();

        if ($request->filled('keywords')) {
            $q = $request->keywords;

            $posts->where(function($query) use ($q) {
                $query->where('title', 'like', '%' . $q . '%')
                    ->orWhere('description', 'like', '%' . $q . '%')
                    ->orWhere('content', 'like', '%' . $q . '%')
                    ->orWhere('author_id', 'like', '%' . $q . '%')
                    ->orWhere('catalog_id', 'like', '%' . $q . '%')
                    ->orWhere('published', 'like', '%' . $q . '%');
            });
        }

        if ($request->filled('author_id')) {
            $authorId = $request->author_id;

            $posts->where('author_id', $authorId);
        }

        if ($request->filled('catalog_id')) {
            $catalogId = $request->catalog_id;

            $posts->where('catalog_id', $catalogId);
        }

        if ($request->filled('lastest') == 1) {
            $posts->lastest();
        }


        $posts = $posts->paginate(10);

        return response()->json($posts);
    }

    public function getPostByCatalog($catalogId) {
        $posts = Post::where('catalog_id', $catalogId)->get();

        return response()->json($posts);
    }

    public function show($id) {
        $post = Post::findOrFail($id);

        return response()->json($post);
    }
}
