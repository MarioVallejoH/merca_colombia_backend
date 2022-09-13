<?php

namespace App\Http\Controllers;

use App\Models\ShopSettings;
use Illuminate\Http\Request;

use Validator;


class ShopSettingsController extends Controller
{
      /**
      *  Get shop settings data.

      *    @return \Illuminate\Http\Response
      */
      public function getShopSettings(Request $request)
      {

      

        
        $shop_settings = ShopSettings::first();

        return response()->json([
            'success'   => true,
            'message'   => 'Success!',
            'data'      => $shop_settings,
        ], 200);
          
      }
}
