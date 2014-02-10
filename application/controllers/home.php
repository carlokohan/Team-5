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
		$config['display_pages'] = FALSE;

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

				$data['totalrefmat'] = $temp->num_rows();
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

					$data['totalrefmat'] = $temp->num_rows();
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
		if(in_array("title", $_GET['projection'])){
			$keyword_title = $this->input->get('title');
			if($keyword_title==null){
				redirect('home');
			}

			//trim whitespaces
			$keyword_title = ltrim($keyword_title);
			$keyword_title = rtrim($keyword_title);
			$keyword_title = str_replace($order, '', $keyword_title);
			$query .= "title like '%$keyword_title%'";
			array_push($temparray,'title');
			array_push($temparrayvalues,$keyword_title);
		}
		
		if(in_array("author", $_GET['projection'])){
			$keyword_author = $this->input->get('author');
			if($keyword_author==null){
				redirect('home');
			}


			$keyword_author = ltrim($keyword_author);
			$keyword_author = rtrim($keyword_author);
			$keyword_author = str_replace($order, '', $keyword_author);
			if ( in_array('title',$temparray) ) {
				$query .= " or author like '%$keyword_author%'";
			}
			else{
				$query .= " author like '%$keyword_author%'";
			}
			array_push($temparray,'author');
			array_push($temparrayvalues,$keyword_author);
		}

		if(in_array("year_published", $_GET['projection'])){
			$keyword_year_published = $this->input->get('year_published');
			if($keyword_year_published ==null){
				redirect('home');
			}
			$keyword_year_published = ltrim($keyword_year_published);
			$keyword_year_published = rtrim($keyword_year_published);
			$keyword_year_published = str_replace($order, '', $keyword_year_published);

			if ( in_array('title',$temparray) || in_array('author',$temparray)) {
				$query .= " or publication_year like '%$keyword_year_published%'";
			}
			else{
				$query .= " publication_year like '%$keyword_year_published%'";
			}
			array_push($temparray,'year_published');
			array_push($temparrayvalues,$keyword_year_published);
		}
		
		if(in_array("publisher", $_GET['projection'])){
			$keyword_publisher = $this->input->get('publisher');
			if($keyword_publisher==null){
				redirect('home');
			}
			
			$keyword_publisher = ltrim($keyword_publisher);
			$keyword_publisher = rtrim($keyword_publisher);
			$keyword_publisher = str_replace($order, '', $keyword_publisher);
			if ( in_array('title',$temparray) || in_array('author',$temparray) || in_array('year_published', $temparray)) {
				$query .= " or publisher like '%$keyword_publisher%'";
			}
			else{
				$query .= " publisher like '%$keyword_publisher%'";
			}
			array_push($temparray,'publisher');
			array_push($temparrayvalues,$keyword_publisher);
		}

		if(in_array('course_code',$_GET['projection'])){
	    	$keyword_course_code = $this->input->get('course_code');
	    	if($keyword_course_code==null){
	    		redirect('home');
			}

			$keyword_course_code = ltrim($keyword_course_code);
			$keyword_course_code = rtrim($keyword_course_code);
			$keyword_course_code = str_replace($order, '', $keyword_course_code);
			if ( in_array('title',$temparray) || in_array('author',$temparray) || in_array('year_published', $temparray) || in_array('publisher', $temparray)) {
				$query .= " or course_code like '%$keyword_course_code%'";
			}
			else{
				$query .= " course_code like '%$keyword_course_code%'";
			}
			array_push($temparray,'course_code');
			array_push($temparrayvalues,$keyword_course_code);
		}
		$sort="order by title asc";

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
		$config['base_url'] = base_url()."index.php/home/advanced_search_reference?projection%5B%5D={$q1}&title={$_GET['title']}&projection%5B%5D={$q2}&author={$_GET['author']}&projection%5B%5D={$q3}&year_published={$_GET['year_published']}&projection%5B%5D={$q4}&publisher={$_GET['publisher']}&projection%5D%5B={$q5}&course_code={$_GET['course_code']}";
		$config['num_links']= 10;
		$config['page_query_string'] = TRUE;
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		$config['display_pages'] = FALSE;
		
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
			var_dump($keyword_title);
			echo 'under construction';
		}

	}

	
	public function load_advanced_search(){
		$data['title'] = "Advanced Search - ICS Library System";

		$this->load->view('advanced_search_view',$data);
	}
}
?>