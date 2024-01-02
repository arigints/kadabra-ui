<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use SendAPI;
use Cookie;
use Redirect;
class AdminController extends Controller
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
    	$this->middleware(function ($request, $next) {
	      if (!Cookie::get('token')) {
	        return redirect()->route('login');
	      }
	      return $next($request);
	    });

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
    // Start dashboard function

    function prefixHistory(){
    	$data = array();
       	$page = $_GET["page"];

       	if(!empty($_GET["find"]) && !empty($_GET["value"])){
    		$data['find'] = $_GET["find"];
    		$data['value'] = $_GET["value"];

    		$count_data = $this->getCountPrefixHistory($_GET["find"],$_GET["value"]);
    	}else{
    		$count_data = $this->getCountPrefixHistory('',''); // default ''
    	}

    	if(empty($page) || $page == 1){
    		$data['api_ris_url'] = $this->api_ris_url;
	    	$data['kadabra_url'] = $this->kadabra_url;
	    	$data['app_url'] = $this->app_url;
	    	$data['page'] = 1;
	    	$data['nextPage'] = 2;

	    	if(!empty($_GET["find"]) && !empty($_GET["value"])){
	    		$endRange = $count_data;
	    	}else{
	    		$endRange = "1,000";
	    	}

	    	$data['info_data_page'] = "Data from <span class='blue'>1</span> to <span class='blue'>".$endRange."</span> of all data (".$count_data.")";
	    	return view('admin.prefix_history',$data);
    	}else{
    		$range = number_format((($page*1000)-1000)+1,0,".",",");

    		if(!empty($_GET["find"]) && !empty($_GET["value"])){
	    		$endRange = $count_data;
	    	}else{
	    		$endRange = number_format((int)($page*1000),0,".",",");
	    	}
    		
    		$data['api_ris_url'] = $this->api_ris_url;
	    	$data['kadabra_url'] = $this->kadabra_url;
	    	$data['app_url'] = $this->app_url;
	    	$data['page'] = $page;
	    	$data['nextPage'] = $page+1;
	    	$data['prevPage'] = $page-1;
	    	$data['info_data_page'] = "Data from <span class='blue'>".$range."</span> to <span class='blue'>".$endRange."</span> of all data (".$count_data.")";
	    	return view('admin.prefix_history',$data);
    	}
    }

    function getPrefixHistory($page){
    	$real_offset = (($page*1000)-1000);
    	if(!Cookie::get('token')){
    		return json_encode(array('status' => false,'message' => 'not authorized'));
    	}else{
    		$request = SendAPI::execute($this->api_stats_url."/stats/prefix-history/data?limit=1000&offset=".$real_offset);
    		$decode = json_decode($request);

    		$result = array();
    		$no=1;
    		if($page >= 1){
    			$no=(($page*1000)-1000)+1;
    		}
    		foreach ($decode as $value) {
    			$row = array();

    			$as_path_string = "[".implode(",",$value->as_path)."]";
    			if(strlen($as_path_string) > 25){
    				$obj = '{prefix:"'.$value->prefix.'",origin_as:"'.$value->origin_as.'",rcc:"'.$value->rcc_alias.'",as_path:"'.$as_path_string.'",first_seen:"'.date('Y-m-d H:i:s',strtotime($value->first_seen))." (UTC)".'",last_seen:"'.date('Y-m-d H:i:s',strtotime($value->last_seen))." (UTC)".'"}';
    				$as_path = substr($as_path_string, 0,25)."... \n<a href='javascript:void(0)' onclick='showDetail(".$obj.");' class='btn-more'>More</a>";
    			}else{
    				$as_path = $as_path_string;
    			}

    			$row['no'] = number_format($no,0,".",",");
    			$row['prefix'] = $value->prefix;
    			$row['origin_as'] = $value->origin_as;
    			$row['rcc'] = $value->rcc_alias;
    			$row['as_path'] = $as_path;
    			$row['first_seen'] = date('Y-m-d H:i:s',strtotime($value->first_seen))." (UTC)";
    			$row['last_seen'] = date('Y-m-d H:i:s',strtotime($value->last_seen))." (UTC)";
    			$row['created_at'] = $value->created_at;
    			$row['updated_at'] = $value->updated_at;
    			
    			$no++;
    			$result[] = $row;
    		}

    		return json_encode($result);
    	}
    }

    function getPrefixHistoryCustom($page,$find,$value){
    	$real_offset = 0;
    	$value_decode = base64_decode($value);
    	if(!Cookie::get('token')){
    		return json_encode(array('status' => false,'message' => 'not authorized'));
    	}else{
    		$request = SendAPI::execute($this->api_stats_url."/stats/prefix-history/data?limit=1000&offset=".$real_offset."&field=".$find."&param=".$value_decode);
    		$decode = json_decode($request);

    		$result = array();
    		$no=1;
    		if($page >= 1){
    			$no=(($page*1000)-1000)+1;
    		}
    		foreach ($decode as $value) {
    			$row = array();

    			$as_path_string = "[".implode(",",$value->as_path)."]";
    			if(strlen($as_path_string) > 25){
    				$obj = '{prefix:"'.$value->prefix.'",origin_as:"'.$value->origin_as.'",rcc:"'.$value->rcc_alias.'",as_path:"'.$as_path_string.'",first_seen:"'.date('Y-m-d H:i:s',strtotime($value->first_seen))." (UTC)".'",last_seen:"'.date('Y-m-d H:i:s',strtotime($value->last_seen))." (UTC)".'"}';
    				$as_path = substr($as_path_string, 0,25)."... \n<a href='javascript:void(0)' onclick='showDetail(".$obj.");' class='btn-more'>More</a>";
    			}else{
    				$as_path = $as_path_string;
    			}

    			$row['no'] = number_format($no,0,".",",");
    			$row['prefix'] = $value->prefix;
    			$row['origin_as'] = $value->origin_as;
    			$row['rcc'] = $value->rcc_alias;
    			$row['as_path'] = $as_path;
    			$row['first_seen'] = date('Y-m-d H:i:s',strtotime($value->first_seen))." (UTC)";
    			$row['last_seen'] = date('Y-m-d H:i:s',strtotime($value->last_seen))." (UTC)";
    			$row['created_at'] = $value->created_at;
    			$row['updated_at'] = $value->updated_at;
    			
    			$no++;
    			$result[] = $row;
    		}

    		return json_encode($result);
    	}
    }


    function getCountPrefixHistory($find,$value){
    	if(!Cookie::get('token')){
	    	return json_encode(array('status' => false,'message' => 'not authorized'));
	    }else{
	    	if($find == "" && $value == ""){
		    	$request = SendAPI::execute($this->api_stats_url."/stats/prefix-history/count");
		    	$decode = json_decode($request);
		    	return number_format($decode[0]->count,0,".",",");
	    	}else{
	    		$value_decode = base64_decode($value);
		    	$request = SendAPI::execute($this->api_stats_url."/stats/prefix-history/count?field=".$find."&param=".$value_decode);
		    	$decode = json_decode($request);
		    	return number_format($decode[0]->count,0,".",",");
    		}
	    }
    }
}	