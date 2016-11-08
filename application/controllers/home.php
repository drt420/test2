<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	
	public function index()
	{
		//get movies
		$this->db->order_by('filmID', 'desc');
		$Fmovies = $this->db->get_where("movies", array("film_type" => "movie"), 12);
		
		//top rated movies
		$this->db->order_by('rating', 'desc');
		$this->db->order_by('filmID', 'desc');
		$Rmovies = $this->db->get_where("movies", array("film_type" => "movie", "rating != " => 0), 12);

		//get "tv shows" movies
		$this->db->order_by('filmID', 'desc');
		$movies = $this->db->get_where("movies", array("film_type" => "tv-show"), 12);

		//get top rated tv shows
		$this->db->order_by('rating', 'desc');
		$this->db->order_by('filmID', 'desc');
		$Rshows = $this->db->get_where("movies", array("film_type" => "tv-show", "rating != " => 0), 12);

		//get "most commented" movies
		$this->db->select('movies.*, COUNT(commID) AS total_comments');
		$this->db->join('comments', 'movies.filmID = comments.movID');
		$this->db->group_by('filmID', 'desc');
		$this->db->order_by('total_comments', 'desc');
		$Cmovies = $this->db->get_where("movies", array('film_type' => 'movie'), 12);

		//get "most commented" tv shows
		$this->db->select('movies.*, COUNT(commID) AS total_comments');
		$this->db->join('comments', 'movies.filmID = comments.movID');
		$this->db->group_by('filmID', 'desc');
		$this->db->order_by('total_comments', 'desc');
		$Cshows = $this->db->get_where("movies", array('film_type' => 'tv-show'), 12);

		//get "most linked" movies
		$this->db->select('movies.*, COUNT(linkID) AS total_links');
		$this->db->join('film_links', 'movies.filmID = film_links.mID');
		$this->db->group_by('filmID', 'ID');
		$this->db->order_by('total_links', 'desc');
		$Lmovies = $this->db->get_where("movies", array('film_type' => 'movie'), 12);

		//get "most linked" tv shows
		$this->db->select('movies.*, COUNT(linkID) AS total_links');
		$this->db->join('film_links', 'movies.filmID = film_links.mID');
		$this->db->group_by('filmID', 'ID');
		$this->db->order_by('total_links', 'desc');
		$Lshows = $this->db->get_where("movies", array('film_type' => 'tv-show'), 12);
		
		$data['featured_movies'] = $Fmovies->result();
		$data['movies'] = $movies->result();
		
		$data['commented_movies'] = $Cmovies->result();
		$data['commented_shows'] = $Cshows->result();

		$data['linked_movies'] = $Lmovies->result();
		$data['linked_shows'] = $Lshows->result();

		$data['top_movies'] = $Rmovies->result();
		$data['top_shows'] = $Rshows->result();

		$data['seo_title'] = $this->config->item('site_title');
		$data['is_home'] = 'yep';
		
		$this->load->view('home', $data);
	}
	
	
	public function search_movies() {
		ob_start();
		
		$data['vid_type'] = 'Search Movies & TV Shows';
		
		$string = trim(strip_tags($this->input->post('q')));
		$db_string = '%'.$string.'%';
		
		if(empty($string)) {
			$data['error'] = 'Empty search query string<br/>';
			$this->load->view('all-movies', $data);
			exit;
		}
		$genre_name = $string;
		
		//estabilish vid type = movies
		$data['vid_type'] = 'Search '.$genre_name.' Movies & TV Shows' . PHP_EOL;
		
		$this->load->library('pagination');
		
		//pagination
		$config['base_url'] = '/search_movies/page/';
		
		$this->db->query("SELECT * FROM movies WHERE film_title LIKE ? OR description LIKE ?", array($db_string, $db_string));
		$config['total_rows'] = $this->db->count_all_results();
		
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
		
		
		$movies = $this->db->query("SELECT * FROM movies WHERE film_title LIKE ? OR description LIKE ? LIMIT $start, ".$config['per_page']."", array($db_string, $db_string));
		$data['movies'] = $movies->result();
		$data['pagination'] = $this->pagination->create_links();
		
		$data['seo_title'] = '"'.$string.'" - search movies & tv shows';
		$data['hide_sort'] = true;

		$this->load->view('all-movies', $data);
		
		ob_end_flush();
	}


	public function tos() {
		
		$tos = $this->db->get("tos", 1);
		$data['tos'] = $tos->row();
		
		$this->load->view('tos', $data);
	}
	
}