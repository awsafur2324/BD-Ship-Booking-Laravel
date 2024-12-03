<?php
namespace App\Helper;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWT_token{
    public static function CreateToken($userEmail,$userID):string{
        $key =env('JWT_KEY');
        $payload=[
            'iss'=>'bd-ship-ticket',
            'iat'=>time(),
            'exp'=>time()+60*60*24*30, // 30 days for token expiration in server
            'userEmail'=>$userEmail,
            'userID'=>$userID
        ];
       return JWT::encode($payload,$key,'HS256');
    }
    public static function ForgetPasswordToken($userEmail):string{
        $key =env('JWT_KEY');
        $payload=[
            'iss'=>'bd-ship-ticket',
            'iat'=>time(),
            'exp'=>time()+60*20, //  20 minute for token expiration in server
            'userEmail'=>$userEmail,
        ];
       return JWT::encode($payload,$key,'HS256');
    }

    public static function VerifyToken($token):string|object
    {
        try {
            if($token==null){
                return 'unauthorized';
            }
            else{
                $key =env('JWT_KEY');
                $decode=JWT::decode($token,new Key($key,'HS256'));
                return $decode;
            }
        }
        catch (Exception $e){
            return 'unauthorized';
        }
    }
}
?>