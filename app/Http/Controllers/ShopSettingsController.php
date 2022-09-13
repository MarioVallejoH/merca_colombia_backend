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

        $biller_data = BillerDataController::getBillerData($shop_settings['biller']);
        $company_data = CompaniesController::getCompanyData($biller_data['biller_id']);

        $shop_settings['biller_data'] = $biller_data;
        $shop_settings['company_data'] = $company_data;

        return response()->json([
            'success'   => true,
            'message'   => 'Success!',
            'data'      => $shop_settings,
        ], 200);
          
      }
}
