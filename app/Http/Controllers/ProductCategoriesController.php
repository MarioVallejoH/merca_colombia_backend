<?php

namespace App\Http\Controllers;

use App\Models\ProductCategories;
use Illuminate\Http\Request;

class ProductCategoriesController extends Controller
{
    public function getCategories()
    {


        $categories = ProductCategories::all();

        

        return response()->json([
            'success'   => true,
            'message'   => 'Success!',
            'data'      => $categories,
            // 'sql'      => $products->toSql()
        ], 200);
    }
}
