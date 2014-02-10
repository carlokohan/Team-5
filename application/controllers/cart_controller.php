<?php
/**
 * Cart class
 *
 * @author	Jose Carlo Husmillo, Alyssa Bianca Cos
 * @version 1.0
 */
class Cart_Controller extends CI_Controller{

	public function Home(){
		parent::__construct();
		
	}

	/**
	* Function adds the reference material to the cart
	* @access public
	*/
	public function add_to_cart(){
		
		$this->load->model('user_model');
		$this->load->helper('url');
		$data['title'] = "Cart - ICS Library System";

		$bookid = $this->uri->segment(3);
		$result = $this->user_model->view_reference_material($bookid);//we reused the function in which we view the details of the book
		foreach ($result->result() as $row){
		    $bookyear = $row->publication_year;
		    $booktitle = $row->title;
		    $bookauthor = $row->author;
		    $bookcode = strtoupper($row->course_code);
		}

		$qart = array(
               'id'      => $bookid,
               'qty'     => 1,
               'price'   => 1.00,
               'name'    => 'Book',
               'options' => array('Title' => $booktitle,'Year' => $bookyear, 'Author' => $bookauthor, 'Bookcode' => $bookcode)
            );

		$this->cart->insert($qart);

		$this->load->view('cart_view',$data);
	}

	/**
	* Function to view the cart on a different page
	* @access public
	*/
	public function view_cart(){
		$data['title'] = "Cart - ICS Library System";
		//var_dump($_SERVER['REQUEST_URI']);
		$this->load->view('cart_view',$data);
	}

	/**
	* Function to empty the contents of the cart
	* @access public
	*/
	public function empty_cart(){
		$this->cart->destroy();
		redirect('home');
	}

	/**
	* Function to delete the selected items on the cart
	* @access public
	*/
	public function remove_selected(){
		$total = $this->cart->total();
 
		for ($i=1; $i < $total+1 ; $i++) { 
			$strname = "cart".$i;
			$bookid = $this->input->post($strname);

			if($bookid != null){	//if $bookid is set (checked), delete
				$data = array(  
		              'rowid' => $bookid, 
		              'qty'   => 0 //setting qty to zero would delete it from cart
		           );  
				
				$this->cart->update($data); 
			}

		}
		$data['title'] = "Cart - ICS Library System";
		$this->load->view('cart_view',$data);
		
	}
}