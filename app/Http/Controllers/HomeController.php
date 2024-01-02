<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use SendAPI;
class HomeController extends Controller
{   
    private $app_url = "http://localhost:9091"; //default value
	private $api_stats_url = "http://localhost:8080"; //default value
    private $app_env = "dev"; //default value dev,beta,prod
	private $kadabra_url = "https://ris.kadabra.id"; //default value
    private $api_ris_url = "http://localhost:9090"; //default value
    private $protocol_web = "https";

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
    }

    function index(){
        $data['api_ris_url'] = $this->api_ris_url;
    	$data['kadabra_url'] = $this->kadabra_url;
        $data['websocket_url'] = $this->getWebSocketData();
    	$data['app_url'] = $this->app_url;
        $data['current_ipv4'] = $this->getIPv4ThisMonth();
        $data['current_ipv6'] = $this->getIPv6ThisMonth();
        $data['current_asn'] = $this->getASNThisMonth();
    	return view('home_v2',$data);
    }

    function about(){
        $data['api_ris_url'] = $this->api_ris_url;
    	$data['kadabra_url'] = $this->kadabra_url;
        $data['websocket_url'] = $this->getWebSocketData();
    	$data['app_url'] = $this->app_url;
    	return view('about',$data);
    }

    function getWebSocketData(){
        $last_string = substr($this->api_ris_url, -1);
        if($last_string != "/"){
           $url_api = $this->api_ris_url."/";
        }else{
           $url_api = $this->api_ris_url;
        }

        $request_websocket = SendAPI::execute($url_api."dashboard/ris/get-web-socket-data/".$this->app_env);

        $decode_websocket = json_decode($request_websocket);

        if($decode_websocket[0]->port_web_socket != "80"){
          $url_websocket = $decode_websocket[0]->host_web_socket.":".$decode_websocket[0]->port_web_socket;
        }else{
          $url_websocket = $decode_websocket[0]->host_web_socket;
        }

        if($this->protocol_web == "https"){
          $url_websocket = "wss://".$url_websocket;
        }else{
          $url_websocket = "ws://".$url_websocket;
        }

        return $url_websocket;
    }

    // ------ api stats -------
    function roaRange($range){
        $request = SendAPI::execute($this->api_stats_url."/stats/roa?range=".$range);
        $decode = json_decode($request);
        return $decode;
    }

    function roaDateRange($start,$end){
        $request = SendAPI::execute($this->api_stats_url."/stats/roa?start=".$start."&end=".$end);
        $decode = json_decode($request);
        return $decode;
    }

    function getIPv4ThisMonth(){
        $last_month_ipv4 = $this->prefixRange('month','ipv4',date('Y-m',strtotime('-1 month')));
        $current_month_ipv4 = $this->prefixRange('month','ipv4',date('Y-m'));
        $lm_value = 0;
        $cr_value = 0;

        foreach($last_month_ipv4 as $value){
            $lm_value += $value->prefix_idnic;
        }

        foreach($current_month_ipv4 as $value){
            $cr_value += $value->prefix_idnic;
        }

        if($cr_value > 0 && $lm_value > 0){
            $percent = (($cr_value-$lm_value)/$lm_value)*100;
        }else{
            $percent = 0;
        }

        return array('value' => $cr_value,'percent' => $percent);
    }

    function getIPv6ThisMonth(){
        $last_month_ipv6 = $this->prefixRange('month','ipv6',date('Y-m',strtotime('-1 month')));
        $current_month_ipv6 = $this->prefixRange('month','ipv6',date('Y-m'));
        $lm_value = 0;
        $cr_value = 0;

        foreach($last_month_ipv6 as $value){
            $lm_value += $value->prefix_idnic;
        }

        foreach($current_month_ipv6 as $value){
            $cr_value += $value->prefix_idnic;
        }

        if($cr_value > 0 && $lm_value > 0){
            $percent = (($cr_value-$lm_value)/$lm_value)*100;
        }else{
            $percent = 0;
        }

        return array('value' => $cr_value,'percent' => $percent);
    }

    function getASNThisMonth(){
        $last_month_asn = $this->asRange('month',date('Y-m',strtotime('-1 month')));
        $current_month_asn = $this->asRange('month',date('Y-m'));
        $lm_value = 0;
        $cr_value = 0;

        foreach($last_month_asn as $value){
            $lm_value += $value->asn_idnic;
        }

        foreach($current_month_asn as $value){
            $cr_value += $value->asn_idnic;
        }

        if($cr_value > 0 && $lm_value > 0){
            $percent = (($cr_value-$lm_value)/$lm_value)*100;
        }else{
            $percent = 0;
        }

        return array('value' => $cr_value,'percent' => $percent);
    }

    function prefixRange($range,$source,$value = null){
        if($this->isRangeValid($range)){
            $request = SendAPI::execute($this->api_stats_url."/stats/prefix?range=".$range."&source=".$source);
        }else if($range == "month"){
            $request = SendAPI::execute($this->api_stats_url."/stats/prefix?month=".$value."&source=".$source);
        }else if($range == "year"){
            $request = SendAPI::execute($this->api_stats_url."/stats/prefix?year=".$value."&source=".$source);
        }

        $decode = json_decode($request);
        return $decode;
    }

    function prefixDateRange($start,$end,$source){
        $request = SendAPI::execute($this->api_stats_url."/stats/prefix?start=".$start."&end=".$end."&source=".$source);
        $decode = json_decode($request);
        return $decode;
    }

    function asRange($range,$value = null){
        if($this->isRangeValid($range)){
            $request = SendAPI::execute($this->api_stats_url."/stats/as?range=".$range);
        }else if($range == "month"){
            $request = SendAPI::execute($this->api_stats_url."/stats/as?month=".$value);
        }else if($range == "year"){
            $request = SendAPI::execute($this->api_stats_url."/stats/as?year=".$value);
        }
        
        $decode = json_decode($request);
        return $decode;
    }

    function asDateRange($start,$end){
        $request = SendAPI::execute($this->api_stats_url."/stats/as?start=".$start."&end=".$end);
        $decode = json_decode($request);
        return $decode;
    }

    // -- summary data --
    function isRangeValid($rng) {
        if($rng == "1d" || $rng == "7d" || $rng == "30d" || $rng == "all"){
            $result = true;
        }else{
            $result = false;
        }

        return $result;
    }

    function prefixSummaryRange($range,$source,$value = Null){
        if($this->isRangeValid($range)){
            $request = SendAPI::execute($this->api_stats_url."/stats/prefix/summary?range=".$range."&source=".$source);
        }else if($range == 'month'){
            $request = SendAPI::execute($this->api_stats_url."/stats/prefix/summary?month=".$value."&source=".$source);
        }else if($range == 'year'){
            $request = SendAPI::execute($this->api_stats_url."/stats/prefix/summary?year=".$value."&source=".$source);
        }
        $decode = json_decode($request);
        return $decode;
    }

    function prefixSummaryDateRange($start,$end,$source){
        $request = SendAPI::execute($this->api_stats_url."/stats/prefix/summary?start=".$start."&end=".$end."&source=".$source);
        $decode = json_decode($request);
        return $decode;
    }

    function asSummaryRange($range,$value = Null){
        if($this->isRangeValid($range)){
            $request = SendAPI::execute($this->api_stats_url."/stats/as/summary?range=".$range);
        }else if($range == 'month'){
            $request = SendAPI::execute($this->api_stats_url."/stats/as/summary?month=".$value);
        }else if($range == 'year'){
            $request = SendAPI::execute($this->api_stats_url."/stats/as/summary?year=".$value);
        }
        $decode = json_decode($request);
        return $decode;
    }

    function asSummaryDateRange($start,$end){
        $request = SendAPI::execute($this->api_stats_url."/stats/as/summary?start=".$start."&end=".$end);
        $decode = json_decode($request);
        return $decode;
    }

    function statsRFC(){
        $data['api_ris_url'] = $this->api_ris_url;
        $data['kadabra_url'] = $this->kadabra_url;
        $data['websocket_url'] = $this->getWebSocketData();
        $data['app_url'] = $this->app_url;
        return view('stats_rfc',$data);
    }

    function rfcNewRegRange($range,$value = Null){
        if($this->isRangeValid($range)){
            $request = SendAPI::execute($this->api_stats_url."/stats/prefix/rfc/new-reg?range=".$range);
        }else if($range == 'month'){
            $request = SendAPI::execute($this->api_stats_url."/stats/prefix/rfc/new-reg?month=".$value);
        }else if($range == 'year'){
            $request = SendAPI::execute($this->api_stats_url."/stats/prefix/rfc/new-reg?year=".$value);
        }
        $decode = json_decode($request);
        return $decode;
    }

    function rfcNewRegDateRange($start,$end){
        $request = SendAPI::execute($this->api_stats_url."/stats/prefix/rfc/new-reg?start=".$start."&end=".$end);
        $decode = json_decode($request);
        return $decode;
    }

    function rfcSummaryRange($range,$value = Null){
        if($this->isRangeValid($range)){
            $request = SendAPI::execute($this->api_stats_url."/stats/prefix/rfc/summary?range=".$range);
        }else if($range == 'month'){
            $request = SendAPI::execute($this->api_stats_url."/stats/prefix/rfc/summary?month=".$value);
        }else if($range == 'year'){
            $request = SendAPI::execute($this->api_stats_url."/stats/prefix/rfc/summary?year=".$value);
        }
        $decode = json_decode($request);
        return $decode;
    }

    function rfcSummaryDateRange(){
        $request = SendAPI::execute($this->api_stats_url."/stats/prefix/rfc/summary?start=".$start."&end=".$end);
        $decode = json_decode($request);
        return $decode;
    }

    function rfcDataRange($range,$value = Null){
        if($this->isRangeValid($range)){
            $request = SendAPI::execute($this->api_stats_url."/stats/prefix/rfc/data?range=".$range);
        }else if($range == 'month'){
            $request = SendAPI::execute($this->api_stats_url."/stats/prefix/rfc/data?month=".$value);
        }else if($range == 'year'){
            $request = SendAPI::execute($this->api_stats_url."/stats/prefix/rfc/data?year=".$value);
        }
        $decode = json_decode($request);
        
        $result = array();
        $no=1;
        foreach ($decode as $value) {
            $row = array();
            $row['no'] = $no;
            $row['date'] = $value->date;
            $row['prefix'] = $value->prefix;
            $row['last_as'] = $value->last_as;
            $row['rc_alias'] = $value->rc_alias;

            $no++;
            $result[] = $row;
        }

        return json_encode($result);
    }

    function rfcDataDateRange(){
        $request = SendAPI::execute($this->api_stats_url."/stats/prefix/rfc/data?start=".$start."&end=".$end);
        $decode = json_decode($request);
        $result = array();
        $no=1;
        foreach ($decode as $value) {
            $row = array();
            $row['no'] = $no;
            $row['date'] = $value->date;
            $row['prefix'] = $value->prefix;

            $no++;
            $result[] = $row;
        }

        return json_encode($result);
    }
}