<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "home";
$route['404_override'] = 'errors';
$route['watchonline'] = "watchmovies";
$route['search_movies'] = "home/search_movies";
$route['watch-movies/:any-:num'] = "watchmovies/index/$1-$2";
$route['watch-tv-shows/:any-:num'] = "watchmovies/index/$1-$2";
$route['watch/movies'] = "watchmovies/movies";
$route['watch/movies/page/:num'] = "watchmovies/movies/page/$1";
$route['watch/movies/page'] = "watchmovies/movies/page";
$route['watch/tv-shows'] = "watchmovies/tvshows";
$route['watch/tv-shows/page/:num'] = "watchmovies/tvshows/page/$1";
$route['watch/tv-shows/page'] = "watchmovies/tvshows/page";
$route['watch-genres/:any'] = "watchmovies/by_genre";
$route['watch-genres/:any/page'] = "watchmovies/by_genre/page/";
$route['watch-genres/:any/page/:num'] = "watchmovies/by_genre/page/$1";
$route['watch-movies-by-actor/:any'] = "watchmovies/by_actor";
$route['watch-movies-by-actor/:any/page'] = "watchmovies/by_actor/page/";
$route['watch-movies-by-actor/:any/page/:num'] = "watchmovies/by_actor/page/$1";
$route['watch-movies-by-keywords/:any'] = "watchmovies/by_keywords";
$route['watch-movies-by-keywords/:any/page'] = "watchmovies/by_keywords/page/";
$route['watch-movies-by-keywords/:any/page/:num'] = "watchmovies/by_keywords/page/$1";


$route['watch-starting-with/:any'] = "watchmovies/by_starting_letter";
$route['watch-starting-with/:any/page'] = "watchmovies/by_starting_letter/page/";
$route['watch-starting-with/:any/page/:num'] = "watchmovies/by_starting_letter/page/$1";

$route['watch-from-year/:num'] = "watchmovies/by_the_year";
$route['watch-from-year/:num/page'] = "watchmovies/by_the_year/page/";
$route['watch-from-year/:num/page/:num'] = "watchmovies/by_the_year/page/$1";

/* End of file routes.php */
/* Location: ./application/config/routes.php */