<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Returns selected data in sma_settings, $column field is a string who 
     * determines wich column to return
     *
     * @param string $column
     * @return string|int|null
     */
    static public function getSettingsColumnData($column)
    {

        $data = Settings::select($column)
            ->first();
        // print_r(data)
        return $data[$column];
    }
}
