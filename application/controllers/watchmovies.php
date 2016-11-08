<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class WatchMovies extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
	}
	
	//redirect to external page
	public function go() {
		ob_start();
		
		$id = $this->uri->segment(3);
		$id = abs(intval($id));
		
		if($id < 1) {
			die("Negative ID");
		}
		
		//get external link details
		$this->db->select("link_destination");
		$link = $this->db->get_where('film_links', array('linkID' => $id));
		$link = $link->row();
		
		header("Location: ".$link->link_destination);
		
		ob_end_flush();
		
	}

	//show embed link
	public function embed() {
		ob_start();
		
		$id = $this->uri->segment(3);
		$id = abs(intval($id));
		
		if($id < 1) {
			die("Negative ID");
		}
		
		//get external link details
		$this->db->select("link_destination");
		$link = $this->db->get_where('film_links', array('linkID' => $id));
		$link = $link->row();
		
		echo $link->link_destination;
		
		ob_end_flush();
	}
	
	//single movie page
	public function index($param = null)
	{
		$this->load->helper("form");
		
		$uri_string = $this->uri->segment(2);
		$movie = explode("-", $uri_string);
		$movieID = $this->db->escape(abs(intval(end($movie))));
		
		
		//get movie data
		$moviesRs = $this->db->get_where("movies", array("filmID" => $movieID));
		$movieData = $moviesRs->result();
		
		if(count($movieData)) {
			//update movie views
			$this->db->set('views', 'views+1', FALSE);
			$this->db->where('filmID', $movieID);
			$this->db->update('movies');
		}
		
		
		//get genres
		$genresRs = $this->db->where_in("genreID", @explode(",", $movieData[0]->genres));
		$genresRs = $genresRs->get("genres");
		$genresAll = $genresRs->result();
		
		
		//get comments
		$this->db->select("commID, comment, comm_date, userID, username");
		$this->db->from("comments");
		$this->db->where("movID = $movieID");
		$this->db->join('users', 'comments.commUser = users.userID');
		$comments = $this->db->get();
		
		
		//get movie links
		$this->db->select("film_links.*, film_title");
		$this->db->from("film_links");
		$this->db->where("status = 'approved'");
		$this->db->where("mID = $movieID");
		$this->db->join('movies', 'movies.filmID = film_links.mID');
		$movie_links = $this->db->get();
		
		
		//get ad code
		$tos = $this->db->get("ads");
		$tos = $tos->row();
		$data['ads'] = $tos->ads;
		
		//build seo title
		$data['seo_title'] = 'Watch ' . $movieData[0]->film_title .' ('.date("Y", $movieData[0]->release_date).') Online';
		

		//get related movies : same genre
		$this->load->helper('related_sidebar');
		$data['related_movies'] = related_sidebar($movieData[0]->genres, $movieID);
		
		$data['movie_info'] = $movieData;
	    $data['genres'] = $genresAll;
		$data['movie_comments'] = $comments->result(); 
		$data['movie_links'] = $movie_links->result(); 
		
		$this->load->view('watch-movies', $data);
	}
	
	
	//movies page
	public function movies($param = null) {
		
		$this->load->library('pagination');

		//pagination
		$config['base_url'] = '/watch/movies/page/';
		$config['suffix'] = isset($_GET['sort']) ? '?sort=' . $_GET['sort'] : '';
		$config['first_url'] = '1';
		$config['first_url'] .= isset($_GET['sort']) ? '?sort=' . $_GET['sort'] : '';

		$this->db->where(array("film_type" => 'movie'));
		$this->db->from("movies");
		$config['total_rows'] = $this->db->count_all_results();
		
		$config['per_page'] = 30;
		$config['uri_segment'] = 4;
		//config for bootstrap pagination class integration
		$config['full_tag_open'] = '<div class="pagination"><ul>';
		$config['full_tag_close'] = '</ul></div>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo';
		$config['prev_tag_open'] = '<li class="previous">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '&raquo';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		$this->pagination->initialize($config); 
		$page = abs(intval($this->uri->segment(4)));
		$start = $page*$config['per_page']; 

		
		//estabilish vid type = movies
		$data['vid_type'] = 'Watch Movies Online';

		if( !isset($_GET['sort'])) {
			$this->db->order_by('is_featured', 'desc');
			$this->db->order_by('filmID', 'desc');
		} else {
			switch ($_GET['sort']):

				case "recent":
					$this->db->order_by('filmID', 'desc');
				break;

				case "rating":
					$this->db->order_by('rating', 'desc');
					break;

				case "views":
					$this->db->order_by('views', 'desc');
					break;

				case "release":
					$this->db->order_by('release_date', 'desc');
					break;

				default:
					$orderby = "filmID desc";

			endswitch;

		}

		$movies = $this->db->get_where("movies", array("film_type" => 'movie'), $config['per_page'], $page);
		$data['movies'] = $movies->result();
		$data['pagination'] = $this->pagination->create_links();
		
		$this->load->view('all-movies', $data);
		
	}
	
	//tv shows page
	public function tvshows() {
			
		//estabilish vid type = movies
		$data['vid_type'] = 'Watch TV Shows Online';
		
		$this->load->library('pagination');
		
		//pagination
		$config['base_url'] = '/watch/tv-shows/page/';
		
		$this->db->where(array("film_type" => 'tv-show'));
		$this->db->from("movies");
		$config['total_rows'] = $this->db->count_all_results();

		$config['suffix'] = isset($_GET['sort']) ? '?sort=' . $_GET['sort'] : '';
		$config['first_url'] = '1';
		$config['first_url'] .= isset($_GET['sort']) ? '?sort=' . $_GET['sort'] : '';
		
		$config['per_page'] = 16; 
		$config['uri_segment'] = 4;
		$config['per_page'] = 30;
		$config['uri_segment'] = 4;
		//config for bootstrap pagination class integration
		$config['full_tag_open'] = '<div class="pagination"><ul>';
		$config['full_tag_close'] = '</ul></div>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo';
		$config['prev_tag_open'] = '<li class="previous">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '&raquo';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config); 
		$page = abs(intval($this->uri->segment(4)));
		$start = $page*$config['per_page'];


		if( !isset($_GET['sort'])) {
			$this->db->order_by('is_featured', 'desc');
			$this->db->order_by('filmID', 'desc');
		} else {
			switch ($_GET['sort']):

				case "recent":
					$this->db->order_by('filmID', 'desc');
					break;

				case "rating":
					$this->db->order_by('rating', 'desc');
					break;

				case "views":
					$this->db->order_by('views', 'desc');
					break;

				case "release":
					$this->db->order_by('release_date', 'desc');
					break;

				default:
					$orderby = "filmID desc";

			endswitch;

		}

		$movies = $this->db->get_where("movies", array("film_type" => 'tv-show'), $config['per_page'], $page);
		$data['movies'] = $movies->result();
		$data['pagination'] = $this->pagination->create_links();
		
		$this->load->view('all-movies', $data);
	}

	//watch by starting letter/number
	public function by_starting_letter() {

		$genre_name = trim(strip_tags($this->uri->segment(2)));
		
		if(empty($genre_name)) die("Empty starting letter/number");
			
		//estabilish vid type = movies
		$data['vid_type'] = 'Watch Movies Starting With "' . $genre_name . '"';
		$data['seo_title'] = 'Watch Movies Starting With "' . $genre_name . '"';
		
		$this->load->library('pagination');
		
		//pagination
		$config['base_url'] = '/watch-starting-with/' . $genre_name . '/page/';
		$config['suffix'] = isset($_GET['sort']) ? '?sort=' . $_GET['sort'] : '';
		$config['first_url'] = '1';
		$config['first_url'] .= isset($_GET['sort']) ? '?sort=' . $_GET['sort'] : '';
		
		if($genre_name != "0-9") {
			$qt = $this->db->query("SELECT * FROM movies WHERE film_title LIKE ?", array($genre_name . '%'));
		}else{
			$qt = $this->db->query("SELECT * FROM movies WHERE film_title REGEXP '^[0-9]'");
		}
		$config['total_rows'] = $qt->num_rows;



		$config['per_page'] = 30;
		$config['uri_segment'] = 4;
		$config['full_tag_open'] = '<div class="pagination"><ul>';
		$config['full_tag_close'] = '</ul></div>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo';
		$config['prev_tag_open'] = '<li class="previous">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '&raquo';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config); 
		$page = abs(intval($this->uri->segment(4)));
		$start = abs(intval($page*$config['per_page']));

		if( !isset($_GET['sort'])) {
			$orderby = 'is_featured desc';
			$orderby = 'filmID desc';
		} else {
			switch ($_GET['sort']):

				case "recent":
					$orderby = 'filmID desc';
					break;

				case "rating":
					$orderby = 'rating desc';
					break;

				case "views":
					$orderby = 'views desc';
					break;

				case "release":
					$orderby = 'release_date desc';
					break;

				default:
					$orderby = "filmID desc";

			endswitch;

		}
		
		if($genre_name != "0-9") {
			$movies = $this->db->query("SELECT * FROM movies WHERE film_title LIKE ? ORDER BY $orderby LIMIT $page, ".$config['per_page']."", array($genre_name . '%'));
		}else{
			$movies = $this->db->query("SELECT * FROM movies WHERE film_title REGEXP '^[0-9]' ORDER BY $orderby LIMIT $page, ".$config['per_page']."");
		}
		$data['movies'] = $movies->result();
		$data['pagination'] = $this->pagination->create_links();

		
		$this->load->view('all-movies', $data);
		
	}

	//watch by year
	public function by_the_year() {

		$year = intval(trim(strip_tags($this->uri->segment(2))));

		if(empty($year)) die("Empty starting year");
			
		//estabilish vid type = movies
		$data['vid_type'] = 'Watch Movies From "' . $year . '"';
		$data['seo_title'] = 'Watch Movies From "' . $year . '"';
		
		$this->load->library('pagination');
		
		//pagination
		$config['base_url'] = '/watch-from-year/' . $year . '/page/';
		$qt = $this->db->query("SELECT * FROM movies WHERE FROM_UNIXTIME( release_date,  '%Y' ) = ?", $year);
		$config['total_rows'] = $qt->num_rows;

		$config['suffix'] = isset($_GET['sort']) ? '?sort=' . $_GET['sort'] : '';
		$config['first_url'] = '1';
		$config['first_url'] .= isset($_GET['sort']) ? '?sort=' . $_GET['sort'] : '';
		$config['full_tag_open'] = '<div class="pagination"><ul>';
		$config['full_tag_close'] = '</ul></div>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo';
		$config['prev_tag_open'] = '<li class="previous">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '&raquo';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['per_page'] = 30;
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config); 
		$page = abs(intval($this->uri->segment(4)));
		$start = abs(intval($page*$config['per_page']));

		if( !isset($_GET['sort'])) {
			$orderby = 'is_featured desc';
			$orderby = 'filmID desc';
		} else {
			switch ($_GET['sort']):

				case "recent":
					$orderby = 'filmID desc';
					break;

				case "rating":
					$orderby = 'rating desc';
					break;

				case "views":
					$orderby = 'views desc';
					break;

				case "release":
					$orderby = 'release_date desc';
					break;

				default:
					$orderby = "filmID desc";

			endswitch;

		}

		$movies = $this->db->query("SELECT * FROM movies WHERE FROM_UNIXTIME( release_date,  '%Y' ) = ? ORDER BY $orderby LIMIT $page, ".$config['per_page']."", $year);

		$data['movies'] = $movies->result();
		$data['pagination'] = $this->pagination->create_links();
		
		$this->load->view('all-movies', $data);
		
	}

	
	
	//watch by genre
	public function by_genre() {

		$genre_name = trim(strip_tags($this->uri->segment(2)));
		
		if(empty($genre_name)) die("Empty genre");		
			
		//estabilish vid type = movies
		$data['vid_type'] = 'Watch '.$genre_name.' Movies & TV Shows';
		$data['seo_title'] = 'Watch '.$genre_name.' Movies & TV Shows';
		
		$this->load->library('pagination');
		
		//get genre id
		$genreQuery = $this->db->get_where("genres", array("genre" => $genre_name));
		$genre_name = $genreQuery->row();
		
		if(!count($genre_name)) 
		{
			$data['error'] = 'Error fetching genre <strong>'.trim(strip_tags($this->uri->segment(2))).'</strong><br/>';
			$this->load->view('all-movies', $data);
		}else{
		
		$genreID = $genre_name->genreID;

		//pagination
		$config['base_url'] = '/watch-genres/'.url_title($genre_name->genre).'/page/';
		$config['full_tag_open'] = '<div class="pagination"><ul>';
		$config['full_tag_close'] = '</ul></div>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo';
		$config['prev_tag_open'] = '<li class="previous">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '&raquo';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['suffix'] = isset($_GET['sort']) ? '?sort=' . $_GET['sort'] : '';
		$config['first_url'] = '1';
		$config['first_url'] .= isset($_GET['sort']) ? '?sort=' . $_GET['sort'] : '';

		$qt = $this->db->query("SELECT * FROM movies WHERE FIND_IN_SET($genreID, genres)");
		#var_dump($qt);
		$config['total_rows'] = $qt->num_rows;
		
		
		
		$config['per_page'] = 30;
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config); 
		$page = abs(intval($this->uri->segment(4)));
		$start = abs(intval($page*$config['per_page']));

		if( !isset($_GET['sort'])) {
			$orderby = 'is_featured desc';
			$orderby = 'filmID desc';
		} else {
			switch ($_GET['sort']):

				case "recent":
					$orderby = 'filmID desc';
					break;

				case "rating":
					$orderby = 'rating desc';
					break;

				case "views":
					$orderby = 'views desc';
					break;

				case "release":
					$orderby = 'release_date desc';
					break;

				default:
					$orderby = "filmID desc";

			endswitch;

		}
		
		
		$movies = $this->db->query("SELECT * FROM movies WHERE FIND_IN_SET($genreID, genres) ORDER BY $orderby LIMIT $page, ".$config['per_page']."");
		$data['movies'] = $movies->result();
		$data['pagination'] = $this->pagination->create_links();
		
		$this->load->view('all-movies', $data);
		
		}
	}

	
	//watch by actors
	public function by_actor() {

		$genre_name = trim(strip_tags($this->uri->segment(2)));
		$genre_name = str_replace("-", " ", $genre_name);
		
		if(empty($genre_name)) die("Empty actor");		
			
		//estabilish vid type = movies
		$data['vid_type'] = 'Watch '.$genre_name.' Movies & TV Shows';
		$data['seo_title'] = 'Watch '.$genre_name.' Movies & TV Shows';
		
		$this->load->library('pagination');
		
		//pagination
		$config['base_url'] = '/watch-movies-by-actor/page/';
		
		$this->db->query("SELECT * FROM movies WHERE FIND_IN_SET('$genre_name', actors) OR FIND_IN_SET(' $genre_name', actors)");
		$config['total_rows'] = $this->db->count_all_results();

		$config['full_tag_open'] = '<div class="pagination"><ul>';
		$config['full_tag_close'] = '</ul></div>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo';
		$config['prev_tag_open'] = '<li class="previous">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '&raquo';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['per_page'] = 30;
		$config['uri_segment'] = 3;
		$config['suffix'] = isset($_GET['sort']) ? '?sort=' . $_GET['sort'] : '';
		$config['first_url'] = '1';
		$config['first_url'] .= isset($_GET['sort']) ? '?sort=' . $_GET['sort'] : '';

		$this->pagination->initialize($config); 
		$page = abs(intval($this->uri->segment(3)));
		$start = abs(intval($page*$config['per_page']));

		if( !isset($_GET['sort'])) {
			$orderby = 'is_featured desc';
			$orderby = 'filmID desc';
		} else {
			switch ($_GET['sort']):

				case "recent":
					$orderby = 'filmID desc';
					break;

				case "rating":
					$orderby = 'rating desc';
					break;

				case "views":
					$orderby = 'views desc';
					break;

				case "release":
					$orderby = 'release_date desc';
					break;

				default:
					$orderby = "filmID desc";

			endswitch;

		}
		
		$movies = $this->db->query("SELECT * FROM movies WHERE FIND_IN_SET('$genre_name', actors) OR FIND_IN_SET(' $genre_name', actors) ORDER BY $orderby LIMIT $start, ".$config['per_page']."");
		$data['movies'] = $movies->result();
		$data['pagination'] = $this->pagination->create_links();
		
		$this->load->view('all-movies', $data);
		
	}
	
	//watch by keywords
	public function by_keywords() {

		$genre_name = trim(strip_tags($this->uri->segment(2)));
		$genre_name = str_replace("-", " ", $genre_name);
		
		if(empty($genre_name)) die("Empty keyword");		
			
		//estabilish vid type = movies
		$data['vid_type'] = 'Watch "'.$genre_name.'" Movies & TV Shows';
		
		$this->load->library('pagination');
		
		//pagination
		$config['base_url'] = '/watch-movies-by-keywords/page/';
		
		$this->db->query("SELECT * FROM movies WHERE FIND_IN_SET('$genre_name', tags) OR FIND_IN_SET(' $genre_name', tags)");
		$config['total_rows'] = $this->db->count_all_results();
		
		$config['per_page'] = 30;
		$config['full_tag_open'] = '<div class="pagination"><ul>';
		$config['full_tag_close'] = '</ul></div>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo';
		$config['prev_tag_open'] = '<li class="previous">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '&raquo';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['uri_segment'] = 3;
		$config['suffix'] = isset($_GET['sort']) ? '?sort=' . $_GET['sort'] : '';
		$config['first_url'] = '1';
		$config['first_url'] .= isset($_GET['sort']) ? '?sort=' . $_GET['sort'] : '';

		$this->pagination->initialize($config); 
		$page = abs(intval($this->uri->segment(3)));
		$start = abs(intval($page*$config['per_page']));

		if( !isset($_GET['sort'])) {
			$orderby = 'is_featured desc';
			$orderby = 'filmID desc';
		} else {
			switch ($_GET['sort']):

				case "recent":
					$orderby = 'filmID desc';
					break;

				case "rating":
					$orderby = 'rating desc';
					break;

				case "views":
					$orderby = 'views desc';
					break;

				case "release":
					$orderby = 'release_date desc';
					break;

				default:
					$orderby = "filmID desc";

			endswitch;

		}
		
		$movies = $this->db->query("SELECT * FROM movies WHERE FIND_IN_SET('$genre_name', tags) OR FIND_IN_SET(' $genre_name', tags) ORDER BY $orderby LIMIT $start, ".$config['per_page']."");
		$data['movies'] = $movies->result();
		$data['pagination'] = $this->pagination->create_links();
		
		$this->load->view('all-movies', $data);
		
	}
	
	
	/*
	 * Leave comments to movies
	 */
	public function ajax_comment() {
			
		$userID = is_user_logged_in();
		
		if($userID) {
			
			foreach($this->input->post() as $k=>$v) {
				if($this->input->post($k, TRUE) == "") {
					print '<div class="alert alert-warning">';
					print 'All fields are mandatory';
					print '</div>';
					exit;
				}
			}
			
			$comment = array();
			$comment['comm_date'] = time();
			$comment['commUser'] = $userID;
			$comment['movID'] = abs(intval($this->input->post('movID', TRUE)));
			$comment['comment'] = trim(strip_tags($this->input->post('comment', TRUE)));
			
			
			if(strlen($comment['comment']) < 10 ) {
				echo div_class('Please enter at least 10 characters for your comment', 'alert alert-error');
				exit;
			}
			
			if($this->db->insert("comments", $comment)) {
				echo div_class('Thank you for your comment', 'alert alert-warning');
				echo '<script type="text/javascript">';
				echo '$(function() {';
					echo '$("#comment-form").hide("slow");';
				echo '})';
				echo '</script>';
			}else{
				echo div_class('DB Error!', "alert alert-error");
			}
			
		}else{
			echo '<div class="alert alert-error">Please login</div>';
		}
	}

	/*
	 * Load latest comment via ajax
	 */
	 function ajax_last_comment() {
	 	 $lastID = abs(intval($this->input->post("last", TRUE)));
		 $movID = abs(intval($this->input->post("movie", TRUE)));
		 
		 if($lastID AND $movID) {
		 	
			//get comments
			$this->db->select("commID, comment, comm_date, userID, username");
			$this->db->from("comments");
			$this->db->where("commID > $lastID");
			$this->db->where("movID = $movID");
			$this->db->join('users', 'comments.commUser = users.userID');
			$comments = $this->db->get();
			$comments = $comments->result();
			
			if(count($comments)) {
				foreach($comments as $c) {
					echo '<li data-lastID="'.$c->commID.'">';
					?>
					<span class="comment_author"><b class="icon-user"></b> <?php echo anchor('users/profile/'.url_title($c->username), $c->username); ?> on <b class="icon-calendar"></b><em><?php echo date("jS F Y H:ia", $c->comm_date); ?></em></span>
					<div class="comment_content"><?php echo wordwrap($c->comment, 80, '<br/>', TRUE); ?></div>
					<?php
					echo '</li>';
				}
			}
			
		 }else{
		 	
		 }
		 
	 }

	/*
	 * AJAX Star Rating system
	 */
	 function rating($uri) {
		ob_start();
		 
		$do = $this->uri->segment(4);
		$movID = abs(intval($this->uri->segment(6)));
		
		if($do AND $movID) {
			if($do == 'getrate') {
				$this->db->select("rating");
				$this->db->from("movies");
				$this->db->where("filmID = $movID");
				$rating = $this->db->get();
				$rating = $rating->row();
				if($rating) {
					echo $rating->rating*20;
				}else{
					echo 100;
				} 
			}elseif($do == 'rate') {
				$ip = ip2long($_SERVER['REMOTE_ADDR']);
				$rating = abs(intval($this->uri->segment(8)));
				
				$this->db->select("rating");
				$this->db->from("movies");
				$this->db->where("filmID = $movID");
				$ratingDB = $this->db->get();
				$ratingDB = $ratingDB->row();
				
				if($rating >= 1 AND $rating <= 5) {
					if(!isset($_COOKIE[$ip.'movie'.$movID])) {
					
						if($ratingDB->rating > 0) {	
							$this->db->set('rating', '(rating+'.$rating.')/2', FALSE);
							$this->db->where('filmID', $movID);
							$this->db->update('movies');
							echo 'Rated '.$rating.'/5';
							setcookie($ip.'movie'.$movID, 'voted', time()+24*3600);
						}else{
							$this->db->set('rating', $rating);
							$this->db->where('filmID', $movID);
							$this->db->update('movies');
							echo 'Rated '.$rating.'/5';
							setcookie($ip.'.movie'.$movID, 'voted', time()+24*3600);
						} 
						
					}else{
						print "Already Rated";
					}
				}
			}
		}else{
			echo 100;
		}
		ob_end_flush();
	 }

	/*
	 * Function to rate broken/working link
	 */
	 public function rate_external_ajax() {
	 	ob_start();
		
		$linkID = abs(intval($this->input->post('linkID')));
		$feedback = (string) ($this->input->post('action'));
		
		if($linkID AND ($feedback == 'works' OR $feedback == 'broken')) {
			
			$ip = ip2long($_SERVER['REMOTE_ADDR']);
			if(isset($_COOKIE[$ip.$linkID])) {
				echo div_class('Not again. You can vote once', 'alert alert-warning');
			}else{
				setcookie($ip.$linkID, $feedback, time()+24*3600);
				
				if($feedback == 'works') {
					$this->db->set('link_ok', '(link_ok+1)', FALSE);
				}else{
					$this->db->set('link_broken', '(link_broken+1)', FALSE);
				}
				$this->db->where('linkID', $linkID);
				$this->db->update('film_links');
				
				echo div_class('Thank you', 'alert alert-warning');
				
			}
			
		}else{
			print 'Nothing to do';
		}
		
		ob_end_flush();
	 }
	 
	 /*
	  * ajax submit link
	  */
	  public function ajax_link_submit() {
	  		ob_start();
			
			if(!is_user_logged_in() AND !is_admin()) die("Please login");
			
			$title = (string) trim(strip_tags($this->input->post('link_title')));
			$link = is_admin() ? $this->input->post('movie_link') : (string) trim(strip_tags($this->input->post('movie_link')));
			$tab = (string) trim(strip_tags($this->input->post('link_tab')));
			$userID = is_user_logged_in();
			$movieID = (int) abs(intval($this->input->post('movieID')));
			
			if($movieID < 1) die(div_class('MovieID negative', 'alert alert-error')); 
			
			if(!empty($title) AND !empty($link) AND stristr($link, 'http')) {
				
				$insert['linkBy'] = $userID;
				$insert['link_tab'] = $tab;
				$insert['link_title'] = $title;
				$insert['link_destination'] = $link;
				$insert['link_ok'] = 0;
				$insert['link_broken'] = 0;
				if(!is_admin()) {
					$insert['status'] = 'pending';
					$insert['link_type'] = 'External';
				}else{
					$insert['status'] = 'approved';
					$insert['link_type'] = (string) trim(strip_tags($this->input->post('link_type')));
				}
				$insert['mID'] = $movieID;
				
				$this->db->insert("film_links", $insert);
				
				if(!is_admin()) {
					echo div_class('Thank you, we will review it soon and approve/reject.', 'alert alert-success');
					echo '<script type="text/javascript">';
					echo '$(function() {
							$("#submit-link-form").hide("slow");
					});';
					echo '</script>';
				}else{
					echo div_class('Link Added. <a href="/admin/movielinks/'.$movieID.'">Refresh this page.</a>', 'alert alert-success');
				}
				
				
				
			}else{
				echo div_class('Enter link details please. Link must start with http:// or https://', 'alert alert-error');
				echo htmlspecialchars($link);
			} 
			
			ob_end_flush();
	  }


	  /*
	   * Add to playlist
	   */
	   public function ajax_add_playlist() {
	   	   ob_start();
			
		   if(!is_user_logged_in()) die(div_class("Please login to add to your playlist", "alert alert-warning"));
		   
		   $movID = (int) abs(intval($this->uri->segment(3)));
		   $userID = is_user_logged_in();
		   
		   if($movID < 1) die(div_class("Negative movie #ID", "alert alert-warning"));
		   
		   //check if already on user playlist
		   $check = $this->db->query("SELECT listID FROM playlists WHERE fID = ? AND uID = ?", array($movID, $userID));
		   if(count($check->result())) {
		   		echo div_class("Movie already in your Playlist", "alert alert-warning");
		   }else{
		   	    $insert = array("fID" => $movID, "uID" => $userID, "date" => time());
		   		$this->db->insert("playlists", $insert);
				echo div_class("Added to your playlist", "alert alert-success");
		   }
			
		   ob_end_flush();
	   }
	 
	 
	
}