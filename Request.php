<?php

class Request {
	public $service;
	public $url;
	public $number;
	public $cc = "+91";
	public $payload = "";
	public $data_type = "";

	public $timeout = 100;
	public function __construct($service,$number)  {
		$this->service = $service;
		$this->number = $number;
		

	}

	public function _parse() {
		if ($this->service->method == "POST") {
			$this->payload = $this->service->data;

		}
		else {
			$this->payload = $this->service->params;
		}


		foreach ($this->payload as $key => $value) {
			
			if ($value == "{target}") {
						$this->payload->$key = $this->number;
				}

			if ($value == "{cc}") {
						$this->payload->$key = $this->cc;
				}	
				
			}
		// print_r($this->payload);
		return $this->payload;
	}

	public function _headers() 
	{	
		$temp = [];
		if (property_exists($this->service, "headers")) {
			$temp = (array) $this->service->headers;
		}
		$temp = [ "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) \ AppleWebKit/537.36 (KHTML, like Gecko) \ Chrome/91.0.4472.124 Safari/537.36"];
		// print_r($this->data_type);
		if ($this->data_type == "json") {
			array_push($temp, 'Content-Type: application/json');
		}
		return $temp;

	}


	public function _get($mh) {


	$queryString = http_build_query($this->payload);

	$this->url =$this->service->url;

	$this->url = $this->url . '?' . $queryString;
	
	

	$ch = curl_init($this->url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $this->_headers());
	curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout); 

	// $response = curl_exec($ch);

	// if ($response === false) {
 //    	echo  curl_error($ch);
	// } else {
 //    	echo $response;
	// }

	// curl_close($ch);
	curl_multi_add_handle($mh,$ch);

	}

	public function _post($mh) {
		$jsonData = "";

		if (property_exists($this->service, "data_type")  && $this->service->data_type == "json") {

				$this->data_type = "json";
			 $jsonData = json_encode($this->payload);

		}
		else {
			
			$jsonData = http_build_query( (array) $this->payload);

		}
		$this->url =$this->service->url;

		$ch = curl_init($this->url);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
		// print_r($this->_headers());
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->_headers());

		// $response = curl_exec($ch);

		// if ($response === false) {
  //   		echo  curl_error($ch);
		// } else {
  //   		echo  $response;
		// }

		// curl_close($ch);
		curl_multi_add_handle($mh,$ch);

		}


		public function _run($mh) {
		$this->_parse();

		if ($this->service->method == "POST") {
			$this->_post($mh);
		}
		else {
			$this->_get($mh);

		}
		}
	}
	
