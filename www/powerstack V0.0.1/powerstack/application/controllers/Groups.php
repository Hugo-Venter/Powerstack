<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Groups extends CI_Controller {

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
		$this->load->model('groups_model'); 
	}
	 
	public function edit()
	{

		$this->load->helper('form');
		if (isset($_GET['delete'])){

			$data['groupId'] = $_GET['groupId'];
			$this->groups_model->delete_group($data);

		}else{
			if (isset($_POST['groupId'])){
				$data['groupId'] = $_POST['groupId'];
				$data['group_details'] = $this->groups_model->get_group_by_id($data);
			}
		}
		$data['groups'] = $this->groups_model->get_all_groups();
		$this->load->view('header');
		$this->load->view('nav-top');
		$this->load->view('nav-left');
		$this->load->view('groups', $data);
		//$this->load->view('customize');
		$this->load->view('footer');
	}
	
	public function add_new()
	{
		if (isset($_POST['groupName'])){
			$data['groupName'] = $_POST['groupName'];
			$this->groups_model->insert_group($data);
		}
		$data['groups'] = $this->groups_model->get_all_groups();
		$this->load->helper('form');
		$this->load->view('header');
		$this->load->view('nav-top');
		$this->load->view('nav-left');
		$this->load->view('new_group', $data);
		//$this->load->view('customize');
		$this->load->view('footer');
	}
	
	public function update()
	{
		
		$data['groups'] = $this->groups_model->get_all_groups();
		$this->load->helper('form');
		//print_r($this->input->post);
		if (isset($_POST['groupId'])){
			$data['id'] = $_POST['groupId'];
			$data['groupName'] = $_POST['groupName'];
			$data['groupId'] = $_POST['groupId'];
			$this->groups_model->update_group($data);
			
			
			
			$data['group_details'] = $this->groups_model->get_group_by_id($data);
			$data['groups'] = $this->groups_model->get_all_groups();
			//$data['groups'] = $this->groups_model->get_client_by_id($data);
			//print_r($data['groups'] );
			//die();
		
		}

		$this->load->view('header');
		$this->load->view('nav-top');
		$this->load->view('nav-left');
		$this->load->view('groups', $data);
		//$this->load->view('customize');
		$this->load->view('footer');
	}
}
