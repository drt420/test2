<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('genres_dropdown')) {
	function genres_dropdown()
	{
		$ci=& get_instance();
        $ci->load->database(); 
		
	    //get comments
		$ci->db->select("*");
		$ci->db->from("genres");
		$ci->db->order_by("genre", "asc"); 
		$comments = $ci->db->get();
		$comments = $comments->result();
		
		return $comments;
	}
	
	
}

?>