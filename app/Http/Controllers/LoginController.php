<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use SendAPILogin;
use Cookie;
use Redirect;
class LoginController extends Controller
{
	private $app_url = "http://localhost:9091"; //default value
	private $api_stats_url = "http://localhost:8080"; //default value
    private $app_env = "dev"; //default value dev,beta,prod
	private $kadabra_url = "https://ris.kadabra.id"; //default value
    private $api_ris_url = "http://localhost:9090"; //default value
    private $protocol_web = "https";
    private $minute = 60;

    function __construct()
    { 

    	$this->app_url = Config::get('app.url'); 
    	$this->api_stats_url = Config::get('app.api_stats_url'); 
    	$this->api_ris_url = Config::get('app.api_ris_url'); 
    	$this->kadabra_url = Config::get('app.kadabra_url'); 
    	$this->app_env = Config::get('app.env');

    	$check_protocol = Config::get('app.url');
    	if(explode(":", $check_protocol)[0] == "https"){
    		$this->protocol_web = "https";
    	}else{
    		$this->protocol_web = "http";
    	}

    	$last_string = substr($this->api_ris_url, -1);
    	if($last_string != "/"){
    		$this->api_ris_url = $this->api_ris_url."/";
    	}
    }

    function login(){
    	$data['kadabra_url'] = $this->kadabra_url;
    	return view('login',$data);
    }

    function postLogin(Request $request){
    	$request->validate([
    		'email' => 'required',
    		'password' => 'required',  
    	]);

    	$username = $request->email;
    	$password = str_replace("'","",$request->password);

    	$data = array(
    		'username' => $username,
    		'password' => $password
    	);

    	$send = SendAPILogin::execute($this->api_ris_url."auth/login",json_encode($data));
    	$value = json_decode($send);
    	if($value->message == "success"){
    		$name = $value->data[0]->name;
    		$username = $value->data[0]->username;
    		$token = $value->data[0]->token;

    		Cookie::queue('name',$name,$this->minute);
    		Cookie::queue('username',$username,$this->minute);
    		Cookie::queue('token',$token,$this->minute);

    		return redirect()->route('dashboard');
    	}else{
    		Cookie::queue('message', "Username atau Password Salah, Silahkan Masukan kembali. Pesan ini akan hilang dalam 1 menit .....",1);
    		return Redirect::back();
    	}
    }

    function logout(){
    	Cookie::forget('name');
    	Cookie::forget('username');
    	Cookie::forget('token');
    	return redirect()->route('login');
    }

}