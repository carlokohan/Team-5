<?php

class Report_Controller extends CI_Controller{
	public function Home(){
		parent::__construct();

	}

	public function index(){
		$data["title"] = "Home - ICS Library System";
		$this->load->view("report_generation_view", $data);
	}


	public function view_report(){
		$data['title'] = "Book - ICS Library System";
		$this->load->library('fpdf/fpdf');
		//call function from model
		$this->load->view('pdf_report_view', $data);
	}
}	
