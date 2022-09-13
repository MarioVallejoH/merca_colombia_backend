<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use App\Models\User as ModelsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\RefreshTokenRepository;
use Validator;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class AuthController extends Controller
{
  /**
   * Get user data.
   *
   * Returns user data given user email, phone or username.
   *
   * @param var $uname User email, username or phone.
   * @return array
   **/
  static public function getUserDataWEmailPhoneOrUName($uname)
  {
    $user = ModelsUser::orWhere("email", $uname)
      ->orWhere("username", $uname)
      ->orWhere("phone", $uname);

    return $user->first();
  }



  /**
   * Function used to perform user login, retuns tokens for access and for refressh access token
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function login(Request $request)
  {
    $client = new Client();
    // print_r($request->all());
    try {
      $request_data = $request->all();
      // to warantee that is a password grant_type
      $request_data['grant_type'] = 'password';
      $response = $client->request("POST", env('APP_URL') . '/oauth/token', ['json' => $request_data]);
      $t = json_decode($response->getBody(), true);
      $user = $this->getUserDataWEmailPhoneOrUName($request_data['username']);

      $user_company_data = Companies::where('id', $user->company_id)->first();

      $res = [
        'error' => false,
        'success' => true,
        'tokens_data' => $t,
        'user_data' => $user,
        'user_company_data' => $user_company_data
      ];

      return response()->json($res);
    } catch (RequestException $e) {
      // To catch exactly error 400 use 
      if ($e->hasResponse()) {
        if ($e->getResponse()->getStatusCode() == '400') {
          $res = json_decode($e->getResponse()->getBody(), true);
          $res['success'] = false;
          return response()->json($res, 401);
        }
      } else {
        response()->json(['error' => true], 401);
      }

      // You can check for whatever error status code you need 

    } catch (\Exception $e) {

      return response()->json(['error' => true, 'success' => false, "error_message" => $e->getMessage()], 401);
    }
  }

  /**
   * Function used to perform user login, retuns tokens for access and for refressh access token
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function refreshToken(Request $request)
  {
    $client = new Client();
    // print_r($request->all());
    try {
      $request_data = $request->all();
      // to warantee that is a refresh_token grant_type
      $request_data['grant_type'] = 'refresh_token';
      $response = $client->request("POST", env('APP_URL') . '/oauth/token', ['json' => $request_data]);
      $res = json_decode($response->getBody(), true);

      $res['error'] = false;
      $res['success'] = true;

      return response()->json($res);
    } catch (RequestException $e) {

      // To catch exactly error 400 use 
      if ($e->hasResponse()) {
        if ($e->getResponse()->getStatusCode() == '400') {
          $res = json_decode($e->getResponse()->getBody(), true);
          $res['success'] = false;
          return response()->json($res, 401);
        } else {
          return response()->json(['success' => false, "error" => true], $e->getResponse()->getStatusCode());
        }
      } else {
        return response()->json(['error' => true], 500);
      }

      // You can check for whatever error status code you need 

    } catch (\Exception $e) {

      return response()->json(
        [
          'error' => true,
          'success' => false,
          "error_message" => $e->getMessage()
        ],
        500
      );
    }
  }



  /**
   * Register api.
   *
   * @return \Illuminate\Http\Response
   */
  public function register(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'user_data' => 'required',
      "create_address" => "nullable|boolean",
      'company_data' => 'required',
    ]);
    if ($validator->fails()) {
      return response()->json([
        'success' => false,
        'message' => $validator->errors(),
      ], 401);
    }
    $company_data = $request->company_data;
    // THIS LINE MAKE ALL COMPANYS CREATED USING THIS METHOD TO BE CUSTOMERS
    // if(empty($address_data['group_id']??"")){
    $cgroupData =  GroupsController::getCustomerGroupData();

    $company_data['group_id'] = $cgroupData['id'];
    $company_data['group_name'] =  $cgroupData['name'];
    // print_r( $company_data);

    // }

    if (empty($company_data['customer_group_id'] ?? "")) {
      $def_c_group = CustomerGroupsController::defaultCustomerGroup();
      $company_data['customer_group_id'] = $def_c_group->id;
      $company_data['customer_group_name'] = $def_c_group->name;
    }
    if (!empty($request->image ?? [])) {
      $fileName = uniqid();
      $fileN = ImagesController::base64_to_selected_format($request->image, $fileName);
      $company_data['customer_profile_photo'] = $fileN;
    }
    $company_id = CompaniesController::createCompany($company_data, $request->create_address ?? true);
    // get ip from request
    if ($company_id != 0) {


      if (!empty($request->user_data ?? [])) {
        $user_data = $request->user_data;
        $user_data['ip_address'] = $request->ip();
        $user_data['company_id'] = $company_id;
        $user_data['group_id'] =  $company_data['group_id'];


        $user_data['password'] = $this->hashPassword($user_data['password']);
        $user_id = UsersController::createUser($user_data);

        if ($user_id != 0) {
          return response()->json([
            'success' => true,
            "error" => false,
            "message" => "Exito al crear usuario"
          ], 201);
        }
      } else {
        return response()->json([
          'success' => true,
          "error" => false,
          "message" => "Exito al registrar datos de usuario y sucursal de usuario"
        ], 201);
      }
    }
    return response()->json([
      'success' => false,
      "error" => true,
      "message" => "Error al crear company"
    ], 401);
  }

  /**
   * Register api.
   *
   * @return \Illuminate\Http\Response
   */
  public function getUserData(Request $request)
  {
    $user_data = $request->user();
    try {
      $user_company_data = Companies::where('id', $user_data->company_id)->first();
    } catch (\Throwable $th) {
      // if there is no company data to this, return error
      //throw $th;
      response()->json(
        [
          'succes' => false,
          'error' => true,
          'message' => 'Error al obtener datos de usuario'
        ],
        401
      );
    }


    return response()->json(
      [
        'success' => true,
        'message' => 'Success!',
        'user_data' => $user_data,
        'user_company_data' => $user_company_data ?? null
      ]
    );
  }

  public function logout(Request $res)
  {



    if (Auth::user()) {
      $tokenRepository = app(TokenRepository::class);
      $refreshTokenRepository = app(RefreshTokenRepository::class);
      $token = Auth::user()->token();
      // Revoke an access token...
      try {
        $tokenRepository->revokeAccessToken($token->id);

        // Revoke all of the token's refresh tokens...
        $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($token->id);
        return response()->json([
          'success' => true,
          'message' => 'Logout successfully'
        ]);
      } catch (\Throwable $th) {
        return response()->json([
          'success' => false,
          'message' => $th
        ]);
      }
      // $user = Auth::user()->token();
      // $user->revoke();

      return response()->json([
        'success' => true,
        'message' => 'Logout successfully'
      ]);
    } else {
      return response()->json([
        'success' => false,
        'message' => 'Unable to Logout'
      ]);
    }
  }



  /**
   *    Return hashed password string
   *    @return String
   */
  private static function hashPassword(String $password)
  {

    $salt_length = 10;
    //salt to gen password
    // print_r($password);
    $random_hex = substr(md5(uniqid(rand(), true)), 0, $salt_length);
    // get salt from random hashed_password
    $salt = substr($random_hex, 0, $salt_length);

    //pasword hash generated using wappsi method
    $hashed_password = $salt . substr(sha1($salt . $password), 0, -$salt_length);

    // echo $hashed_password, ' --- ', $password, '------ ', $salt;
    return $hashed_password;
  }
}
