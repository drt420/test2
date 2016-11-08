<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('latest_comments')) {
	function latest_comments()
	{
		$ci=& get_instance();
        $ci->load->database(); 
		
	    //get comments
		$ci->db->select("commID, comment, comm_date, userID, username, filmID, film_title");
		$ci->db->from("comments");
		$ci->db->join('users', 'comments.commUser = users.userID');
		$ci->db->join('movies', 'comments.movID = movies.filmID');
		$ci->db->limit(2);
		$ci->db->order_by("commID", "desc"); 
		$comments = $ci->db->get();
		$comments = $comments->result();
		
		return $comments;
	}
	
	
}

?>