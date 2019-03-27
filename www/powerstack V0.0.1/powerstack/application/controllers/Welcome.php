<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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

	}
	 
	public function index()
	{
		$this->load->model('clients_model'); 
		$this->load->model('logs_model'); 
		$data['clientCount'] = $this->clients_model->get_client_count();
		$clients = $this->clients_model->get_all_clients();
		$data['offline'] = 0;
		$data['online'] = 0;
		for ($i = 0; $i < count($clients);$i++){
			$fp = @fsockopen($clients[$i]['ip'], 3000, $errno, $errstr, 0.1);
			if (!$fp) {
				$data['offline']++;
			}else{
				$data['online']++;
			}
		}
		$this->load->view('header');
		$this->load->view('nav-top');
		$this->load->view('nav-left');
		$this->load->view('dashboard',$data);
		$this->load->view('footer');
	}
}
