<?php
defined('BASEPATH') or die("No direct script allowed!");

class Chat extends CI_Controller
{
	protected $module_permission = array();
	protected $prefix; //check or update app_details table in db for session_prefix field
	protected $default_error_msg = "Error: Critical Error Encountered!";
	protected $role_id;
	protected $module = "transaction";
	protected $module_description = "Transaction";
	protected $page_name = "Transaction";
	protected $parent_menu = "Patient";
	protected $uid = 0;
	protected $uname;
	protected $ulname;
	protected $app_code;
	protected $app_name;
	protected $app_title;
	protected $app_version;
	protected $company_address;
	protected $company_contact;
	protected $timer_countdown;

	//for socket messaging
	//protected $clientSocketArray;

	function __construct()
	{

		parent::__construct();
		//date_default_timezone_set("Pacific/Port_Moresby");

		//get session prefix from db
		$this->load->model('app_details_m', 'ad');
		try {
			$ad = $this->ad->get_details();
			if ($ad) {
				$this->prefix = $ad->session_prefix;
				date_default_timezone_set($ad->timezone);

				if (!isset($this->session->userdata[$this->prefix . '_logged_in'])) {
					redirect(base_url() . 'authentication');
				} else {
					$prefix = $this->prefix;

					$this->uid = $this->session->userdata[$prefix . '_logged_in'][$prefix . '_uid'];
					$this->uname = strtoupper($this->session->userdata[$prefix . '_logged_in'][$prefix . '_fname']);
					$this->lname = strtoupper($this->session->userdata[$prefix . '_logged_in'][$prefix . '_lname']);

					$this->app_code = $this->session->userdata[$prefix . '_logged_in'][$prefix . '_app_code'];
					$this->app_name = $this->session->userdata[$prefix . '_logged_in'][$prefix . '_app_name'];
					$this->app_title = $this->session->userdata[$prefix . '_logged_in'][$prefix . '_app_title'];
					$this->app_version = $this->session->userdata[$prefix . '_logged_in'][$prefix . '_app_version'];
					$this->company_address = $this->session->userdata[$prefix . '_logged_in'][$prefix . '_company_address'];
					$this->company_contact = $this->session->userdata[$prefix . '_logged_in'][$prefix . '_company_contact'];
					//$this->timer_countdown = $this->session->userdata[$prefix . '_logged_in'][$prefix . '_timer_countdown'];						

					$this->load->model('model_chat');

					$this->load->model('authentication_m', 'a');
					$this->role_id = $this->session->userdata[$this->prefix . '_logged_in'][$this->prefix . '_role'];
					$this->module_permission = $this->a->allow_permission($this->role_id, $this->module);

					$this->load->library('custom_function', NULL, 'cf');
				}
			}
		} catch (Exception $ex) {
			redirect(base_url() . 'authentication');
		}
		//end of getting session prefix			
	}

	function index()
	{

		$data['prefix'] = $this->prefix;
		$data['app_title'] = $this->app_title;
		$data['app_version'] = $this->app_version;
		$data['page_name'] = $this->page_name;
		$data['parent_menu'] = $this->parent_menu;
		$data['module'] = $this->module;
		$data['module_description'] = $this->module_description;
		//$data['timer_countdown'] = $this->timer_countdown;

		if ($this->cf->is_allowed_module($this->module, $this->prefix)) {
			$data['role_id'] = $this->role_id;
			$data['module_permission'] = $this->module_permission;
			$data['uid'] = $this->uid;
			$data['ufname'] = $this->uname;
			$data['fullname'] = strtoupper($this->uname . " " . $this->lname);

			$this->load->view('transaction/index', $data);
		} else {
			redirect(base_url() . 'authentication');
		}
	}

	function get_last_message()
	{
		try {
			$messages = $this->model_chat->get_last_message();
			echo json_encode($messages);
		} catch (Exception $ex) {
			echo $ex->getMessage();
		}
	}

	function get_messages()
	{
		$fromDate = trim($this->input->post("fromDate"));

		try {
			$messages = $this->model_chat->get_latest_message($fromDate);
			echo json_encode($messages);
		} catch (Exception $ex) {
			echo $ex->getMessage();
		}
	}

	function send_message()
	{
		$fromDate = $this->input->post("fromDate");
		$msg = $this->input->post("msg");

		if ($msg) {
			try {
				$send = $this->model_chat->send_message($msg, $this->uid);

				if ($send) {
					try {
						$messages = $this->model_chat->get_latest_message($fromDate);
						echo json_encode($messages);
					} catch (Exception $ex) {
						echo $ex->getMessage();
					}
				} else {
					echo "Error: Unable to send message!";
				}
			} catch (Exception $ex) {
				echo $ex->getMessage();
			}
		}
	}


	//socket messaging
	/*
		function chat_server(){
			//define('HOST_NAME',"localhost"); //*
			//define('PORT',"8090"); //*
			$host_name = "localhost"; //
			$port = 8090; //
			$null = NULL;
			
			//require_once("class.chathandler.php"); //*
			//$chatHandler = new ChatHandler(); //*
			
			$socketResource = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			socket_set_option($socketResource, SOL_SOCKET, SO_REUSEADDR, 1);
			//socket_bind($socketResource, 0, PORT); //*
			socket_bind($socketResource, 0, $port); //
			
			socket_listen($socketResource);
			
			$clientSocketArray = array($socketResource);
			while (true) {
				$newSocketArray = $clientSocketArray;
				socket_select($newSocketArray, $null, $null, 0, 10);
				
				if (in_array($socketResource, $newSocketArray)) {
					
					$newSocket = socket_accept($socketResource);
					
					$clientSocketArray[] = $newSocket;		
					
					$header = socket_read($newSocket, 1024);
					
					//$chatHandler->doHandshake($header, $newSocket, HOST_NAME, PORT); //*
					$this->doHandshake($header, $newSocket, $host_name, $port); //
							
					socket_getpeername($newSocket, $client_ip_address);
					
					//$connectionACK = $chatHandler->newConnectionACK($client_ip_address); //*
					$connectionACK = $this->newConnectionACK($client_ip_address); //
					
					//$chatHandler->send($connectionACK); //*
					$this->send($connectionACK); //
					
					$newSocketIndex = array_search($socketResource, $newSocketArray);
					unset($newSocketArray[$newSocketIndex]);
				}
				
			
				foreach ($newSocketArray as $newSocketArrayResource) {	
					
					while(socket_recv($newSocketArrayResource, $socketData, 1024, 0) >= 1){
						
						//$socketMessage = $chatHandler->unseal($socketData); //*
						$socketMessage = $this->unseal($socketData);	//					
						$messageObj = json_decode($socketMessage);
						
						//$chatHandler->saveToDB($messageObj);
						
						//$chat_box_message = $chatHandler->createChatBoxMessage($messageObj->chat_user, $messageObj->chat_message); //
						$chat_box_message = $this->createChatBoxMessage($messageObj->chat_user, $messageObj->chat_message); //
						
						//$chatHandler->send($chat_box_message); //*
						$this->send($chat_box_message); //
						
						break 2;
					}
					
					$socketData = @socket_read($newSocketArrayResource, 1024, PHP_NORMAL_READ);
					
					if ($socketData === false) { 
						socket_getpeername($newSocketArrayResource, $client_ip_address);
						//$connectionACK = $chatHandler->connectionDisconnectACK($client_ip_address); //*
						$connectionACK = $this->connectionDisconnectACK($client_ip_address); //
						
						//$chatHandler->send($connectionACK); //*
						$this->send($connectionACK);
						
						$newSocketIndex = array_search($newSocketArrayResource, $clientSocketArray);
						unset($clientSocketArray[$newSocketIndex]);			
					}
				}
			}
			socket_close($socketResource);
		}
	
		function send($message) {		
			//global $clientSocketArray;
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
			$message = 'New client ' . $client_ip_address.' joined';
			$messageArray = array('message'=>$message,'message_type'=>'chat-connection-ack');
			$ACK = $this->seal(json_encode($messageArray));
			return $ACK;
		}
		
		function connectionDisconnectACK($client_ip_address) {
			$message = 'Client ' . $client_ip_address.' disconnected';
			$messageArray = array('message'=>$message,'message_type'=>'chat-connection-ack');
			$ACK = $this->seal(json_encode($messageArray));
			return $ACK;
		}
		
		function createChatBoxMessage($chat_user,$chat_box_message) {
			$message = $chat_user . ": <div class='chat-box-message'>" . $chat_box_message . "</div>";
			$messageArray = array('message'=>$message,'message_type'=>'chat-box-html');
			$chatMessage = $this->seal(json_encode($messageArray));
			return $chatMessage;
		}
	
		function saveToDB($message_obj){
			$mysqli = new mysqli('localhost', 'root', 'astalavista', 'chat');
	
			$user_id = $message_obj->user_id;
			$message = $message_obj->chat_message;
	
			$query = $mysqli->query("INSERT INTO chat (`user_id`,`message`) VALUES ({$user_id}, '{$message}');");
			
			$mysqli->close();
			
		}
		*/
	//end of socketing messaging
}
