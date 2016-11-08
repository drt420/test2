<?php require_once ('header.php'); ?>

<?php require_once 'sidebar.php'; ?>

<div class="span8">
	
<div class="well">
	<?php if(isset($error)) 
	{
		echo $error;
	}else{
	if(!count($user)) {
		echo '-User details could not be fetched or user does not exist';
	}else{
	?>
	
	<h1><b class="icon-user" style="margin-top:20px;"></b> <?php echo $user->username; ?>'s Playlist</h1>
	<div class="well"><?php echo ($user->about == '') ? 'User did not write about him.' : $user->about; ?></div>
	
	<?php
	if(count($playlist)) {
		print '<ul class="playlist">';
		foreach($playlist as $p) {
			print '<li>';
			
			?>
			
			
			<?php $img_prop = array('src' => '/uploads/' . $p->thumbnail, 
								'width' => 60, 'height' => 80, 'alt' => htmlspecialchars($p->film_title)); ?>
			<a href="<?php echo '/watch-movies/'.url_title($p->film_title).'-'.$p->filmID; ?>">
			<?php echo img($img_prop); ?>
			</a>
			
			<?php
			print '<a href="/watch-movies/'.url_title($p->film_title).'-'.$p->filmID.'">'.$p->film_title.' ('.date("Y", $p->release_date).')</a>
					<br/>
					<span style="font-size:13px;" class="muted">
					Added on '.date("jS F Y", $p->date).'<br/>
					Rating '.number_format($p->rating,0).'/5 
					</span>
					<br/><a href="/watch-movies/'.url_title($p->film_title).'-'.$p->filmID.'">&#0187; Read more</a>
					</li>';
		}
		print '</ul>';
	}else{
		print 'Nothing in user playlist';
	}
	}
	}
	?>
</div>

</div>

<?php require_once ('footer.php'); ?>