<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Download extends CI_Controller {

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
	 
	public function index()
	{
		$this->load->view('header');
		$this->load->view('nav-top');
		$this->load->view('nav-left');
		$this->load->view('download');
		//$this->load->view('customize');
		$this->load->view('footer');
	}
}
