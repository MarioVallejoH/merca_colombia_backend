<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password','ip_address','group_id','first_name','last_name',"phone","company_id", "gender", "active", 'view_right'
    ];

    protected $table = 'sma_users';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','jwt_key','host_url','company_folder','db_name'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Default values of sma_users
     *
     * @var array
     */
    protected $attributes = [ 
        'created_on' => '0',
        'user_pc_serial'=>''
    ];

    /**
     * Validate the password of the user for the Passport password grant.
     *
     * @param  string  $password
     * @return bool
     */
    public function validateForPassportPasswordGrant($password)
    {   
        $decoded_pwd = $this->decrypt($password);
        $hashed_pw = $this->getPasswordHash($decoded_pwd,$this->password);
        return $hashed_pw==$this->password;
    }

    /**
      * Function to decrypt  codified password sended on user login and registration
      *
      * @param String $pass
      * @return String
      */
      private static function decrypt(String $pass)
      {
          $encodedKey = env('PASSWORD_KEY');
          $encodedIv = env('PASSWORD_IV');
          $key = base64_decode($encodedKey);
          // $iv = base64_decode($encodedIv);
          $iv = $encodedIv;
  
          $method = 'aes-256-cbc';
          $decrypted = openssl_decrypt($pass, $method, $key, 0, $iv);
          // echo $decrypted;
  
          return $decrypted;
      }
  
      /**
       * Get hashed password for user authentication
       *
       * @param String $password
       * @param String $db_password
       * @return String
       */
      private function getPasswordHash($password, $db_password)
      {
  
          $salt_length = 10;
          // get salt from hashed_password in db
          $salt = substr($db_password, 0, $salt_length);
  
          //with we generate password to compare against db password
          $hashed_password = $salt . substr(sha1($salt . $password), 0, -$salt_length);
  
         //  echo $hashed_password, ' --- ', $password, '------ ', $salt;
          return $hashed_password;
  
      }

      /**
       * Verify if user exist in db.
       *
       * Verify if user exist in db with its unsername, email or phone.
       *
       **/
      public function findForPassport($identifier)
      {
        
        return $this->orWhere("email",$identifier)
                    ->orWhere("username",$identifier)
                    ->orWhere("phone",$identifier)
                    ->first();
      }
     
}
