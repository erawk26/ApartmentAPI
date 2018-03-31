<?php
if(isset($_GET)) {
	deliver_response(200, "success", apts());
}
function apts(){
	$url = 'https://www.rentcafe.com/rentcafeapi.aspx?requestType=apartmentavailability&APIToken=NDY5OTI%3d-XDY6KCjhwhg%3d&propertyCode=p0155985';
	$cachefile = md5($url);
	$timestamp=filemtime($cachefile);
    $exists = file_exists($cachefile);
    $over_time=(time() - $timestamp) > (10 * 60);
    //fetch new data if file doesnt exist OR if time is up
    //TODO: AND if service is working
    if($over_time || !$exists){
    file_put_contents($cachefile, json_encode(refresh_apts($url), LOCK_EX));
    }
	return json_decode(file_get_contents($cachefile));
}
function refresh_apts($url) {
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
