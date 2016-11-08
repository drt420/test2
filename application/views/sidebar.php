<div class="span2" style="width: 200px;">

	<?php
	if(is_admin()) {
		print '<a href="/admin" class="btn btn-large btn-danger">Admin Panel</a><br/><br/>';
	}
	if(is_moderator()) {
		print '<a href="/users/moderator" class="btn btn-medium btn-warning">Moderator Panel</a><br/><br/>';	
	}
	?>

	<?php
	if(is_user_logged_in()) :
	?>	
		
		<h3><b class="icon-user" style="margin-top:7px;"></b> My Account</h3>
		<ul class="nav nav-tabs nav-stacked">
			<li><?php echo anchor(base_url() . 'users', 'My Profile'); ?></li>
			<li><?php echo anchor(base_url() . 'users/logout', 'Logout'); ?></li>
		</ul>

	<?php else: ?>	
		
		<h3><b class="icon-user" style="margin-top:7px;"></b> Login/Join</h3>

		<div class="well"><?php if(isset($login_message)) echo $login_message; ?>
		<form method="post" action="/users/login" class="form">
			<input type="text" name="uname" placeholder="username"/><br/>
			<input type="password" name="upwd" placeholder="****"/><br/>
			<input type="submit" name="sbLogin" value="Login" class="btn btn-warning"/>

			&nbsp; <small><em><a href="/users/join">Don't have an account?</a></em></small>
		</form>
		</div>
	<?php endif; ?>

	<h3><b class="icon-play" style="margin-top:7px;"></b> Watch</h3>
	<ul class="nav nav-tabs nav-stacked">
		<li><a href="<?php echo base_url(); ?>watch/movies"><b class="icon-film"></b> Movies</a></li>
		<li><a href="<?php echo base_url(); ?>watch/tv-shows"><b class="icon-facetime-video"></b> TV Shows</a></li>
	</ul>

    <h3><b class="icon-hdd" style="margin-top:7px;"></b> Genres</h3>
    <ul class="nav nav-tabs nav-stacked">
	    <?php 
		if(count(genres_dropdown())) : 
		foreach(genres_dropdown() as $g) : 
			echo '<li> '. anchor('/watch-genres/'.url_title($g->genre), $g->genre) . '</li>' ;
		endforeach; 
		endif; 
		?>
	</ul>
		
	
	<hr/>
	
	
	<h4><b class="icon-comment" style="margin-top:7px;"></b> Recent Comments</h4>

	<div class="well">
	<?php
	$comments = latest_comments();
	if(count($comments)) : 
	foreach($comments as $cSideBar) :
	?>

	<div class="side-comment">
	<a href="/watch-movies/<?php echo url_title($cSideBar->film_title).'-'.$cSideBar->filmID; ?>"><?php echo $cSideBar->film_title; ?></a><br/>
	<a href="/users/profile/<?php echo url_title($cSideBar->username); ?>" class="movie-sidebar"><?php echo $cSideBar->username; ?></a>: <?php echo substr($cSideBar->comment, 0, 60); ?>...
	</div><!--side-comment-->
	
	<?php endforeach; ?>
	<?php else: ?>
	-no comments-
	<?php endif; ?>
	</div>

	
	<div style="clear:both;"></div>
</div>