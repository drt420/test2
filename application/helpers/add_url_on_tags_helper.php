<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('add_url_on_tags')) {
	function add_url_on_tags(&$item1, $key, $path)
	{
	    $item1 = anchor($path.'/'.url_title($item1), $item1);
	}
	
	
}

?>