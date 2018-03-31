<?php
if (isset($_GET)) {
	deliver_response(200, "success", apts());
}
function apts(){
	$url = 'https://www.rentcafe.com/rentcafeapi.aspx?requestType=apartmentavailability&APIToken=NDY5OTI%3d-XDY6KCjhwhg%3d&propertyCode=p0155985';
	$cacheFile = 'cache' . DIRECTORY_SEPARATOR . md5($url);
	if (file_exists($cacheFile)) {
		$fh = fopen($cacheFile, 'r');
		$cacheTime = trim(fgets($fh));
		if ((($cacheTime > strtotime('-1 minutes'))||(!get_new($url)))) {
			return fread($fh, filesize($cacheFile));
		}
		fclose($fh);
		unlink($cacheFile);
	}
	$json = get_new($url);
	$fh = fopen($cacheFile, 'w');
	fwrite($fh, time() . "\n");
	fwrite($fh, $json);
	fclose($fh);
	return $json;
}

function get_new($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL, $url);
	$result = curl_exec($ch);
	curl_close($ch);
	$json = json_decode($result, true);
	return $json;
}

function deliver_response($status, $status_message, $data){
	header("HTTP/1.1 $status $status_message");
	$response['status'] = $status;
	$response['status_message'] = $status_message;
	$response['data'] = $data;
	$json_response = json_encode($response);
	echo $json_response;
}
