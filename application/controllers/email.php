<?php
/*
sends email with gmail
*/
class Email extends CI_Controller{

	 function Email(){
		parent::__construct();
	}

	function index(){
		//send_email('carlohusmillo@gmail.com', 'email sample', 'asdasdasdas');

		$config = Array(
			'protocol' => "smtp",
			'smtp_host' => "ssl://smtp.googlemail.com",
			'smtp_port' => 465,
			'smtp_user' => "user.librarian@gmail.com",
			'smtp_pass' => "userlibrarian",//password
			'mailtype'  => 'html',
			'charset' => 'utf-8'
		);

		$this->load->library("email", $config);//we pass our configuration
		$this->email->set_newline("\r\n");

		$this->email->from("user.librarian@gmail.com", "ICS Librarian");
		//sample only
		$this->email->to("carlohusmillo@yahoo.com");
		$this->email->subject("Reference Material Reservation");
		$this->email->message("Deadline bukas!");

		if($this->email->send()){//if sent successfully
			echo "your message was sent!";
		}
		else{
			show_error($this->email->print_debugger());
		}
	}

	
}