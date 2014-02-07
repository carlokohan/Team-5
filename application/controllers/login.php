<?php

class Login extends CI_Controller{
	public function Login(){
		parent::__construct();
		$this->load->model('user_model');
	}

	public function index(){
		/*$username = $_POST["username"];
		$password = md5($_POST["password"]);

		//Checks if the user is registered
		if($this->user_model->user_exists($username, $password)){
			$userData = $this->user_model->get_user_data($username, $password);

			$sessionData = array(
				'loggedIn' => true,
				'id' => $userData[0]->id,
				'user_type' => $userData[0]->user_type,
				'username' => $userData[0]->username
				);

			$this->session->set_userdata($sessionData);

			//Loads the correct view corresponding to the appropriate user
			if($userData[0]->user_type == 'A'){
				redirect("administrator");
			}else if($userData[0]->user_type == 'L'){
				redirect("librarian");
			}else if($userData[0]->user_type == 'F' || $userData[0]->user_type == 'S'){
				redirect("borrower");
			}
		}else{
			$data["title"] = "Login Failed - ICS Library System";
			$data["loginMessage"] = "Username and/or password didn't match.";

			$this->load->view("login_view", $data);
		}*/
	}
}

?>