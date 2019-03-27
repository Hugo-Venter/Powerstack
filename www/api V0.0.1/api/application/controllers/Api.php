<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
defined('BASEPATH') OR exit('No direct script access allowed');
 
require(APPPATH.'/libraries/REST_Controller.php');

class Api extends REST_Controller
{
	public function __construct() {
        parent::__construct();
		$this->load->database();
		$this->load->model('client_model'); 
	}
	
	public function ping_get(){
		
		$this->load->helper('form');
		
		$check = $this->check_api_key("ping");

		if (is_array($check)){
			
			$this->response($check);
			
		}else{
			$this->response(array($check));
		}

	}
	
	public function scripts_get(){
		$type = $this->uri->segment(3);
		$this->load->model('scripts_model');
		
		if ($type == "default"){
			$this->response($this->scripts_model->get_default_scripts());
			//$this->response("sdfsdf");
		}else{
			 if ($type == "all"){
				
			}else{
				$this->load->helper('form');
				
				$clientId = $this->check_api_key();
				if (is_array($clientId)){
					
					$this->response($clientId);
					
				}else{
					
					$this->response($this->scripts_model->get_all_scripts(1,$clientId));
					
				}
			}
		}

	}
	
	public function rescue_get(){
		$computer = $this->uri->segment(3);
		if($computer){
			exec ( 'c:\windows\system32\WindowsPowerShell\v1.0\PowerShell.exe -ExecutionPolicy Bypass -File "' . FCPATH . '\apps\RescuePS.ps1" "' . $computer . '"',$output);
			//exec ( ' -ExecutionPolicy Bypass -File "C:\inetpub\wwwroot\api\apps\RescuePS.ps1" "1003-SEV"',$o);
			$this->response($output);
		}else{
			$this->response("computer name not set");	
		}
	}

	public function logs_post(){
		
		$this->load->model('scripts_model');
		$this->load->helper('form');
		$headers = $this->input->request_headers();
		//$rs = false;
		
		if (isset($headers['Powerstack-Key'])){
			$key = $headers['Powerstack-Key'];
			if ($key){
				$client = $this->client_model->get_client_by_key($key);
				$logs = trim(file_get_contents('php://input'));
				if ($client){
					if ($logs){
						if ($this->isJson($logs)){
							$jlogs = json_decode($logs);
							$this->load->model('logs_model'); 
							for ($i = 0; $i < count($jlogs); $i++){
								$data['clientId'] = $client[0]['id'];
								$data['process'] = $jlogs[$i]->process;
								$data['errorcode'] = $jlogs[$i]->errorcode;
								$data['data'] = $jlogs[$i]->data;
								$data['datestamp'] = $jlogs[$i]->datestamp;
								$data['id'] = 1;	
								$this->logs_model->insert_log($data);
							}
							$rs = array("status" => true,"logs" => "inserted");
						}else{
							$rs = array("status" => false,"logs" => "not json");
						}
					}else{
						$rs = array("status" => false,"logs" => "empty");
					}
				}else{
					$rs = array("status" => false,"client not found" => $key);
				}
			}else{
				$rs = array("status" => false,"ApiKey" => "empty");
			}
		}else{
			$rs = array("status" => false,"ApiKey" => "no set");
		}
		$this->response($rs);
	}
	
	
	public function key_get(){
		
		$this->load->helper('form');
		
		if (isset($_REQUEST['ip'])){
			//die();
			$apiKey = $this->generate_key();
			
			$data['ip'] = $_REQUEST['ip'];
			$data['computerName'] = $_REQUEST['computerName'];
			$data['apiKey'] = $apiKey;
			$data['clientId'] = $this->client_model->insert_client($data);
			$data['groupId'] = 1;
			$this->client_model->insert_client_group($data);
			$rs = array("status" => "created","apiKey" => $apiKey);
		}else{
			$rs = array("status" => "false","apiKey" => "Required data missing");
		}
		$this->response($rs);
	}
	
	public function _key_get(){
		
		$this->load->helper('form');
		
		if (isset($_REQUEST['ip'])){
			//die();
			$apiKey = $this->generate_key();
			
			$data['ip'] = $_REQUEST['ip'];
			$data['computerName'] = $_REQUEST['computerName'];
			$data['apiKey'] = $apiKey;
			$data['clientId'] = $this->client_model->insert_client($data);
			$data['groupId'] = 1;
			$this->client_model->insert_client_group($data);
			$rs = array("status" => "created","apiKey" => $apiKey);
		}else{
			$rs = array("status" => "false","apiKey" => "Required data missing");
		}
		$this->response($rs);
	}
	
	public function ping_post(){
		$this->response(array("not support"));
	}


	public function index_get(){
		$this->response(array("not support"));
	}
		
	private function generate_key()
	{
		// Generate a random salt
		$salt = base_convert(bin2hex($this->security->get_random_bytes(64)), 16, 36);
		
		// If an error occurred, then fall back to the previous method
		if ($salt === FALSE)
		{
		$salt = hash('sha256', time() . mt_rand());
		}
		
		$new_key = substr($salt, 0, 40);
		$new_key = implode('-', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 30), 6));
		return $new_key;
	}
	
	public function check_api_key($type = "check"){
		$this->load->helper('form');
		$headers = $this->input->request_headers();
		//$rs = false;
		if (isset($headers['Powerstack-Key'])){
			$key = $headers['Powerstack-Key'];
			//$this->response($key . " sdfsdf");
			if ($key > ''){
				if (strlen($key) == 34){
					//Now check the DB status
					$client = $this->client_model->get_client_by_key($key);
					//echo $client[0]['status'] . "asdasd";
					if (!isset($client[0]['status'])){
						$rs = array("status" => false,"account" => "unknown");
					}else{
						if ($client[0]['status'] == 1){
							//update last com
							if ($type == "ping"){
								$this->client_model->update_client_last_con($key);
								$rs = array("status" => true,"account" => "pong");
							}
							if ($type == "check"){
								return $client[0]['id'];
							}
						}else{
							
							$rs = array("status" => false,"account" => "disabled");
						}
					}
				}else{
					$rs = array("status" => false,"key" => "incorrect");
				}
			}else{
				$rs = $this->_key_get();
				//$rs = array("status" => false,"key" => "empty");
			}
        //$rs = array("status" => false,"key" => "sdfsdf");
		}else{
			$rs = array("status" => false,"key" => "missing");
		}

		$this->response($rs);
	}
	public function isJson($string) {
		json_decode($string);
		return (json_last_error() == JSON_ERROR_NONE);
	}
}
