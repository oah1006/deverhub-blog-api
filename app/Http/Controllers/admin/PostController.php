<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreatePostRequest;
use App\Http\Requests\Admin\UpdatePostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
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

        $posts = $posts->paginate(10);

        return response()->json($posts);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostRequest $request)
    {
        $data = $request->validated();


        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails');
            
        }

        return Post::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Post::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, $id)
    {
        DB::enableQueryLog();
        
        $post = Post::findOrFail($id);
        dump($request->validated());
        $post->update($request->validated());
        
        $post->fresh();

        dd(DB::getQueryLog());

        return response()->json([
            'post' => $post
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Post::findOrFail($id)->delete();
    }
}
