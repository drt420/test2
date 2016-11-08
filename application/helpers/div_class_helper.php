<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('div_class')) {
	function div_class($string, $div_class)
	{
	    return sprintf('<div class="%s">%s</div>', $div_class, $string);
	}
	
	
}

?>