<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users extends CI_Controller {
		
	public $loggedIn;
	
	
	/*
	 * Check if logged in or not and assign it to all methods
	 */
	function __construct() {
		parent::__construct();      
		$this->loggedIn = $this->session->userdata('loggedIn');
	}

	/*
	 * User moderate links
	 */ 
	public function moderator() {
	 	if(!$this->loggedIn OR !is_moderator()) 
		{
		   redirect('/users/login');
		   exit;
		}

		$this->db->select("film_links.*, movies.film_title, movies.filmID, users.username, users.ip as ip_address,  
						(SELECT COUNT(*) as tLinks FROM film_links) as tLinks", false);
		$this->db->join("users", "users.userID = film_links.linkBy", "LEFT");
		$this->db->join("movies", "movies.filmID = film_links.mID", "LEFT");
		$this->db->from("film_links");
		$this->db->where('status', 'pending');
		$this->db->order_by("linkID", "DESC");
		$links = $this->db->get();
		
	 	$data['links_to_moderate'] = $links->result();
		
	
		$this->load->view('user-moderate', $data);
	}


	/*
	 * User moderate comments
	 */ 
	public function moderator_comments() {
		if(!$this->loggedIn OR !is_moderator()) 
		{
		   redirect('/users/login');
		   exit;
		}
		
		$removeID = $this->uri->segment(4);
		
		if($removeID) {
			$id = abs(intval($removeID));
			$this->db->delete("comments", array("commID" => $id));
			redirect('/users/moderator_comments');
		}
		
	
		$this->db->select("comments.*, movies.film_title, movies.filmID, users.username, users.ip as ip_address,  
						(SELECT COUNT(*) as tComments FROM comments) as tComments", false);
		$this->db->join("users", "users.userID = comments.commUser", "LEFT");
		$this->db->join("movies", "movies.filmID = comments.movID", "LEFT");
		$this->db->from("comments");
		$this->db->order_by("commID", "DESC");
		$comments = $this->db->get();
		
	 	$data['comments_to_moderate'] = $comments->result();

		$this->load->view('user-moderate-comments', $data);
	}
	
	
	/*
	 * User home
	 */
	public function index()
	{
		if(!$this->loggedIn) 
		{
			redirect('/users/login');
			exit;
		}
		
		if($this->input->post('sb_signup')) {
			if(!$this->input->post('email') OR !$this->input->post('password')) {
				$data['form_message'] = div_class("Email and password are required", 'alert alert-error');
			}else{
				
				$this->db->where(array("email" => $this->input->post('email', TRUE)));
				$this->db->where("userID != " . is_user_logged_in());
				$user = $this->db->get("users");
				
				if(count($user->result())) {
					$data['form_message'] = '<div class="alert alert-warning">';
					$data['form_message'] .= 'Username/Email taken, please chose another one.';
					$data['form_message'] .= '</div>';
				}else{
				
				$this->db->where("userID", is_user_logged_in());
				$this->db->update("users", array('email' => $this->input->post('email'), 
												'password' => md5($this->input->post('password')), 
												'about' => trim(strip_tags($this->input->post('about')))));
				$data['form_message'] = div_class("Account updated", 'alert alert-success');
				
				}
			}
		}
		
		$user = $this->db->get_where("users", array("userID" => is_user_logged_in()));
	 	$user = $user->row(); 
		$data['user'] = $user; 
		
		$this->load->view('user-account', $data);
	}
	
	
	/*
	 * User Login
	 */
	 public function login() {
	 	if($this->loggedIn) 
		{
			redirect('/users');
			exit;
		}
		
		$data = array();
		
		if($this->input->post('sbLogin')) {
			$user = $this->input->post('uname', TRUE);
			$pass = $this->input->post('upwd', TRUE);
			
			if(!empty($user) AND !empty($pass)) {
				$this->db->where(array("username" => $user));
				$this->db->where(array("password" => md5($pass)));
				$user = $this->db->get("users");
				
				if(count($user->result())) {
					$data['login_message'] = '<div class="alert alert-success">Ok, redirecting..</div>';
					foreach($user->result() as $u) {
						$this->session->set_userdata('loggedIn', $u->userID);
					}
					redirect('/users');
				}else{
					$data['login_message'] = '<div class="alert alert-error">Invalid user/pass</div>';
				}
				
			}else{
				$data['login_message'] = '<div class="alert alert-error">Please enter user/pass</div>';
			}
			
		}
		
		$this->load->view('login', $data);
	 }
	
	
	/*
	 * Logout function
	 */
	public function logout() {
		$this->session->unset_userdata('loggedIn');
		redirect('/users/login');
	}
	
	
	/*
	 * Register Form/Page
	 */
	public function join() {
		if($this->loggedIn) 
		{
			redirect('/users');
			exit;
		}
		
		$this->load->view('join-now');
	}
	
	
	/*
	 * Register via AJAX
	 */
	public function ajax_join() {
		
		if($this->input->post('sb_signup')) {
		
			unset($_POST['sb_signup']);
				
			$insert = array();
			
			foreach($this->input->post() as $k=>$v) {
				if($this->input->post($k, TRUE) != "") {
					$insert[$k] = $this->input->post($k, TRUE);
				}else{
					print '<div class="alert alert-warning">';
					print 'All fields are mandatory';
					print '</div>';
					exit;
				}
			}
			
			$this->db->where(array("username" => $this->input->post('username', TRUE)));
			$this->db->or_where(array("email" => $this->input->post('email', TRUE)));
			$user = $this->db->get("users");
			
			if(count($user->result())) {
				print '<div class="alert alert-warning">';
				print 'Username/Email taken, please chose another one.';
				print '</div>';
				exit;
			}
			
			$insert['ip'] = ip2long($_SERVER['REMOTE_ADDR']);
			$insert['password'] = md5($insert['password']);
			
			if($this->db->insert("users", $insert)) {
				$this->session->set_userdata('loggedIn', $this->db->insert_id());
				print '<div class="alert alert-success">';
				print 'You are now logged in. <a href="/users">My Account</a>';
				print '</div>';
			}else{
				print '<div class="alert alert-warning">';
				print 'DB Error';
				print '</div>';
			}
			
		
		}else{
			print '<div class="alert alert-warning">';
			print '-No post-';
			print '</div>';
		}
		
		
	}


	/*
	 * User Profiles
	 */
	 public function profile() {
	 	 $username = trim(strip_tags($this->uri->segment(3)));
		 
		 if(!$username) {
		 	 $data['error'] = 'User not found';
		 	 $this->load->view('user-profiles', $data); 
		 }else{
		 	$user = $this->db->get_where("users", array("username" => $username));
		 	$user = $user->row(); 
			$data['user'] = $user;
			
			if(count($user)) {
				$this->db->select("playlists.*, movies.filmID, movies.film_title, 
								  movies.thumbnail, movies.release_date, movies.rating");
				$this->db->from("playlists");
				$this->db->where("uID = $user->userID");
				$this->db->join("movies","movies.filmID = playlists.fID");
				$playlist= $this->db->get();
				$data['playlist'] = $playlist->result();
			}else{
				$data['playlist'] = new stdClass;
			}
			 
			$this->load->view('user-profiles', $data);
			
		 }
		 
	 }
	
}