<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index() {
        $catalogs = Catalog::get();

        return response()->json([
            'catalogs' => $catalogs
        ]);
    }
}
