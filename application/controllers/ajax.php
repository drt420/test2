<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AJAX extends CI_Controller {


	// this is used for ajax search autocomplete
	public function search() {

		if( $term = $this->input->get('search_term') ) {
			$term = trim(strip_tags($term));

			$db_string = '%'.$term.'%';

			$movies = $this->db->query("SELECT filmID, film_title, thumbnail, film_type, release_date, views 
										FROM movies WHERE film_title LIKE ? OR description LIKE ? LIMIT 5", 							array($db_string, $db_string));

			if( count( $movies->result() )) {
				echo '<ul class="search-autocomplete">';
				foreach( $movies->result() as $m ) {
					$title = substr($m->film_title, 0, 25);
					$title .= strlen($m->film_title) > 25 ? '..' : '';
					print '<li>
							<div style="postion:relative;">
							<div style="float:left;width: 60px;">
							<a href="/watch-'.$m->film_type.'s/'.url_title($m->film_title).'-'.$m->filmID.'">
								<img src="/uploads/'.$m->thumbnail.'" width="40" height="60" />
							</a>
							</div>
							<div style="float:left; width; 200px;">
								<a href="/watch-'.$m->film_type.'s/'.url_title($m->film_title).'-'.$m->filmID.'">
									'.$title.'
								</a>
								<br />
								'.date('jS F Y', $m->release_date).'
								<br />
								<font style="font-weight:light;font-style:italic;">'.$m->views.' views</font>
							</div>
							</div>
							<div style="clear:both;"></div>
							</li>';
				}
				echo '</ul>';
			}else{
				printf('No movies/tv shows for search term <em>%s</em>', $term);
			}

		}else{
			echo 'No term received for search';
		}

	}

}