<?php
function events($url){
    $cachefile = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . md5($url) . '.json';
    $minutes = 10;
	$timestamp=!file_exists($cachefile)?(time()-(($minutes+1) * 60)):filemtime($cachefile);//fileexists logic needs to happen before $overtime logic
    $over_time=(time() - $timestamp) > ($minutes * 60);
    if($over_time){
        $data = refresh_data($url,$cachefile);
        file_put_contents($cachefile, json_encode($data, LOCK_EX));
    }
    $data = file_get_contents($cachefile);
	return json_decode($data);
}
//function refresh_data($url,$file) {
//	$ch = curl_init();
//    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//    curl_setopt($ch, authorization,'Bearer J5XZSH2CT2RTRRGY3ONC');
//    curl_setopt($ch, CURLOPT_URL, $url);
//    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//    $result = $httpCode == 404?file_get_contents($file):curl_exec($ch);
//	curl_close($ch);
//	$json = json_decode($result,true);
//	return $json;
//}
function refresh_data($url,$file) {
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://www.eventbriteapi.com/v3/events/44771170777',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => array(
			"authorization: Bearer J5XZSH2CT2RTRRGY3ONC",
			"cache-control: no-cache",
			"postman-token: 01c4b9c5-caa3-947a-2864-ac1a8e66298c"
		),
	));
	$err = curl_error($curl);
	$response = curl_exec($curl);
	curl_close($curl);
	return $response;
}
function deliver_response($status, $status_message, $data) {
	header("HTTP/1.1 $status $status_message");
	$response['status'] = $status;
	$response['status_message'] = $status_message;
	$response['data'] = $data;
	$json_response = json_encode($response);
	echo $json_response;
}
if(isset($_GET)) {deliver_response(200, "success", events());}