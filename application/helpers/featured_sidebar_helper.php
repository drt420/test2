<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('featured_sidebar')) {
	function featured_sidebar()
	{
		$ci=& get_instance();
        $ci->load->database(); 
		
	    //get featured tv-shows
		$ci->db->order_by('filmID', 'desc');
		$ftv = $ci->db->get_where("movies", array("is_featured" => 'y'), 50);
		
		return $ftv->result();
	}
	
	
}

?>