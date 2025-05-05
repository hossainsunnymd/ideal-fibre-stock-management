<?php

namespace App\Helper;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken{

    //create token

    public static function createToken($userEmail):string{
        $key=env('JWT_KEY');
        $payload=[
            'iss'=>'laravel',
            'iat'=>time(),
            'exp'=>time()+60*60*24,
            'userEmail'=>$userEmail
        ];

        $encode=JWT::encode($payload,$key,'HS256');
        return $encode;
    }

    //verify token
    public static function verifyToken($token):object|string{
        if($token==null){
            return "Unauthorized";
        }
       try{
        $key=env('JWT_KEY');
        $decode=JWT::decode($_GET['token'],new Key($key,'HS256'));
        return $decode;
       }catch(Exception $e){
        return "Unauthorized";
       }
    }
}
