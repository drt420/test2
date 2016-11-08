<?php require_once 'header.php'; ?>

<?php require_once 'sidebar.php'; ?>

<div class="span9">
	<div>

	<div class="pull-left">
		<h3><b class="icon-film" style="margin-top:3px;"></b> <?php echo $vid_type; ?></h3>
	</div>
	<div class="pull-right">
		<?php if(!isset($hide_sort)): ?>
		<br />
		<div class="btn-group">
			<a class="btn dropdown-toggle btn-mini" data-toggle="dropdown" href="#">
				Sort by
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a href="?sort=recent">Added Date</a></li>
				<li><a href="?sort=release">Release Date</a></li>
				<li><a href="?sort=views">Views Count</a></li>
				<li><a href="?sort=rating">Rating (on our site)</a></li>
			</ul>
		</div>
		<?php endif;?>
	</div>
	<hr style="clear:both;">
	<?php if(isset($error)) print $error; ?>
	
	<?php if(!isset($movies) OR !count($movies)) : ?>
		No result for <?php echo str_replace(array("Watch", "Online"), array("",""), $vid_type); ?>
	<?php else: ?>
	
	
	<?php $i=0; foreach($movies as $FMovie): $i++; ?>
		
		<div class="small-item" <?php if($i%6==1) print 'style="clear:both;"';?>>
		<?php $img_prop = array('src' => '/uploads/' . $FMovie->thumbnail, 
								'width' => 90, 'height' => 70, 'alt' => htmlspecialchars($FMovie->film_title)); ?>
		<?php if($FMovie->film_type == 'movie'): ?>
			<a href="<?php echo '/watch-movies/'.url_title($FMovie->film_title).'-'.$FMovie->filmID; ?>">
		<?php else: ?>
			<a href="<?php echo '/watch-movies/'.url_title($FMovie->film_title).'-'.$FMovie->filmID; ?>">
		<?php endif; ?>
			<div style="position:relative">
			<?php echo img($img_prop); ?>
			<div style="position:absolute;bottom:2px;right:-2px;color:white;background:black;padding:1px;"><?=$FMovie->views?> views</div>
			</div>
			</a>
		<br/>
		
		<?php if($FMovie->film_type == 'movie'): ?>
			<a href="<?php echo '/watch-movies/'.url_title($FMovie->film_title).'-'.$FMovie->filmID; ?>"><?php echo $FMovie->film_title . ' ('. date("Y", $FMovie->release_date) . ')'; ?></a>
			<?php else: ?>
			<a href="<?php echo '/watch-tv-shows/'.url_title($FMovie->film_title).'-'.$FMovie->filmID; ?>"><?php echo $FMovie->film_title . ' ('. date("Y", $FMovie->release_date) . ')'; ?></a>
		<?php endif; ?>
		<br/>
		Rating <?php echo number_format($FMovie->rating,0); ?>/5
		</div>
	
	<?php endforeach; ?>
	
	<hr/>
	<div style="clear: both;"></div>
	
	<?php if($pagination) print $pagination; ?>
		
	<?php endif; ?>
	
	</div>
</div>

<?php require_once 'footer.php'; ?>