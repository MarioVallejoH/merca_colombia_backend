<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;


class CompaniesController extends Controller
{
    /**
     * Get company data given a company id.
     *
     * Given company_id param, return its data in sma_companies table.
     *
     * @param int $company_id company_id id from sma_companies
     * @return array
     **/
    static public function getCompanyData(int $company_id)
    {
        $company_data = Companies::where('id', $company_id)
            ->first();

        return $company_data;
    }


    /**
     * Create company, return its id
     *
     * @return integer
     */
    static public function createCompany(array $company_data, bool $create_address = false)
    {


        try {
            $company = Companies::create($company_data);

            if ($create_address) {
                $company_data["company_id"] = $company->id;
                $company_data["city"] = $company->city;
                $company_data["city_code"] = $company->city_code;
                $company_data["direccion"] = $company->address ?? "";
                $company_data["sucursal"] = $company->name;
                $company_data["state"] = $company->state;
                $company_data["country"] = $company->country;
                $company_data["phone"] = $company->phone;
                $company_data["email"] = $company->email;
                $company_data["code"] = ($company->vat_no ?? "") . " - 01";

                AddressesController::createaddress($company_data);
            }
            return $company->id ?? 0;
        } catch (\Throwable $th) {
            throw $th;
            return 0;
        }
    }

}
