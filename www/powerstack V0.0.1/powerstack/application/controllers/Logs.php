<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logs extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 public function __construct() {
        parent::__construct();
		$this->load->database();
		$this->load->model('clients_model'); 
		$this->load->model('logs_model'); 
	}
	 
	public function fetch()
	{
		
		$clients = $this->clients_model->get_all_clients();
		//print_r($clients);
		//die();
		for ($x = 0; $x < count($clients); $x++){
			//$fp = @fsockopen($clients[$x]['ip'], 3000, $errno, $errstr, 0.1);
			//if (!$fp) {
				$logs = $this->get_web_page('http://' . $clients[$x]['ip'] . ':3000/logs/');
				if ($logs){
					if ($this->isJson($logs)){
						$jlogs = json_decode($logs);
						for ($i = 0; $i < count($jlogs); $i++){
							$data['clientId'] = $clients[$x]['id'];
							$data['process'] = $jlogs[$i]->process;
							$data['errorcode'] = $jlogs[$i]->errorcode;
							$data['data'] = $jlogs[$i]->data;
							$data['datestamp'] = $jlogs[$i]->datestamp;
							$data['id'] = $jlogs[$i]->id;
							$this->logs_model->insert_log($data);
							$this->get_web_page('http://' . $clients[$x]['ip'] . ':3000/logs/update/' . $jlogs[$i]->id);
						}
					}else{
						echo "logs not json  " . $clients[$x]['ip'] . "<BR>";
					}
				}else{
					echo "logs empty  " . $clients[$x]['ip'] . "<BR>";
				}
			//}else{
			//	echo "client not responding " . $clients[$x]['ip'] . " " . $errstr . " <BR>";
			//}
		}

	}
	
	public function update()
	{
		
		$data['clients'] = $this->clients_model->get_all_clients();
		$this->load->helper('form');
		//print_r($this->input->post);
		if (isset($_POST['client_id'])){
			$data['id'] = $_POST['client_id'];
			$data['computerName'] = $_POST['computerName'];
			$data['ip'] = $_POST['ip'];
			$data['TVID'] = $_POST['TVID'];
			if (isset($_POST[''])){
				$data['status'] = '1';
			}else{
				$data['status'] = '0';
			}
			$this->clients_model->update_client($data);
			$data['client_id'] = $_POST['client_id'];
			
			
			$data['client_details'] = $this->clients_model->get_client_by_id($data);
			$data['client_groups'] = $this->clients_model->get_client_groups_by_id($data);
			$data['groups'] = $this->clients_model->get_all_groups();
			//$data['clients'] = $this->clients_model->get_client_by_id($data);
			//print_r($data['clients'] );
			//die();
		}
		$this->load->view('header');
		$this->load->view('nav-top');
		$this->load->view('nav-left');
		$this->load->view('accounts', $data);
		//$this->load->view('customize');
		$this->load->view('footer');
	}
	
	public function isJson($string) {
		json_decode($string);
		return (json_last_error() == JSON_ERROR_NONE);
	}
	
	public function get_web_page( $url )
    {
        $user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';

        $options = array(

            CURLOPT_CUSTOMREQUEST  =>"GET",        //set request type post or get
            CURLOPT_POST           =>false,        //set to GET
            CURLOPT_USERAGENT      => $user_agent, //set user agent
            //CURLOPT_COOKIEFILE     =>"cookie.txt", //set cookie file
            //CURLOPT_COOKIEJAR      =>"cookie.txt", //set cookie jar
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            //CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        );

        $ch      = curl_init( $url );
        curl_setopt_array( $ch, $options );
        $content = curl_exec( $ch );
        //$err     = curl_errno( $ch );
        //$errmsg  = curl_error( $ch );
        //$header  = curl_getinfo( $ch );
        curl_close( $ch );

        //$header['errno']   = $err;
        //$header['errmsg']  = $errmsg;
        //$site = $content;
        return $content;
    }


}
