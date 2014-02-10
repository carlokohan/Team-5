<?php
/**
 * Main Controller class
 *
 * @author	Jose Carlo Husmillo, Khemberly Cumal
 * @version 1.0
 */
class Home extends CI_Controller{

	/**
	 * Main controller class' constructor
	 *
	 * @access	public
	 */
	public function Home(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->helper('url');
		$this->load->helper('date');
		$this->load->library('pagination');
	}

	/**
	 * Home class' main function
	 *
	 * @access	public
	 */
	public function index(){
		$data["title"] = "Home - ICS Library System";
		$this->load->view("home_view", $data);
	}

	/**
	*	Function calls the model function responsible for retrieving data
	*	@access	public
	*/
	public function search_reference(){
		$data["title"] = "Search - ICS Library System";
		$keyword = $this->input->get('keyword');
		$keyword = ltrim($keyword);
		$keyword = rtrim($keyword);
		//replace special characters with nothing
		$order  = array('\\','\/','@','!','#','&','$','%','^','*','(',')','+','=',',','.','<','>','?','[',']',':');
		$keyword = str_replace($order, '', $keyword);
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
			if(!isset($_GET['per_page']))//used for pagination
				$_GET['per_page'] = 0;
			
			$result1 = $this->user_model->search_reference_material($keyword,$config['per_page'],$_GET['per_page']);
			
			if($result1->num_rows() > 0){
				$data['rows'] = $result1->result();
				$config['total_rows'] = $this->user_model->search_reference_material2($keyword)->num_rows();
				//^we get all rows
				
				$this->pagination->initialize($config);

				$data['totalrefmat'] = $config['total_rows'];//we use this to display some info
				$this->load->view('search_results_view', $data);
			}
			//if there are no results, it means there are more keywords
			else{
				$data['rows'] = null;	// resets to null
				//get the rows with tokenizer
				$result = $this->user_model->search_reference_material_token($keyword,$config['per_page'],$_GET['per_page']);
				
				if($result->num_rows() > 0){

					$data['rows'] = $result->result();
					$temp = $this->user_model->search_reference_material_token2($keyword);
					$config['total_rows'] = $temp->num_rows();
					$this->pagination->initialize($config);

					$data['totalrefmat'] = $temp->num_rows();
					$this->load->view('search_results_view', $data);
				}
				else{
					//it means that no reference material is found
					//test case only
					$this->load->view('no_materials_view',$data);
				}
			}
			
		}

	}

	/**
	*	Function displays all information of the book
	*	@access	public
	*/
	public function view_reference(){
		$data['title'] = "Book - ICS Library System";

		$bookid = $this->uri->segment(3);
		$result = $this->user_model->view_reference_material($bookid);
		$data['rows'] = $result->result();
		$this->load->view('view_results_view', $data);
	}


	
	/**
	* Function calls the model function responsible for retrieving data; it processes those
	* checkboxes that has been ticked
	*	@access	public
	*/
	public function advanced_search_reference(){
		$data["title"] = "Advanced Search - ICS Library System";

		$temparray = array();//for keywords
		$temparrayvalues = array();//for the values
		//replace special characters with nothing
		$order  = array('\\','\/','@','!','#','&','$','%','^','*','(',')','+','=',',','.','<','>','?','[',']',':');
		$query = "";//for query

		/*
		the following codes will check if the checkbox is marked
		*/
		if(in_array("title", $_GET['projection'])){
			$keyword_title = $this->input->get('title');
			if($keyword_title==null){	//didn't type anything
				redirect('home');
			}

			//trim whitespaces and special characters
			$keyword_title = ltrim($keyword_title);
			$keyword_title = rtrim($keyword_title);
			$keyword_title = str_replace($order, '', $keyword_title);
			//we will build up the search query using string concatenation
			$query .= "title like '%$keyword_title%'";
			array_push($temparray,'title');	//push it to the array
			array_push($temparrayvalues,$keyword_title);
		}
		//if author is checked
		if(in_array("author", $_GET['projection'])){
			$keyword_author = $this->input->get('author');
			if($keyword_author==null){
				redirect('home');
			}


			//trim whitespaces and special characters
			$keyword_author = ltrim($keyword_author);
			$keyword_author = rtrim($keyword_author);
			$keyword_author = str_replace($order, '', $keyword_author);
			if ( in_array('title',$temparray) ) {
				//^ we check if previous checkboxes were marked
				$query .= " or author like '%$keyword_author%'";
			}
			else{
				//no other checkboxes were marked
				$query .= " author like '%$keyword_author%'";
			}
			array_push($temparray,'author');
			array_push($temparrayvalues,$keyword_author);
		}

		//if year_published is checked
		if(in_array("year_published", $_GET['projection'])){
			$keyword_year_published = $this->input->get('year_published');
			if($keyword_year_published ==null){
				redirect('home');
			}
			$keyword_year_published = ltrim($keyword_year_published);
			$keyword_year_published = rtrim($keyword_year_published);
			$keyword_year_published = str_replace($order, '', $keyword_year_published);

			if ( in_array('title',$temparray) || in_array('author',$temparray)) {
				//^ we check if previous checkboxes were marked
				$query .= " or publication_year like '%$keyword_year_published%'";
			}
			else{
				//no other checkboxes were marked
				$query .= " publication_year like '%$keyword_year_published%'";
			}
			array_push($temparray,'year_published');
			array_push($temparrayvalues,$keyword_year_published);
		}
		
		//if publisher is checked
		if(in_array("publisher", $_GET['projection'])){
			$keyword_publisher = $this->input->get('publisher');
			if($keyword_publisher==null){
				redirect('home');
			}
			
			$keyword_publisher = ltrim($keyword_publisher);
			$keyword_publisher = rtrim($keyword_publisher);
			$keyword_publisher = str_replace($order, '', $keyword_publisher);
			if ( in_array('title',$temparray) || in_array('author',$temparray) || in_array('year_published', $temparray)) {
				//^ we check if previous checkboxes were marked
				$query .= " or publisher like '%$keyword_publisher%'";
			}
			else{
				//no other checkboxes were marked
				$query .= " publisher like '%$keyword_publisher%'";
			}
			array_push($temparray,'publisher');
			array_push($temparrayvalues,$keyword_publisher);
		}

		//if course_code is checked
		if(in_array('course_code',$_GET['projection'])){
	    	$keyword_course_code = $this->input->get('course_code');
	    	if($keyword_course_code==null){
	    		redirect('home');
			}

			$keyword_course_code = ltrim($keyword_course_code);
			$keyword_course_code = rtrim($keyword_course_code);
			$keyword_course_code = str_replace($order, '', $keyword_course_code);
			if ( in_array('title',$temparray) || in_array('author',$temparray) || in_array('year_published', $temparray) || in_array('publisher', $temparray)) {
				//^ we check if previous checkboxes were marked
				$query .= " or course_code like '%$keyword_course_code%'";
			}
			else{
				//no other checkboxes were marked
				$query .= " course_code like '%$keyword_course_code%'";
			}
			array_push($temparray,'course_code');
			array_push($temparrayvalues,$keyword_course_code);
		}
		//the default sort is by title ascending
		$sort="order by title asc";

		//we check what radio button is marked then we put the appropriate query
		if(isset($_GET['sort'])){
			if($_GET['sort'] == 'sortalpha'){
				$sort = "order by title asc";
			}
			elseif ($_GET['sort'] == 'sortbeta') {
				$sort = "order by title desc";
			}
			elseif ($_GET['sort'] == 'sortyear') {
				$sort = "order by publication_year desc";
			}
			else{
				$sort = "order by author asc";
			}
		}

		//we need this for the pagination uri
		$q1 = $temparray[array_search('title', $temparray)];
		$q2 = $temparray[array_search('author', $temparray)];
		$q3 = $temparray[array_search('year_published', $temparray)];
		$q4 = $temparray[array_search('publisher', $temparray)];
		$q5 = $temparray[array_search('course_code', $temparray)];
		if(!isset($_GET['per_page']) || $_GET['per_page'] == null)
			$_GET['per_page'] = 0;


		$data['temparray'] = $temparray;
		$data['temparrayvalues'] = $temparrayvalues;
		$config['per_page'] = 10;
		$config['base_url'] = base_url("index.php/home/advanced_search_reference?projection%5B%5D={$q1}&title={$_GET['title']}&projection%5B%5D={$q2}&author={$_GET['author']}&projection%5B%5D={$q3}&year_published={$_GET['year_published']}&projection%5B%5D={$q4}&publisher={$_GET['publisher']}&projection%5D%5B={$q5}&course_code={$_GET['course_code']}");
		$config['num_links']= 10;
		$config['page_query_string'] = TRUE;
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		//we run the query
		$result = $this->user_model->advanced_search("Select * from reference_material where {$query} {$sort} limit {$_GET['per_page']},{$config['per_page']}");
		$result2 = $this->user_model->advanced_search("Select * from reference_material where {$query} {$sort}");
		if($result->num_rows() > 0){
			$data['rows'] = $result->result();

			$config['total_rows'] = $result2->num_rows();//set the total number of rows
			$this->pagination->initialize($config);
			$data['totalrefmat'] = $result2->num_rows();
			$this->load->view('search_results_view', $data);
		}
		else{
			//it means that no reference material is found
			$this->load->view('no_materials_view',$data);

			//we previously stored in the array the values of those that are checked;
			//$temparrayvalues[array_search('title')]

		}

	}

	/**
	* Loads the advanced search view
	*	@access	public
	*/
	public function load_advanced_search(){
		$data['title'] = "Advanced Search - ICS Library System";

		$this->load->view('advanced_search_view',$data);

		
	}
}
?>