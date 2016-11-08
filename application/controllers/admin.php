<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {


	public $admin_loggedIn;
	
	/*
	 * Check if logged in or not and assign it to all methods
	 */
	function __construct() {
		parent::__construct();      
		$this->admin_loggedIn = $this->session->userdata('admin_loggedIn');
	}
	
	
	/*
	 * Login admin
	 */
	public function login()
	{
		if($this->admin_loggedIn) 
		{
			redirect('/admin');
			exit;
		}
		
		$data = array();
		
		if($this->input->post('sbLogin')) {
			if(!$this->input->post('u') OR !$this->input->post('p')) {
				$data['form_message'] = div_class("username and password are required to login", 'alert alert-error');
			}else{
				
				if($this->input->post('u', TRUE) == $this->config->item('admin_user') 
					AND md5($this->input->post('p', TRUE)) == $this->config->item('admin_pass')) {
						$this->session->set_userdata("admin_loggedIn", TRUE);
						redirect('/admin');
				}else{
					$data['form_message'] = div_class("Wrong credentials", 'alert alert-error');	
				}
						
			}
		}
		
		$this->load->view('admin-login', $data);
	}
	
	/*
	 * Index / Movies Admin
	 */
	public function index() {
		if(!$this->admin_loggedIn) 
		{
			redirect('/admin/login');
			exit;
		}
		
		$removeID = $this->uri->segment(4);
		
		if($removeID) {
			$id = abs(intval($removeID));
			$this->db->delete("movies", array("filmID" => $id));
			$this->db->delete("film_links", array("mID" => $id));
			$this->db->delete("comments", array("movID" => $id));
			redirect('/admin');
		}
		
		$this->db->select("movies.*,(SELECT COUNT(*) as tPending FROM film_links WHERE mID = movies.filmID and status = 'pending') as tPending, 
						 (SELECT COUNT(*) AS tL FROM film_links WHERE mID = movies.filmID) AS tL", FALSE);
		$this->db->order_by("filmID", "DESC");
		$movies = $this->db->get("movies"); 
		$data['movies'] = $movies->result();
		
		$this->load->view('admin', $data);
	}	
	
	/*
	 * Movie Links
	 */
	 public function movielinks() {

	 	$this->load->helper('is_moderator');


	 	if(!$this->admin_loggedIn AND !is_moderator()) 
		{
		   redirect('/admin/login');
		   exit;
		}

	 	$id = $this->uri->segment(3);
		$removeID = $this->uri->segment(5);
		$approveID = $this->uri->segment(6);
		
		if($removeID AND ($removeID != 'approve')) {
			$this->db->delete("film_links", array("linkID" => $removeID));
			if(!is_moderator()) : 
				redirect("/admin/movielinks/" . $id);
			else:
				redirect("/users/moderator");
			endif;
		}
		
		if($approveID) {
			$delid = abs(intval($approveID));

			if($delid > 0) {
				$this->db->where("linkID = " . $delid);
				$this->db->update("film_links", array("status" => "approved"));

				if(!is_moderator()) : 
					redirect("/admin/movielinks/" . $id);
				else:
					redirect("/users/moderator");
				endif;
			}

		}
		
	 	if($this->admin_loggedIn) {
		 	$this->db->select("film_links.*, film_title, username");
		 	$this->db->where("mID = $id");
			$this->db->join("movies", "movies.filmID = film_links.mID");
			$this->db->join("users", "users.userID = film_links.linkBy", "LEFT");
			$this->db->order_by("link_tab", "ASC");
		 	$db = $this->db->get("film_links");
			
			
			$data['movieID'] = $id;
		 	$data['links'] = $db->result();
		 	$this->load->view('admin-links', $data);
	 	}else{
	 		echo 'Not allowed to view';
	 	}
	 }

	 public function movielinksedit() {
	 	$this->load->helper('is_moderator');

	 	if(!$this->admin_loggedIn AND !is_moderator()) 
		{
		   redirect('/admin/login');
		   exit;
		}

		$movieID = $this->uri->segment(3);
	 	$linkID = $this->uri->segment(4);
	 	$data['movieID'] = $movieID;

	 	if($linkID) {

	 	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	 		$title = (string) trim(strip_tags($this->input->post('link_title')));
			$link = $this->input->post('movie_link');
			$tab = (string) trim(strip_tags($this->input->post('link_tab')));
			$link_type = (string) trim(strip_tags($this->input->post('link_type')));

	 		$insert['link_tab'] = $tab;
			$insert['link_title'] = $title;
			$insert['link_destination'] = $link;
			$insert['link_type'] = $link_type;

			$this->db->where('linkID', $linkID);
			$this->db->update("film_links", $insert);

			$go_back_link = is_moderator() ? '<a href="/users/moderator">Go back</a>' : '<a href="/admin/movielinks/'.$movieID.'">Go back</a>';
			$data['msg'] = '<div class="alert alert-success">Movie link successfully updated. '.$go_back_link.'</div>';

	 	}

	 	$this->db->where('linkID', (int) $linkID);
        $query = $this->db->get('film_links');
        $data['m'] = $query->row();
	 	
	 	}else{
	 		$data['msg'] = 'Link ID not passed';
	 	}

	 	$this->load->view('admin-linkedit', $data);
	 }
	
	/*
	 * Admin add movie
	 */
	 public function addmovie() {
	 	if(!$this->admin_loggedIn) 
		{
			redirect('/admin/login');
			exit;
		}
		
		$genres = $this->db->get("genres");
		$data['genres'] = $genres->result();
		
		$this->load->view('admin-addmovie', $data);
	 }

	 /*
	 * Admin update movie
	 */
	 public function update_movie() {
	 	if(!$this->admin_loggedIn) 
		{
			redirect('/admin/login');
			exit;
		}
		
		$genres = $this->db->get("genres");
		$data['genres'] = $genres->result();

		$movieID = $this->uri->segment(3);
		$query = $this->db->query("SELECT * FROM movies WHERE filmID = ?", array($movieID));

		if ($query->num_rows() > 0)
		{
		   $row = $query->row(); 
		   $data['movie_data'] = $row;
		}
		
		$this->load->view('admin-updatemovie', $data);
	 }
	
	/*
	 * Log out
	 */
	public function logout() {
		$this->session->unset_userdata('admin_loggedIn');
		redirect('/admin/login');
	}
	
	/*
	 * Try Fetching movie details from IMDB
	 */
	 function imdb_fetch() {
	 	  header('Content-Type: application/json;charset=utf8');
	 	  ob_start();
		  
		  if(!$this->admin_loggedIn) 
		  {
				redirect('/admin/login');
				exit;
		  }
		  
		  $this->load->library('Imdb');
		  
	 	  $imdb_link = $this->input->post("link");
		  
		  if(!empty($imdb_link) AND strstr($imdb_link, 'http://')) {
			try {
				$output = $this->imdb->scrapeMovieInfo($imdb_link);
				
				
				
				$output = (object) $output;
				
				
				$json['title'] = isset($output->title) ? $output->title : 'Could not get IMDB';
				$json['description'] = isset($output->plot) ? $output->plot : '--';
				$json['description'] .= isset($output->storyline) ? $output->storyline : '--';
				$json['actors'] = isset($output->cast) ? $output->cast : '--';
				$json['release_date'] = isset($output->release_date) ? $output->release_date : '--';
				$json['runtime'] = isset($output->runtime) ? $output->runtime .' mins' : '--';
				$json['thumb'] = isset($output->poster) ? $output->poster : '';
				
				if(isset($output->genres)) {
					$json['genres'] = $output->genres;
				}
				
				echo json_encode($json);
				
			} catch (Exception $e) {
				echo json_encode(array('errorMsg' => $e->getMessage()));
			}
			
		  }else{
		  	  echo json_encode(array('errorMsg' => 'Empty URL/Incorrect IMDB URL'));
		  }
		  ob_end_flush();
	 }

	/*
	 * Add movies via ajax
	 */
	 public function ajax_add_movie() {
		
	 	if(!$this->admin_loggedIn) 
		{
		   redirect('/admin/login');
		   exit;
		}
		
		if($this->input->post("sb")) {
		
		$title = $this->input->post('film_title');
		$desc = $this->input->post('description');
		$picture_remove = $this->input->post('thumbnail_url');
		
		
		if(empty($title) OR empty($desc)) {
			echo div_class("Title and description required", 'alert alert-error');
		}elseif(empty($picture_remove) AND !isset($_FILES['thumbnail_file'])){
			echo div_class("A thumbnail is required", 'alert alert-error');
		}else{
			if(isset($_FILES['thumbnail_file'])) {
				$file = $_FILES['thumbnail_file'];
				
				
				$config['upload_path'] = getcwd().'/uploads/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size']	= '100';
				$config['max_width']  = '1024';
				$config['max_height']  = '1024';
				$this->load->library('upload', $config);
				
				if ( ! $this->upload->do_upload('thumbnail_file'))
				{
					$error = array('error' => $this->upload->display_errors());
		
					print $error['error'];
				}else{
					$data = $this->upload->data();
					$_POST['thumbnail'] = $data['file_name'];
					
				}
				
			}elseif(!empty($picture_remove)){
				$ext = explode(".", $picture_remove);
				$ext = end($ext);
				
				$ch = curl_init($picture_remove);
				$ip=rand(0,255).'.'.rand(0,255).'.'.rand(0,255).'.'.rand(0,255);
        		curl_setopt($ch, CURLOPT_HTTPHEADER, array("REMOTE_ADDR: $ip", "HTTP_X_FORWARDED_FOR: $ip"));
        		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/".rand(3,5).".".rand(0,3)." (Windows NT ".rand(3,5).".".rand(0,2)."; rv:2.0.1) Gecko/20100101 Firefox/".rand(3,5).".0.1");
			    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			    $data = curl_exec($ch);
			    curl_close($ch);
			    file_put_contents(getcwd() .'/uploads/'.url_title($title).'.'.$ext, $data);
				
				$_POST['thumbnail'] = url_title($title).'.'.$ext;
			}
			
			$_POST['genres'] = @implode(",", $_POST['genres']);
			$_POST['release_date'] = strtotime($_POST['release_date']);
			
			unset($_POST['thumbnail_url']);
			unset($_POST['thumbnail_file']);
			unset($_POST['sb']);
			
			$insert = $this->db->insert("movies", $this->input->post());
			
			if($this->db->insert_id()) {
				echo div_class('Movie added. <a href="/watch-movies/'.url_title($title).'-'.$this->db->insert_id().'" target="_blank">View it</a>', "alert alert-success");
			}else{
				echo div_class("Error. " . $this->db->_error_message(), 'alert alert-error');
			}
		}
			
		}else{
			echo div_class("Error. Nothing submitted", 'alert alert-error');
		}
		
	 }

	 /*
	 * Update movies via ajax
	 */
	 public function ajax_update_movie() {
		
	 	if(!$this->admin_loggedIn) 
		{
		   redirect('/admin/login');
		   exit;
		}
		
		if($this->input->post("sb")) {
		
		$title = $this->input->post('film_title');
		$desc = $this->input->post('description');
		$picture_remove = $this->input->post('thumbnail_url');
		
		
		if(empty($title) OR empty($desc)) {
			echo div_class("Title and description required", 'alert alert-error');
		}else{
			if(isset($_FILES['thumbnail_file'])) {
				$file = $_FILES['thumbnail_file'];
				
				
				$config['upload_path'] = getcwd().'/uploads/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size']	= '100';
				$config['max_width']  = '1024';
				$config['max_height']  = '1024';
				$this->load->library('upload', $config);
				
				if ( ! $this->upload->do_upload('thumbnail_file'))
				{
					$error = array('error' => $this->upload->display_errors());
		
					print $error['error'];
				}else{
					$data = $this->upload->data();
					$_POST['thumbnail'] = $data['file_name'];
					
				}
				
			}elseif(!empty($picture_remove)){
				$ext = explode(".", $picture_remove);
				$ext = end($ext);
				
				$ch = curl_init($picture_remove);
				$ip=rand(0,255).'.'.rand(0,255).'.'.rand(0,255).'.'.rand(0,255);
        		curl_setopt($ch, CURLOPT_HTTPHEADER, array("REMOTE_ADDR: $ip", "HTTP_X_FORWARDED_FOR: $ip"));
        		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/".rand(3,5).".".rand(0,3)." (Windows NT ".rand(3,5).".".rand(0,2)."; rv:2.0.1) Gecko/20100101 Firefox/".rand(3,5).".0.1");
			    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			    $data = curl_exec($ch);
			    curl_close($ch);
			    file_put_contents(getcwd() .'/uploads/'.url_title($title).'.'.$ext, $data);
				
				$_POST['thumbnail'] = url_title($title).'.'.$ext;
			}
			
			$_POST['genres'] = @implode(",", $_POST['genres']);
			$_POST['release_date'] = strtotime($_POST['release_date']);
			
			unset($_POST['thumbnail_url']);
			unset($_POST['thumbnail_file']);
			unset($_POST['sb']);

			$movieID = $_POST['movie_id'];
			unset($_POST['movie_id']);
			
			$insert = $this->db->update("movies", $this->input->post(), "filmID = " . $movieID);
			
			if($insert) {
				echo div_class('Movie updated. <a href="/watch-movies/'.url_title($title).'-'.$movieID.'" target="_blank">View it</a>', "alert alert-success");
			}else{
				echo div_class("Error. " . $this->db->_error_message(), 'alert alert-error');
			}
		}
			
		}else{
			echo div_class("Error. Nothing submitted", 'alert alert-error');
		}
		
	 }
	
	/*
	 * Users page
	 */
	 function users() {
	 	if(!$this->admin_loggedIn) 
		{
		   redirect('/admin/login');
		   exit;
		}
		
		$do = $this->uri->segment(3);
		$removeID = $this->uri->segment(4);
		
		if($do AND $removeID) {
			$id = abs(intval($removeID));

			switch ($do) {
				case 'remove':
					
					$this->db->delete("users", array("userID" => $id));
					$this->db->delete("film_links", array("linkBy" => $id));
					$this->db->delete("comments", array("commUser" => $id));
					redirect('/admin/users');

				break;

				case 'promote':
					
					$this->db->update("users", array('role' => 'moderator'), array("userID" => $id));
					redirect('/admin/users');

				break;

				case 'regular':
					
					$this->db->update("users", array('role' => 'user'), array("userID" => $id));
					redirect('/admin/users');

				break;
			}


		}
		
		$this->db->select("users.*, (SELECT COUNT(*) as tUsers FROM users) as tUsers", false);
		$this->db->from("users");
		$this->db->order_by("userID", "DESC");
		$users = $this->db->get();
		
	 	$data['users'] = $users->result();
		$this->load->view('admin-users', $data);
	 }

	/*
	 * Comments page
	 */
	 function comments() {
	 	if(!$this->admin_loggedIn) 
		{
		   redirect('/admin/login');
		   exit;
		}
		
		$removeID = $this->uri->segment(4);
		
		if($removeID) {
			$id = abs(intval($removeID));
			$this->db->delete("comments", array("commID" => $id));
			redirect('/admin/comments');
		}
		
	
		$this->db->select("comments.*, movies.film_title, movies.filmID, users.username, users.ip,  
						(SELECT COUNT(*) as tComments FROM comments) as tComments", false);
		$this->db->join("users", "users.userID = comments.commUser", "LEFT");
		$this->db->join("movies", "movies.filmID = comments.movID", "LEFT");
		$this->db->from("comments");
		$this->db->order_by("commID", "DESC");
		$comments = $this->db->get();
		
	 	$data['comments'] = $comments->result();
		$this->load->view('admin-comments', $data);
	 }
	 
	 /*
	 * Comments page
	 */
	 function genres() {
	 	if(!$this->admin_loggedIn) 
		{
		   redirect('/admin/login');
		   exit;
		}
		
		if($this->input->post('sb')) {
			$genre = $this->input->post('genre');
			if(!empty($genre)) {
				$exists = $this->db->get_where("genres", array('genre' => $genre));
				if(count($exists->result())) {
					$data['error'] = div_class('Genre '.$genre.' already exists', 'alert alert-error');
				}else{
					$this->db->insert("genres", array('genre' => $genre));
					$data['error'] = div_class('Successfully added new genre', 'alert alert-success');	
				}
			}else{
				$data['error'] = div_class('Empty genre', 'alert alert-error');
			}
		}
		
		$removeID = $this->uri->segment(4);
		
		if($removeID) {
			$id = abs(intval($removeID));
			$this->db->delete("genres", array("genreID" => $id));
			redirect('/admin/genres');
		}
		
	
		$this->db->select("*, (SELECT COUNT(*) FROM movies WHERE FIND_IN_SET(genreID, movies.genres)) as tMovies", false);
		$this->db->from("genres");
		$this->db->order_by("genre", "ASC");
		$comments = $this->db->get();
		
	 	$data['comments'] = $comments->result();
		$this->load->view('admin-genres', $data);
	 }

	/*
	 * TOS
	 */
	 public function tos() {
	 	if(!$this->admin_loggedIn) 
		{
		   redirect('/admin/login');
		   exit;
		}

		if($this->input->post('sb')) {
			$tospost = $this->input->post('tos');
			$this->db->update("tos", array("tos"=>$tospost));
			$data['error'] = div_class('Successfully updated TOS', 'alert alert-success');
		}
		
		$tos = $this->db->get("tos");
		$tos = $tos->row();
		$data['tos'] = $tos->tos;
	
		$this->load->view('admin-tos', $data);
		
	 }

	/*
	 * ADS
	 */
	 public function ads() {
	 	if(!$this->admin_loggedIn) 
		{
		   redirect('/admin/login');
		   exit;
		}

		if($this->input->post('sb')) {
			$tospost = $this->input->post('ads');
			$this->db->update("ads", array("ads"=>$tospost));
			$data['error'] = div_class('Successfully updated AD code', 'alert alert-success');
		}
		
		$tos = $this->db->get("ads");
		$tos = $tos->row();
		$data['ads'] = $tos->ads;
	
		$this->load->view('admin-ads', $data);
		
	 }

}	