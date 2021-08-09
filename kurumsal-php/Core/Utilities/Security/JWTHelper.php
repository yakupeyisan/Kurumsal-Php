<?php 
namespace Core\Utilities\Security;

use Firebase\JWT\JWT;

class JWTHelper
{
    public static function createAccessToken($user,$claims)
    {
		$key = $_ENV['JWT.key'];
        $iat = time(); 
        $nbf = $iat+$_ENV['JWT.notBefore'];
        $exp = $iat + ($_ENV['JWT.timeout']*60);
        $data = [
			"name"=>$user->Name,
			"surname"=>$user->Surname,
			"claims"=>$claims
        ];
        $payload = array(
            "iss" => $_ENV['JWT.issuer'],
            "aud" => $_ENV['JWT.audience'],
            "iat" => $iat,
            "nbf" => $nbf,
            "exp" => $exp,
            "data" => $data
        );
        $token=JWT::encode($payload, $key,$_ENV['JWT.cryptography']);
        return $token;
    }
    public static function encodeAccessToken()
    {
		$key = $_ENV['JWT.key'];
		$authHeader = getallheaders();
		if(!isset($authHeader['Authorization'])){
			header('Content-Type: application/json');
			echo "{\n    \"status\": false,\n    \"message\": \"Access not denied.\"\n}";
			exit;
		}
		$token = $authHeader['Authorization'];
		try {
			$decoded = JWT::decode($token, $key, array("HS512"));
			if($decoded){
				return $decoded->data;
			}
		} catch (\Exception $e) {
			header('Content-Type: application/json');
			echo "{\n    \"status\": false,\n    \"message\": \"Expired token\"\n}";
			exit;
		}
    }
}
