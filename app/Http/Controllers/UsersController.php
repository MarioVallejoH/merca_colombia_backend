<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use Validator;

use App\Models\User;



class UsersController extends Controller
{
    public function verifyUserData(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|unique:sma_users',
            'phone' => 'required|integer|unique:sma_users',
            'username' => 'required|string|unique:sma_users',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                "data"=>$validator->errors(),
            ], 200);
        }

        
          
        $response = [
            'success'   => true,
            'message'   => 'Success',
            // 'sql'      => $products->toSql()
        ];
        
        return response()->json($response, 200);
    }

    /**
     * Create user, return user id
     *
     * @return integer
     */
    static public function createUser(array $user_data)
    {
        try {
            // default and override
            $user["main_administrator"]=0;
            $user["email_verified_at"]=null;


            $user = User::create($user_data);
            return $user->id??0;

        } catch (\Throwable $th) {
            throw $th;
            return 0;
        }
    }
}
