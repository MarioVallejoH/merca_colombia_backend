<?php

namespace App\Http\Controllers;

use App\Models\WishList;
use Illuminate\Http\Request;

use Validator;

class WishListController extends Controller
{
    
    /**
     * Adds a new favorite for user.
     * 
     * Given a product_id and a user_id, create a new row in
     * wishList.
     * 
     */
    public function addFavorite(Request $request){

        

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|int',
            'user_id' => 'required|int',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 400);
        }
     
        $data = $request->all();
        // remove request value from array
        unset($data['request']);

        try {
            $data = WishList::insert($data);
        $response = [
            'success' => true,
            'message' => 'Exito',
            
        ];
        } catch (\Throwable $th) {
            $response = [
                'success' => false,
                'error' => true,
                'message' => $th->getMessage()
            ];
        }

        return response()->json($response,200);

        

    }

    /**
     * Removes a new favorite for user.
     * 
     * Given a product_id and a user_id, remove a row in
     * wishList where product_id and user_id.
     * 
     */
    public function removeFavorite(Request $request){

        

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|int',
            'user_id' => 'required|int',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 400);
        }
     
        
        $operation = WishList::where("product_id",$request->product_id)
                            ->where("user_id",$request->user_id);
        try {
            $operation->delete();
            $response = [
                'success' => true,
                'message' => 'Exito'
            ];
        } catch (\Throwable $th) {
            $response = [
                'success' => false,
                'error' => true,
                'message' => $th->getMessage()
            ];
        }

        return response()->json($response,200);

        

    }
}
