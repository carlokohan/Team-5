<?php

class Logout extends CI_Controller{
	public function Logout(){
		parent::__construct();
	}

	public function index(){
		$this->session->sess_destroy();

		$data["title"] = "Home - ICS Library System";
		redirect("home");
	}
}

?>