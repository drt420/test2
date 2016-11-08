<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<title><?php if(isset($seo_title)) 
				 {
				 	$seo_title = strip_tags($seo_title);
				    echo $seo_title;
				 }else{
				 	$ci = &get_instance();
					echo ucfirst($ci->router->fetch_class()) . ' ' . ucfirst($ci->router->fetch_method()) . ' - ' . strip_tags($ci->config->item('site_title'));
				 } 
			?> 
	</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:600italic,700italic,400,600,700' rel='stylesheet' type='text/css'>		
    <link href="<?php echo base_url(); ?>css/bootstrap.css" type="text/css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>css/colorbox.css" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css" />
    <link href="<?php echo base_url(); ?>rating/starrating.css" rel="stylesheet" type="text/css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>skins/ie7/skin.css" />
    <script src="http://code.jquery.com/jquery-1.8.2.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>/js/jquery.carouFredSel-6.2.1.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>js/bootstrap.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>/js/jquery.validate.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.form.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>/js/jquery.colorbox-min.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/ajax.js"></script>    
    <script src="<?php echo base_url(); ?>rating/starrating.js" type="text/javascript"></script>
	<!--[if gte IE 9]>
	  <style type="text/css">
	    .gradient {
	       filter: none;
	    }
	  </style>
	<![endif]-->
</head>
<body>

<div class="top gradient">
	<div class="container">
		<div class="pull-left">
			<?php
			$ci = &get_instance();
			$site_title = $this->config->item('site_title');
			?>
			<h2>
				<a href="<?php echo base_url(); ?>">
					<img src="/img/video.png" alt="Watch Movies Online">
					<?php echo $site_title; ?>
				</a>
			</h2>
			<div class="headline">Free Movies &amp; TV Shows</div>
		</div>

		<div class="pull-left">
			<ul class="nav-top">
				<li><a href="/">Home</a></li>
				<li><a href="/watch/movies">Movies</a></li>
				<li><a href="/watch/tv-shows">TV Shows</a></li>
			</ul>
		</div>

		<div class="pull-right whitefont" style="padding-top:20px;">
			<form class="form-search navbar-search pull-left" action="<?php echo base_url(); ?>search_movies" method="POST">
		        <div class="input-append">
		        
		        <input type="text" class="appendedInputButton input-medium" name="q" id="search_term" placeholder="Movie/Show Title" style="width:130px;" autocomplete="off">
		        <button type="submit" class="btn" name="sb">Search</button>

		        </div>
		    </form>
			<div class="autocomplete-result"></div>

		    <script>
		    $(function() {
		    	$("#search_term").bind("change keyup",function(){
		    		$.get('/ajax/search', { 'search_term' : $(this).val() }, function(data) {
		    			$(".autocomplete-result").html(data);
		    		});
		    	});
		    });
		    </script>
		</div>
		
	</div>
</div>

<div class="container">
<div class="list_carousel">
	<ul id="featured-carousel">
		<?php if(count(featured_sidebar())) : foreach(featured_sidebar() as $ftv): ?>

		<?php 
		$anchor_type = ($ftv->film_type == 'movie') ? 'watch-movies' : 'watch-tv-shows';
		?>

		<?php $img_prop = array('src' => '/uploads/' . $ftv->thumbnail, 
								'width' => 90, 'height' => 140, 'alt' => htmlspecialchars($ftv->film_title)); ?>

		<li>
			<div style="position:relative;">
			<a href="<?php echo '/watch-movies/'.url_title($ftv->film_title).'-'.$ftv->filmID; ?>">
			<?php echo img($img_prop); ?>
			</a>
			<div style="font-size: 12px;position:absolute;bottom:2px;right:-2px;color:white;background:black;padding:1px;"><?=$ftv->views?> views</div>
			</div>
		</li>
		<?php endforeach; endif; ?>
	</ul>
	<div class="clearfix"></div>

	<a id="prev2" class="prev btn btn-small" href="#">&lt;</a>
	<a id="next2" class="next btn btn-small" href="#">&gt;</a>
	
	<div id="pager2" class="pager"></div>
	<div class="clearfix"></div>
</div>
</div>
	
<div class="container">

<div class="AZ-bar">
<div style="float:left;margin-right: 20px;">Movie Title</div>
<ul class="starting-letter">
<li><a href="/watch-starting-with/0-9">0-9</a></li>
<?php 
foreach( range('A', 'Z') as $letter ) {
	echo '<li><a href="/watch-starting-with/' . $letter . '">' . $letter . '</a></li>';
}
?>
</ul>
<div style="float:right;">
<div class="btn-group">
<a class="btn dropdown-toggle btn-mini" data-toggle="dropdown" href="#">By Year <span class="caret"></span></a>
<ul class="dropdown-menu year-dropdown">
    <?php 
    foreach( range( date("Y"), 1970 ) as $letter ) {
		echo '<li><a href="/watch-from-year/' . $letter . '">' . $letter . '</a></li>';
	}
	?>
</ul>
<Div style="clear:both;"></Div>
</div>
</div>
<Div style="clear:both;"></Div>
</div>
</div><!--A-Z Bar-->

<div class="container">