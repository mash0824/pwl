<?php 
function PushLead(
	$requestdata, $url, $post 
	, $connectTimeout = 10
	, $httpheader = NULL
	, $operationTimeout = 60
	, $verifypeer = false
	, $returntransfer = true
	, $header = false
	, $followlocation = true 
) {
	
	ob_start();
	// echo $request;
	$ch=curl_init();
	
	curl_setopt($ch, CURLOPT_URL, $url);
	if($post) { //Post 
		curl_setopt($ch, CURLOPT_POST, true);
	}
	
	if(isset($requestdata) && $requestdata != "")
	{ //Post Fields in an array as opposed to getstring in the url. 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $requestdata);
	}
	
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $verifypeer);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, $returntransfer);
	if(isset($header)  && $header == true ){ 
		curl_setopt($ch, CURLOPT_HEADER, $header);
	}
	if(isset($httpheader) && !empty($httpheader)  && $httpheader != NULL)
	{
		//if(strpos($url,"wax.netspend.com") !==false) {
			//error_log("Request Submitted: ".$requestdata."\n",3,dirname(__FILE__)."/tmp/ErrorHeader".date("Ymd"));
			//error_log("URL Submitted: ".$url."\n",3,dirname(__FILE__)."/tmp/ErrorHeader".date("Ymd"));
			//error_log("Header Submitted: ".print_r($httpheader,true)."\n",3,dirname(__FILE__)."/tmp/ErrorHeader".date("Ymd"));
		//}
		curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
	}
	curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, $followlocation );
	
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $connectTimeout);
	curl_setopt($ch, CURLOPT_TIMEOUT, $operationTimeout);
	
	$response = curl_exec ($ch);
	if (curl_errno($ch)!=0)
	{
		$response = "CURL Error: ".curl_error($ch);
	}
	curl_close($ch);
	//echo $process_result;
	ob_end_clean();
	return $response;
} 

function my_curl($url) {
// HEADERS FROM FIREFOX - APPEARS TO BE A BROWSER REFERRED BY GOOGLE
	$curl = curl_init();
 
	$header[] = "Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
	$header[] = "Cache-Control: max-age=0";
	$header[] = "Connection: keep-alive";
	$header[] = "Keep-Alive: 300";
	$header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
	$header[] = "Accept-Language: en-us,en;q=0.5";
	$header[] = "Pragma: ";
 
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.15) Gecko/20080623 Firefox/2.0.0.15');
	curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
	curl_setopt($curl, CURLOPT_REFERER, 'http://www.google.com');
	curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');
	curl_setopt($curl, CURLOPT_AUTOREFERER, true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_TIMEOUT, 10);
 
	if (!$html = curl_exec($curl)) { $html = file_get_contents($url); }
	curl_close($curl);
return $html;
}

function simple_curl($url) {

	ob_start();
	// echo $request;
	$ch=curl_init();
 
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
 
	$response = curl_exec ($ch);
	if (curl_errno($ch)!=0)
	{
		$response = "CURL Error: ".curl_error($ch);
	}
	curl_close($ch);
	//echo $process_result;
	ob_end_clean();
	return $response;
	
}
?>