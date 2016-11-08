<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('related_sidebar')) {

	function related_sidebar($genreID, $filmID)
	{
		$ci=& get_instance();
        $ci->load->database(); 
		

		$genres = stristr($genreID, ',') ? explode(",", $genreID) : array($genreID);

		$in_string = '(';
		foreach($genres as $g) {
			$in_string .= 'FIND_IN_SET (' . (int) $g . ', genres) OR ';
		}
		$in_string = rtrim($in_string, 'OR ') . ')';

		$ci->db->where($in_string);
		$ci->db->order_by('filmID', 'desc');
		$ftv = $ci->db->get_where("movies", array("filmID !=" => $filmID ), 6, 0);

		#echo $ci->db->last_query();

		return $ftv->result();
	}
	
	
}

?>