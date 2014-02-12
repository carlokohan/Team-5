<?php
/**
 * Visitor model class
 *
 * @author	Jose Carlo Husmillo, Khemberly Cumal
 * @version 1.0
 */
class User_model extends CI_Model{
	/**
	*	Function gets the specified reference materials from table with matching keyword; used for pagination
	*
	*	@param $keyword (string)
	*	@return rows from db || null
	*/
	public function search_reference_material($keyword,$limit,$offset){
		if($offset == null) $offset = 0;
		return  $this->db->query("Select * from reference_material where title like '%$keyword%' order by title asc limit $offset,$limit");
	}

	/**
	*	Function gets the specified reference materials from table with matching keyword; used for pagination's
	*	total page number
	*
	*	@param $keyword (string)
	*	@return rows from db || null
	*/
	public function search_reference_material2($keyword){
		return  $this->db->query("Select * from reference_material where title like '%$keyword%' order by title asc");
	}


	/**
	*	Function gets the specified reference materials from table with matching keyword; used when first
	*	query returned 0.
	*
	*	@param $keyword (string), $limit (int), $offset(int)
	*	@return rows from db || null
	*/
	public function search_reference_material_token($keywords,$limit,$offset){
		if($offset == null) $offset = 0;

		$keyword_tokens = preg_split("/[\s,]+/", $keywords);

		$sql = "SELECT * FROM reference_material WHERE title LIKE'%";
		$sql .= implode("%' OR title LIKE '%", $keyword_tokens) . "'";
		$sql .= "order by title asc limit $offset,$limit";
		return  $this->db->query($sql);
	}

	/**
	*	Function gets the specified reference materials from table with matching keyword; used for pagination
	*
	*	@param $keywords (string)
	*	@return rows from db || null
	*/
	public function search_reference_material_token2($keywords){
		$keyword_tokens = preg_split("/[\s,!@#$\[\]\*\(\)\^<>\?\+\_\={}]+/", $keywords);

		$sql = "SELECT * FROM reference_material WHERE title LIKE'%";
		$sql .= implode("%' OR title LIKE '%", $keyword_tokens) . "'";
		$sql .= "order by title asc";
		return  $this->db->query($sql);
	}

	/**
	*	Function gets the exact reference material based from unique id; for viewing the book
	*
	*	@param $bookid (string)
	*	@return rows from db || null
	*/
	public function view_reference_material($bookid){
		return $this->db->query("Select * from reference_material where id = $bookid ");
	}

	/**
	*	Function gets the reference materials using the advanced search
	*
	*	@param $query (string)
	*	@return rows from db || null
	*/
	public function advanced_search($query){
		return $this->db->query($query);
	}

	/**
	*	Function gets the reference materials using the advanced search; without offset
	*
	*	@param $query (string)
	*	@return rows from db || null
	*/
	public function advanced_search2($query){
		return $this->db->query($query);
	}

	/**
	*	Function gets the exact transactions based from type of report (Daily, Weekly or Monthly)
	*	@param $type (string)
	*	@return rows from db || null
	*/
	public function get_data($type){
		$day = date('D');

		/*returns rows of data from selected columns of the transaction log based on current date*/
		if (strcmp($type,'daily')==0) {//reference_material_id, borrower_id, date_waitlisted, date_reserved, date_borrowed, date_returned
			return $this->db->query("Select * from transactions where date_borrowed like CURDATE()");
		} 
		/*returns rows of data from selected columns of the transasction log based on the whole week
		* can only be accessed on Fridays
		*/
		else if (strcmp($type,'weekly')==0 && $day=='Fri') {//reference_material_id, borrower_id, date_waitlisted, date_reserved, date_borrowed, date_returned
			return $this->db->query("Select * from transactions where DATE_SUB(CURDATE(), INTERVAL 4 DAY)<=date_borrowed");	
		} 
		/*returns rows of data from selected columns of the transaction log based on the whole month*/
		else if (strcmp($type,'monthly')==0) {//reference_material_id, borrower_id, date_waitlisted, date_reserved, date_borrowed, date_returned
			return $this->db->query("Select * from transactions where MONTHNAME(date_borrowed) like MONTHNAME(CURDATE())");
		}
	}


	/**
	*	Function gets the most borrowed reference material
	*	@return rows from db || null
	*/
	public function get_popular(){
		return $this->db->query("select * from reference_material where times_borrowed = (select max(times_borrowed) from reference_material)");
	}

	public function edit_profile(){}
}

?>