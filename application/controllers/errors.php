<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Errors extends CI_Controller {
	
	public function index()
	{
		$this->load->view('404');
	}
	
}