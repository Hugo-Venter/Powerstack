<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Scripts extends CI_Controller {

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
		$this->load->model('scripts_model'); 
	}
	
	public function edit()
	{
		
		
		$this->load->helper('form');
		//print_r($this->input->post);
		if (isset($_GET['delete'])){

			$data['id'] = $_GET['script_id'];
			$this->scripts_model->delete_script($data);

		}else{
			if (isset($_POST['script_id'])){
				
				$data['groups'] = $this->scripts_model->get_all_groups();
				$data['script_id'] = $_POST['script_id'];
				$data['script_details'] = $this->scripts_model->get_script_by_id($data);
				//$data['clients'] = $this->scripts_model->get_clients_by_script_id($data);
				//print_r($data['clients'] );
				//die();
			}
		}
		$data['scripts'] = $this->scripts_model->get_all_scripts();
		$this->load->view('header');
		$this->load->view('nav-top');
		$this->load->view('nav-left');
		$this->load->view('edit_scripts', $data);

		$this->load->view('footer');
	}
	
	public function update()
	{
		
		$data['scripts'] = $this->scripts_model->get_all_scripts();
		$this->load->helper('form');
		//print_r($this->input->post);
		if (isset($_POST['script_id'])){
			
			$data['groups'] = $this->scripts_model->get_all_groups();
			$data['id'] = $_POST['script_id'];
			$data['script_id'] = $_POST['script_id'];
			$data['name'] = $_POST['name'];
			$data['data'] = $_POST['data'];
			$data['location'] = $_POST['location'];
			$data['type'] = $_POST['script_type'];
			$data['cron'] = $_POST['cron'];
			$data['description'] = $_POST['description'];
			$data['groupId'] = $_POST['groupId'];
			if (isset($_POST['status'])){
				$data['status'] = '1';
			}else{
				$data['status'] = '0';
			}
			
			$this->scripts_model->update_script($data);
			$data['script_details'] = $this->scripts_model->get_script_by_id($data);
			//$data['clients'] = $this->scripts_model->get_clients_by_script_id($data);
			//print_r($data['clients'] );
			//die();
		}
		$this->load->view('header');
		$this->load->view('nav-top');
		$this->load->view('nav-left');
		$this->load->view('edit_scripts', $data);

		$this->load->view('footer');
	}
	
	public function add_new()
	{
		
		if (isset($_POST['name'])){
			
			$data['name'] = $_POST['name'];
			$data['description'] = $_POST['description'];
			$data['data'] = $_POST['data'];
			$data['cron'] = $_POST['cron'];
			$data['type'] = $_POST['script_type'];
			if (isset($_POST['status'])){
				$data['status'] = 1;
			}else{
				$data['status'] = 0;
			}
			$data['location'] = $_POST['location'];
			$data['groupId'] = $_POST['groupId'];
			$this->scripts_model->insert_script($data);
		}
		
		$data['scripts'] = $this->scripts_model->get_all_scripts();
		$this->load->helper('form');
		$data['groups'] = $this->scripts_model->get_all_groups();
		$this->load->view('header');
		$this->load->view('nav-top');
		$this->load->view('nav-left');
		$this->load->view('new_script', $data);

		$this->load->view('footer');
	}
	
	public function remote()
	{
		
		$data['scripts'] = $this->scripts_model->get_all_scripts();
		$this->load->helper('form');
		//print_r($this->input->post);
		if (isset($_POST['script_id'])){
			$data['script_id'] = $_POST['script_id'];
			$data['script_details'] = $this->scripts_model->get_script_by_id($data);
			$data['clients'] = $this->scripts_model->get_clients_by_script_id($data);
			//print_r($data['clients'] );
			//die();
		}
		$this->load->view('header');
		$this->load->view('nav-top');
		$this->load->view('nav-left');
		$this->load->view('remote', $data);

		$this->load->view('footer_remote');
	}
}
