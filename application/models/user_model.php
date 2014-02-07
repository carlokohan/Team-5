<?php

class User_model extends CI_Model{
	/**
	*	Function gets the specified reference materials from table with matching keyword
	*	@param $keyword (string)
	*	@return rows from db || null
	*/
	public function search_reference_material($keyword,$limit,$offset){
		if($offset == null) $offset = 0;
		return  $this->db->query("Select * from reference_material where title like '%$keyword%' order by title asc limit $offset,$limit");
	}

	/**
	*	Function gets the specified reference materials from table with matching keyword
	*	@param $keyword (string)
	*	@return rows from db || null
	*/
	public function search_reference_material2($keyword){
		return  $this->db->query("Select * from reference_material where title like '%$keyword%' order by title asc");
	}


	/**
	*	Function gets the specified reference materials from table with matching keyword
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
	*	Function gets the specified reference materials from table with matching keyword
	*	@param $keywords (string)
	*	@return rows from db || null
	*/
	public function search_reference_material_token2($keywords){
		$keyword_tokens = preg_split("/[\s,]+/", $keywords);

		$sql = "SELECT * FROM reference_material WHERE title LIKE'%";
		$sql .= implode("%' OR title LIKE '%", $keyword_tokens) . "'";
		$sql .= "order by title asc";
		return  $this->db->query($sql);
	}

	/**
	*	Function gets the exact reference material based from unique id
	*	@param $bookid (string)
	*	@return rows from db || null
	*/
	public function view_reference_material($bookid){
		return $this->db->query("Select * from reference_material where id = $bookid ");
	}

	/**
	*	Function gets the exact reference material based from unique id
	*	@param $query (string)
	*	@return rows from db || null
	*/
	public function advanced_search($query){
		return $this->db->query($query);
	}

	
	public function edit_profile(){}
}

?>