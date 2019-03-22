<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$data = $this->db->query("select * from services;")->result();
		echo json_encode($data);
		//$this->load->view('welcome_message');
	}
}
