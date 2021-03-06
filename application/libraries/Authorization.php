<?php

use \Firebase\JWT\JWT;

/**
 * Authorization librarie
 * 
 * Use the JWT library to generate authentication tokens
 * 
 * for more information see https://github.com/firebase/php-jwt
 */
class Authorization
{
	/**
	 * Generate an authentication token
	 * 
	 * It receives as a parameter the data that you want to encrypt in the
	 * token, which could be, for example, the user's id
	 * 
	 * @param int|string	$data
	 * @return string		$token
	 */
	public static function generateToken($data){

		// gets the controller instance where it is being called
		$ci =& get_instance();

		// prepare payload
		$payload  = array(
			"iss" => base_url(),
			"aud" => base_url(),
			"exp" => $ci->config->item('expiration_time'),
			"iat" => strtotime("now"),
			"nbf" => strtotime("now"),
			"data" => $data
		);

		// generate and return token
		return JWT::encode($payload, $ci->config->item('jwt_key'));
	}

	/**
	 * Check the token sent in the header
	 * 
	 * Read the bearer token sent in the header, and check its status, in 
	 * case thetoken is invalid or has expired, it will return unauthorized
	 * 
	 * @return array|int|string
	 */
	public static function verifyToken(){
		// gets the controller instance where it is being called

		$ci =& get_instance();
		
		// read bearer token
		$token = str_replace("Bearer ", "", $ci->input->get_request_header("Authorization"));
		$data = array();

		// evaluate token status
		if(empty($token)){
			$data['hasError'] = TRUE;
			$data['message'] = "Unauthorized";
		}else{
			try{
				$data['data'] = JWT::decode($token, $ci->config->item('jwt_key'), array('HS256'))->data;
				$data['hasError'] = FALSE;
			}catch (\Firebase\JWT\BeforeValidException $e){
				$data['hasError'] = TRUE;
				$data['message'] = $e->getMessage();
			}catch (\Firebase\JWT\ExpiredException $e){
				$data['hasError'] = TRUE;
				$data['message'] = $e->getMessage();
			}catch (UnexpectedValueException $e){
				$data['hasError'] = TRUE;
				$data['message'] = $e->getMessage();
			}
		}
		

		// if the token is invalid we return unauthorized
		if($data['hasError']){
			$data['code'] = UNAUTHORIZED;
			$data['data'] = self::pack(UNAUTHORIZED, $data['message']);
		}

		// if the token is valid we return its data
		return $data;
	}

	/**
	 * formats the data to return a response in REST format
	 * 
	 * @param int 		$code,
	 * @param string 	$message
	 * 
	 * @return array
	 */
	private static function pack($code, $message){
		return array(
			"code" => $code,
			"message" => $message,
		);
	}
}
