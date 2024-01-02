<?php
namespace App\Helpers;
use Config;

class SendAPI {

	public static function execute($url = Null,$data = Null){
		$ch = curl_init();
		$username = Config::get('app.username_bauth');
		$password = Config::get('app.password_bauth');

		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: application/json; charset=UTF-8'));
		curl_setopt($ch, CURLOPT_USERPWD, $username.":".$password);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$server_output = curl_exec($ch);

		curl_close ($ch);

		return $server_output;
	}
}

