<?php
namespace App\Helpers;
use Session;

class SendAPILogin {

	public static function execute($url = Null,$data = Null){
		$ch = curl_init();
		$token = session('token');

		curl_setopt($ch, CURLOPT_URL,$url);

		if($data != null){
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$data);

			if (!empty($token)) {
				curl_setopt($ch, CURLOPT_HTTPHEADER,array('Authorization: Token '.$token,'Content-Type: application/json; charset=UTF-8'));
			}else{
				curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: application/json; charset=UTF-8'));
			}
		}

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$server_output = curl_exec($ch);

		curl_close ($ch);

		return $server_output;
	}
}
