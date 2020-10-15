<?php
class ChatHandler {
	//function send($message) {
	function send($message) {
		
		global $clientSocketArray;
		$messageLength = strlen($message);
		foreach($clientSocketArray as $clientSocket)
		{
			//echo $clientSocket . "\n";
			//print_r($message);
			//echo "\n";
			@socket_write($clientSocket,$message,$messageLength);
		}
		return true;
	}

	function unseal($socketData) {
		$length = ord($socketData[1]) & 127;
		if($length == 126) {
			$masks = substr($socketData, 4, 4);
			$data = substr($socketData, 8);
		}
		elseif($length == 127) {
			$masks = substr($socketData, 10, 4);
			$data = substr($socketData, 14);
		}
		else {
			$masks = substr($socketData, 2, 4);
			$data = substr($socketData, 6);
		}
		$socketData = "";
		for ($i = 0; $i < strlen($data); ++$i) {
			$socketData .= $data[$i] ^ $masks[$i%4];
		}
		return $socketData;
	}

	function seal($socketData) {
		$b1 = 0x80 | (0x1 & 0x0f);
		$length = strlen($socketData);
		
		if($length <= 125)
			$header = pack('CC', $b1, $length);
		elseif($length > 125 && $length < 65536)
			$header = pack('CCn', $b1, 126, $length);
		elseif($length >= 65536)
			$header = pack('CCNN', $b1, 127, $length);
		return $header.$socketData;
	}

	function doHandshake($received_header,$client_socket_resource, $host_name, $port) {
		$headers = array();
		$lines = preg_split("/\r\n/", $received_header);
		foreach($lines as $line)
		{
			$line = chop($line);
			if(preg_match('/\A(\S+): (.*)\z/', $line, $matches))
			{
				$headers[$matches[1]] = $matches[2];
			}
		}

		//print_r($headers);//

		$secKey = $headers['Sec-WebSocket-Key'];
		$secAccept = base64_encode(pack('H*', sha1($secKey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
		$buffer  = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
		"Upgrade: websocket\r\n" .
		"Connection: Upgrade\r\n" .
		"WebSocket-Origin: $host_name\r\n" .
		//"WebSocket-Location: ws://$host_name:$port/demo/shout.php\r\n".
		"Sec-WebSocket-Accept:$secAccept\r\n\r\n";
		socket_write($client_socket_resource,$buffer,strlen($buffer));
	}
	
	function newConnectionACK($client_ip_address) {
		$message = 'User with IP ' . $client_ip_address.' joined';
		$messageArray = array('message'=>$message,'message_type'=>'chat-connection-ack');
		$ACK = $this->seal(json_encode($messageArray));
		return $ACK;
	}
	
	function connectionDisconnectACK($client_ip_address) {
		$message = 'User with IP ' . $client_ip_address.' disconnected';
		$messageArray = array('message'=>$message,'message_type'=>'chat-connection-ack');
		$ACK = $this->seal(json_encode($messageArray));
		return $ACK;
	}
	
	function createChatBoxMessage($chat_user,$message,$dt) {
		//$message = $chat_user . ": <div class='chat-box-message'>" . $chat_box_message . "</div>";
		$messageArray = array(
							  'message_type' => 'chat-msg',
							  'chat_user' => $chat_user,
							  'chat_message'=> $message,
							  'dt'=> $dt
							  );
		$chatMessage = $this->seal(json_encode($messageArray));
		return $chatMessage;
	}

	function saveToDB($message_obj){
		$mysqli = new mysqli('localhost', 'root', 'astalavista', 'clinic');
		
		if ($message_obj){
			$user_id = $message_obj->user_id;
			$message = $message_obj->chat_message;
			$dt = $message_obj->dt;
	
			$query = $mysqli->query("INSERT INTO chat (`sender_id`,`msg`,`dt`) VALUES ({$user_id}, '{$message}','{$dt}');");
			
		}
		$mysqli->close();		
	}
}
?>