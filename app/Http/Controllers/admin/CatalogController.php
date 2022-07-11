<?php

namespace App\Http\Controllers\Admin;

use App\Models\Catalog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateCatalogRequest;
use App\Http\Requests\Admin\UpdateCatalogRequest;

class CatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $catalogs = Catalog::query();

        if ($request->filled('keywords')) {
            $q = $request->keywords;
            
            $catalogs->where(function ($query) use ($q) {
                $query->where('title', 'like', '%' . $q . '%')
                    ->orWhere('description', 'like', '%' . $q . '%')
                    ->orWhere('parent_id', 'like', '%' . $q . '%');
            });
        }

        if ($request->filled('parent_id')) {
            $parentId = $request->parent_id;
            $catalogs->where('parent_id', $parentId);
        }

        return $catalogs->paginate(10);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCatalogRequest $request)
    {
        return Catalog::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Catalog::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCatalogRequest $request, $id)
    {
        $catalog = Catalog::findOrFail($id);
        $catalog->update($request->all());
        $catalog->fresh();
        
        return response()->json([
            'catalog' => $catalog
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
        return Catalog::findOrFail($id)->delete();
    }
}
