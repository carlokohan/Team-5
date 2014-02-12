<?php
/**
 * Main Controller class
 *
 * @author	Jose Carlo Husmillo, Khemberly E. Cumal
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

		$tempArray = array();//for keywords
		$tempArrayValues = array();//for the values
		//replace special characters with nothing
		$order  = array('\\','\/','@','!','#','&','$','%','^','*','(',')','+','=',',','.','<','>','?','[',']',':');
		$query = "";//for query

		/*
		the following codes will check if the checkbox is marked
		*/
		if(in_array("title", $_GET['projection'])){
			$keywordTitle = $this->input->get('title');
			if($keywordTitle==null){	//didn't type anything
				redirect('home');
			}

			//trim whitespaces and special characters
			$keywordTitle = ltrim($keywordTitle);
			$keywordTitle = rtrim($keywordTitle);
			$keywordTitle = str_replace($order, '', $keywordTitle);
			//we will build up the search query using string concatenation
			$query .= "title like '%$keywordTitle%'";
			array_push($tempArray,'title');	//push it to the array
			array_push($tempArrayValues,$keywordTitle);
		}
		//if author is checked
		if(in_array("author", $_GET['projection'])){
			$keywordAuthor = $this->input->get('author');
			if($keywordAuthor==null){
				redirect('home');
			}


			//trim whitespaces and special characters
			$keywordAuthor = ltrim($keywordAuthor);
			$keywordAuthor = rtrim($keywordAuthor);
			$keywordAuthor = str_replace($order, '', $keywordAuthor);
			if ( in_array('title',$tempArray) ) {
				//^ we check if previous checkboxes were marked
				$query .= " or author like '%$keywordAuthor%'";
			}
			else{
				//no other checkboxes were marked
				$query .= " author like '%$keywordAuthor%'";
			}
			array_push($tempArray,'author');
			array_push($tempArrayValues,$keywordAuthor);
		}

		//if year_published is checked
		if(in_array("year_published", $_GET['projection'])){
			$keywordYearPublished = $this->input->get('year_published');
			if($keywordYearPublished ==null){
				redirect('home');
			}
			$keywordYearPublished = ltrim($keywordYearPublished);
			$keywordYearPublished = rtrim($keywordYearPublished);
			$keywordYearPublished = str_replace($order, '', $keywordYearPublished);

			if ( in_array('title',$tempArray) || in_array('author',$tempArray)) {
				//^ we check if previous checkboxes were marked
				$query .= " or publication_year like '%$keywordYearPublished%'";
			}
			else{
				//no other checkboxes were marked
				$query .= " publication_year like '%$keywordYearPublished%'";
			}
			array_push($tempArray,'year_published');
			array_push($tempArrayValues,$keywordYearPublished);
		}
		
		//if publisher is checked
		if(in_array("publisher", $_GET['projection'])){
			$keywordPublisher = $this->input->get('publisher');
			if($keywordPublisher==null){
				redirect('home');
			}
			
			$keywordPublisher = ltrim($keywordPublisher);
			$keywordPublisher = rtrim($keywordPublisher);
			$keywordPublisher = str_replace($order, '', $keywordPublisher);
			if ( in_array('title',$tempArray) || in_array('author',$tempArray) || in_array('year_published', $tempArray)) {
				//^ we check if previous checkboxes were marked
				$query .= " or publisher like '%$keywordPublisher%'";
			}
			else{
				//no other checkboxes were marked
				$query .= " publisher like '%$keywordPublisher%'";
			}
			array_push($tempArray,'publisher');
			array_push($tempArrayValues,$keywordPublisher);
		}

		//if course_code is checked
		if(in_array('course_code',$_GET['projection'])){
	    	$keywordCourseCode = $this->input->get('course_code');
	    	if($keywordCourseCode==null){
	    		redirect('home');
			}

			$keywordCourseCode = ltrim($keywordCourseCode);
			$keywordCourseCode = rtrim($keywordCourseCode);
			$keywordCourseCode = str_replace($order, '', $keywordCourseCode);
			if ( in_array('title',$tempArray) || in_array('author',$tempArray) || in_array('year_published', $tempArray) || in_array('publisher', $tempArray)) {
				//^ we check if previous checkboxes were marked
				$query .= " or course_code like '%$keywordCourseCode%'";
			}
			else{
				//no other checkboxes were marked
				$query .= " course_code like '%$keywordCourseCode%'";
			}
			array_push($tempArray,'course_code');
			array_push($tempArrayValues,$keywordCourseCode);
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
//------------modify
		$reftype = $this->input->get('reftype');
		//var_dump($reftype);

		//we need this for the pagination uri
		$q1 = $tempArray[array_search('title', $tempArray)];
		$q2 = $tempArray[array_search('author', $tempArray)];
		$q3 = $tempArray[array_search('year_published', $tempArray)];
		$q4 = $tempArray[array_search('publisher', $tempArray)];
		$q5 = $tempArray[array_search('course_code', $tempArray)];
		if(!isset($_GET['per_page']) || $_GET['per_page'] == null)
			$_GET['per_page'] = 0;


		$data['temparray'] = $tempArray;
		$data['temparrayvalues'] = $tempArrayValues;
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
			//$tempArrayValues[array_search('title')]
			/*
SELECT * FROM `reference_material` WHERE title like '%a%' or author like '%carlo%' IN (Select * from `reference_material` where category = 'B')
			*/

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
