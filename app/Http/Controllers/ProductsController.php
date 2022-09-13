<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\SalesItems;
use App\Models\WishList;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Validator;

class ProductsController extends Controller
{
    public function search(Request $request)
    {
        /**}
         * Validation
         * 
         * Nullable fields are optionmal, in the case of user_id is requiered when 
         * favorites is not null.
         */
        $validator = Validator::make($request->all(), [
            'page' => 'required|integer',
            'outstanding'=>'nullable|boolean',
            'promotion'=>'nullable|boolean',
            'categories'=>'nullable|array',
            'best_sellers'=>'nullable|boolean',
            'favorites'=>'required_with:user_id|nullable|boolean',
            'user_id,'=>'integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 400);
        }

        $query = ($request->text)??"";
        
        $products = Products::where('sma_products.name','LIKE',"%{$query}%")
                            ->where('discontinued','=','0')
                            ->where('hide_online_store','=','0')
                            ->limit($request->limit??10)
                            ->offset($request->page * $request->limit??10);
        
        // if(!empty($query)){
        //     $products->where('sma_products.name','LIKE',"%{$query}%");
        // }

        if ($request->outstanding??false) {
            $products->where('featured', 1);
        }

        if ($request->promotion??false) {
            $products->where('start_date', '<=', date('Y-m-d'))
                    ->where('end_date', '>=', date('Y-m-d'));
        }
        if ($request->categories??false) {
            $products->whereIn('category_id',$request->categories);
        }

        if ($request->best_sellers??false) {
            $best_sellers = SalesItems::select(DB::raw('product_id,COUNT(product_id) as count') )
                            ->groupBy('product_id');
            $products->joinSub($best_sellers,'best_sellers',function($join){
                $join->on("sma_products.id",'=',"best_sellers.product_id");
            })->orderByDesc('best_sellers.count');
        }else{
            $products->orderBy('name', 'asc');
        }
        if ($request->favorites??false) {
            $favorites = WishList::select('product_id')
                            ->where('user_id',$request->user_id);
            $products->joinSub($favorites,'favorites',function($join){
                $join->on("sma_products.id",'=',"favorites.product_id");
            });
            $products->distinct()->orderBy('name', 'asc');
        }

        return response()->json([
            'success'   => true,
            'message'   => 'Success!',
            'data'      => $products->get(),
            // 'sql'      => $products->toSql(),
            // 'bindings' => $products->getBindings()
        ], 200);
    }


    public function productDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 400);
        }

        $id = ($request->id)??"";

        $product = Products::where('id',$id)->first();


        return response()->json([
            'success'   => true,
            'message'   => 'Success!',
            'data'      => $product,
            // 'sql'      => $products->toSql(),
            // 'bindings' => $products->getBindings()
        ], 200);
    }
}

