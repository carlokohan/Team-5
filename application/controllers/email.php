<?php
/**
 * Email sending class
 *
 * @author	Jose Carlo Husmillo, Alyssa Bianca Cos
 * @version 1.0
 */
class Email extends CI_Controller{

	/**
	 * Email class constructor
	 *
	 * @access	public
	 */
	function Email(){
		parent::__construct();
		$this->load->model('user_model');
	}

	/**
	 * Email class' main function
	 *
	 * @access	public
	 */
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

		$date = date('Y-m-d H:m:s');
		$newdate = strtotime ( '+3 day' , strtotime( $date ));
		$newdate = date('F j, Y',$newdate);

		$this->load->library("email", $config);//we pass our configuration
		$this->email->set_newline("\r\n");

		$this->email->from("user.librarian@gmail.com", "ICS Librarian");
		//sample only
		$this->email->to("carlohusmillo@gmail.com");
		$this->email->subject("Reference Material Reservation");
		$this->email->message('Your <b>reservation</b> is due on: <h1>'.$newdate.'</h1>Please be guided.<br/><br/>-Librarian');

		if($this->email->send()){//if sent successfully
			echo "your message was sent!";
		}
		else{
			redirect('home');
		}
	}

	/**
	 * Email template for the admin
	 *
	 * @access	public
	 */
	function email_template(){
		$data["title"] = "Home - ICS Library System";
		$this->load->view("admin_mail_all", $data);
	}	

	/**
	 * Function to mail all users
	 *
	 * @access	public
	 */
	function email_all(){
		$data["title"] = "Home - ICS Library System";
		$this->load->view("admin_mail_all", $data);
		$result = $this->user_model->get_all_users();
			
		if($result->num_rows() > 0){
			$data['rows'] = $result->result();
				//^we get all rows
			redirect('home');
		}
		else{
			redirect('home');
		}
	}
}