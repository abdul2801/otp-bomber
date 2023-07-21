<?php



include 'Request.php';
function run($num)
{



	$jsonFile = 'services.json';
	$jsonData = file_get_contents($jsonFile);
	$data = json_decode($jsonData);
	$service = new StdClass();


	


$mh = curl_multi_init();

foreach ($data->{"91"} as $service) {
	
	
	

	$serv = new Request($service,$num);
	
	$serv->_run($mh);
	
	
	
 }

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
}
