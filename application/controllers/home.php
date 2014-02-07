<?php

class Home extends CI_Controller{

	public function Home(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->helper('url');
		$this->load->helper('date');
		$this->load->library('pagination');
	}

	public function index(){
		$data["title"] = "Home - ICS Library System";
		$this->load->view("home_view", $data);
	}

	/**
	*	function calls the model function responsible for retrieving data
	*/
	public function search_reference(){
		$data["title"] = "Home - ICS Library System";
		$keyword = $this->input->get('keyword');

		$config['per_page'] = 10;
		$config['base_url'] = base_url("index.php/home/search_reference?keyword={$_GET['keyword']}");
		$config['num_links']= 10;
		$config['page_query_string'] = TRUE;
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';

		if($keyword==null){
			redirect("home");
			//empty keyword
		}
		else{
			if(!isset($_GET['per_page']))
				$_GET['per_page'] = 0;
			
			$result1 = $this->user_model->search_reference_material($keyword,$config['per_page'],$_GET['per_page']);
			
			if($result1->num_rows() > 0){
				$data['rows'] = $result1->result();
				$temp = $this->user_model->search_reference_material2($keyword);
				$config['total_rows'] = $temp->num_rows();//set the total number of rows
				$this->pagination->initialize($config);

				$this->load->view('cart_view',$data);
				$this->load->view('search_results_view', $data);
			}
			else{
				$data['rows'] = null;	// resets to null
				$result = $this->user_model->search_reference_material_token($keyword,$config['per_page'],$_GET['per_page']);
				
				if($result->num_rows() > 0){

					$data['rows'] = $result->result();
					$temp = $this->user_model->search_reference_material_token2($keyword);
					$config['total_rows'] = $temp->num_rows();
					$this->pagination->initialize($config);
					$this->load->view('cart_view',$data);
					$this->load->view('search_results_view', $data);
				}
				else{
					//test case only
					$this->load->view('no_materials_view',$data);
					
				}
			}
			
		}

	}

	/**
	* Function displays all information of the book
	*/
	public function view_reference(){
		$data['title'] = "Book - ICS Library System";

		$bookid = $this->uri->segment(3);
		$result = $this->user_model->view_reference_material($bookid);
		$data['rows'] = $result->result();
		$this->load->view('view_results_view', $data);
	}


	
	/**
	*	function calls the model function responsible for retrieving data
	*/
	public function advanced_view_reference(){
		$data["title"] = "Home - ICS Library System";

		$booktitle="";
		$bookauthor="";
		$bookyear="";

		$temparray = array();//for keywords
		$temparrayvalues = array();//for the values

		$query = "";//for query

		if(in_array("title", $_POST['projection'])){
			$keyword_title = $this->input->post('title');
			if($keyword_title==null){
				echo "please insert title <br />";
				return;
			}

			$query .= "title like '%$keyword_title%'";
			array_push($temparray,'title');
			array_push($temparrayvalues,$keyword_title);
		}
		
		if(in_array("author", $_POST['projection'])){
			$keyword_author = $this->input->post('author');
			if($keyword_author==null){
				echo "please insert name of the author <br />";
				return;
			}

			if ( in_array('title',$temparray) ) {
				$query .= " or author like '%$keyword_author%'";
			}
			else{
				$query .= " author like '%$keyword_author%'";
			}
			array_push($temparray,'author');
			array_push($temparrayvalues,$keyword_author);
		}

		if(in_array("year_published", $_POST['projection'])){
			$keyword_year_published = $this->input->post('year_published');
			if($keyword_year_published ==null){
				echo "please insert the year published <br />";
				return;
			}

			if ( in_array('title',$temparray) || in_array('author',$temparray)) {
				$query .= " or publication_year like '%$keyword_year_published%'";
			}
			else{
				$query .= " publication_year like '%$keyword_year_published%'";
			}
			array_push($temparray,'year_published');
			array_push($temparrayvalues,$keyword_year_published);
		}
		
		if(in_array("publisher", $_POST['projection'])){
			$keyword_publisher = $this->input->post('publisher');
			if($keyword_publisher==null){
				echo "please insert the publisher <br />";
				return;
			}
			
			if ( in_array('title',$temparray) || in_array('author',$temparray) || in_array('year_published', $temparray)) {
				$query .= " or publisher like '%$keyword_publisher%'";
			}
			else{
				$query .= " publisher like '%$keyword_publisher%'";
			}
			array_push($temparray,'publisher');
			array_push($temparrayvalues,$keyword_publisher);
		}

		if(in_array('course_code',$_POST['projection'])){
	    	$keyword_course_code = $this->input->post('course_code');
	    	if($keyword_course_code==null){
				echo "please insert the course code <br />";
				return;
			}

			if ( in_array('title',$temparray) || in_array('author',$temparray) || in_array('year_published', $temparray) || in_array('publisher', $temparray)) {
				$query .= " or course_code like '%$keyword_course_code%'";
			}
			else{
				$query .= " course_code like '%$keyword_course_code%'";
			}
			array_push($temparray,'course_code');
			array_push($temparrayvalues,$keyword_course_code);
		}


		/*$config['per_page'] = 10;
		$config['base_url'] = base_url()."index.php/home/advanced_view_reference?keyword={$_GET['keyword']}";
		$config['num_links']= 10;
		$config['page_query_string'] = TRUE;
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
*/
		$realquery = "Select * from reference_material where {$query} order by title asc";
		$result = $this->user_model->advanced_search($realquery);
		if($result->num_rows() > 0){
			$data['rows'] = $result->result();

			//$config['total_rows'] = $result->num_rows();//set the total number of rows
			//$this->pagination->initialize($config);

			$this->load->view('search_results_view', $data);
		}


	}

	
	
}
?>