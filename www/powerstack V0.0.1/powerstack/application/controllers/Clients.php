<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clients extends CI_Controller {

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
		$this->load->model('scripts_model'); 
	}
	 
	public function accounts()
	{
		
		$this->load->helper('form');
		$data['scripts'] = $this->scripts_model->get_all_scripts();
		if (isset($_GET['delete'])){

			$data['clientId'] = $_GET['clientId'];
			$this->clients_model->delete_client($data);

		}else{
			if (isset($_POST['client_id'])){
				$data['client_id'] = $_POST['client_id'];
				$data['client_details'] = $this->clients_model->get_client_by_id($data);
				$data['client_groups'] = $this->clients_model->get_client_groups_by_id($data);
				$data['groups'] = $this->clients_model->get_all_groups();
			}
		}
		$data['clients'] = $this->clients_model->get_all_clients();
		$this->load->view('header');
		$this->load->view('nav-top');
		$this->load->view('nav-left');
		$this->load->view('accounts', $data);
		$this->load->view('footer');
	}
	
	public function update()
	{
		$data['clients'] = $this->clients_model->get_all_clients();
		$this->load->helper('form');
		if (isset($_POST['client_id'])){
			$data['id'] = $_POST['client_id'];
			$data['computerName'] = $_POST['computerName'];
			$data['ip'] = $_POST['ip'];
			$data['TVID'] = $_POST['TVID'];
			if (isset($_POST['status'])){
				$data['status'] = '1';
			}else{
				$data['status'] = '0';
			}
			$data['groupIds'] = $_POST['groupIds'];
			$this->clients_model->update_client($data);
			$data['client_id'] = $_POST['client_id'];
			$this->clients_model->update_client_groups($data);
			
			$data['client_details'] = $this->clients_model->get_client_by_id($data);
			$data['client_groups'] = $this->clients_model->get_client_groups_by_id($data);
			$data['groups'] = $this->clients_model->get_all_groups();

		}
		$this->load->view('header');
		$this->load->view('nav-top');
		$this->load->view('nav-left');
		$this->load->view('accounts', $data);
		$this->load->view('footer');
	}
}
