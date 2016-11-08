<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('is_moderator')) {
	function is_moderator() {
		  $CI =& get_instance(); 
		  $CI->load->database(); 
		  
		  $userID = $CI->session->userdata('loggedIn');

		  if(!$userID) return false;

		  //check into database
		  $CI->db->select("role");
		  $user = $CI->db->get_where("users", array("userID" => $userID));

		  if(count($user->row())) {
		  	 if($user->row()->role == 'moderator') return true;
		  }

		  return false;
	}
}

?>