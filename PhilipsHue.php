<?php

	class PhilipsHue
	{
		public $bridge;
		public $token;
		public $username;
		public $status;
		
		public function Init($BridgeID, $APIToken)
		{
			$this->bridge = $BridgeID;
			$this->token = $APIToken;
		}
		
		public function sendCommand($URL, $Command = "")
		{
			ob_start();
			
			$ch = curl_init();
			$fp = tmpfile();

			$body = preg_replace("/:(\"|')([0-9]+|true|false)(\"|')/", ":$2", is_string($Command) ? $Command : json_encode($Command));

			fwrite($fp, $body);
			fseek($fp, 0);

			curl_setopt($ch, CURLOPT_URL, 'https://client-eastwood-dot-hue-prod-us.appspot.com/api/0/' . $URL);
			curl_setopt($ch, CURLOPT_PUT, true);
			curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
			curl_setopt($ch, CURLOPT_INFILE, $fp);
			curl_setopt($ch, CURLOPT_INFILESIZE, strlen($body));
			curl_setopt($ch, CURLOPT_HTTPHEADER, array
			(
				"Content-Type: application/json;charset=UTF-8",
				"X-Token: " . $this->token
			));

			curl_exec($ch);
			curl_close($ch);
			fclose($fp);
			
			$response = ob_get_clean();
			
			if(preg_match("/^({|\[)(.*?)?(\]|})$/", $response))
				return json_decode($response);
			
			return $response;
		}
		
		public function getBridge()
		{
			if(!$this->bridge or !$this->token)
				return (object) array();
			
			$out = (object) array();
			$status = file_get_contents('https://www.meethue.com/api/getbridge?' . http_build_query(array
			(
				"bridgeid" => $this->bridge,
				"token" => $this->token
			)));
			
			if($status)
			{
				$status = json_decode($status);
				
				if($status)
				{
					$out = $status;
					
					foreach($out->config->whitelist as $id => $u)
					{
						$this->username = $id;
						break;
					}
				}
			}
			
			$this->status = $out;
			
			return $out;
		}
	}
