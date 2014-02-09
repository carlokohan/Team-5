<?php
/**
 * Report generating class using FPDF
 *
 * @author	Jose Carlo Husmillo, Jan Claudette Quevedo
 * @version 1.0
 */
class Report_Controller extends CI_Controller{

	/**
	 * Report generating class' constructor
	 *
	 * @access	public
	 */
	public function Home(){
		parent::__construct();

	}

	/**
	 * Email class constructor
	 *
	 * @access	public
	 */
	public function index(){
		$data["title"] = "Home - ICS Library System";
		$this->load->view("report_generation_view", $data);
	}


	public function view_report(){
		$data['title'] = "Report - ICS Library System";
		$this->load->library('fpdf/fpdf')
		$this->load->model('user_model');
		$type = $_POST['print_by'];
		$result = $this->user_model->get_data($type);
		$data['result'] = $result->result();
		$this->load->view('pdf_report_view', $data);
	}
}	
