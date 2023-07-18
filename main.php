<?php

$jsonFile = 'services.json';
$jsonData = file_get_contents($jsonFile);
$data = json_decode($jsonData);
$service = new StdClass();


include 'Request.php';

	

$mh = curl_multi_init();

foreach ($data->{"91"} as $service) {
	$service =  $data->{"91"}[17];
	$serv = new Request($service,9344841926);
	print_r($service);
	$serv->_run($mh);
	break;

	
 } ;

 $running = null;

 do {
 	try {
 	curl_multi_exec($mh, $running);
 	}
 	catch(Exception $e) {
 		print("Error in request");
 	}

 	while ($info = curl_multi_info_read($mh)) {

 		$completedHandle = $info['handle'];

 		$response = curl_multi_getcontent($completedHandle);

 		print_r($response);

 		curl_multi_remove_handle($mh, $completedHandle);

        curl_close($completedHandle);

 	}


 }
 while ($running > 0);

curl_multi_close($mh);

?>
