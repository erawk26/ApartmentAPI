<?php
$url = 'https://www.rentcafe.com/rentcafeapi.aspx?requestType=apartmentavailability&APIToken=NDY5OTI%3d-XDY6KCjhwhg%3d&propertyCode=p0155985';
if(isset($_GET)) {
	deliver_response(200, "success", getJson($url));
}

function getJson($url) {
	$cachefile='/tmp/cache.json';
	$timestamp=filemtime($cachefile);
	$cache_mins = 2;
	$response = '';
	if (!file_exists($cachefile) || (time() - ($cache_mins * 60) > $timestamp)) {
		$fp = fopen($cachefile, 'w');
		$response = file_get_contents($url);
		fwrite($fp, $response);
		fclose($fp);
	}
	//var_dump($timestamp);
	$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		$result = curl_exec($ch);
		curl_close($ch);
	$json = json_decode($result,true);
	return $json;
}
function deliver_response($status, $status_message, $data) {
	header("HTTP/1.1 $status $status_message");
	$response['status'] = $status;
	$response['status_message'] = $status_message;
	$response['data'] = $data;
	$json_response = json_encode($response);
	echo $json_response;
}
