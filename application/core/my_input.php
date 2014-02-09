<?php
/**
*	This class extends the input class to allow "[" and "]" on form input name
*	which is used for pagination.
*
*	@author Jose Carlo G. Husmillo
*/

class My_Input extends CI_Input{

	public function Home(){
		parent::__construct();
		
	}

	/**
	* Clean Keys
	*
	* This is a helper function. To prevent malicious users
	* from trying to exploit keys we make sure that keys are
	* only named with alpha-numeric text and a few other items.
	*
	* @access	private
	* @param	string
	* @return	string
	*/
	function _clean_input_keys($str)
	{
		if ( ! preg_match("/^[a-z0-9:_\/-\[\]]+$/i", $str))
		{
			exit('Disallowed Key Characters.'.$str);
		}

		// Clean UTF-8 if supported
		if (UTF8_ENABLED === TRUE)
		{
			$str = $this->uni->clean_string($str);
		}

		return $str;
	}
}