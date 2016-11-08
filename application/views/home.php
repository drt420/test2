<?php require_once 'header.php'; ?>

<div class="span9">
	<div>
	<h3><b class="icon-film" style="margin-top:7px;"></b> Watch Movies Online</h3>
	
	<ul class="nav nav-tabs">
		<li class="active">
			<a href="#recent-movies" data-toggle="tab">Recent Movies</a>
		</li>
		<li>
			<a href="#top-rated-movies" data-toggle="tab">Top Rated</a>
		</li>
		<li>
			<a href="#most-commented-movies" data-toggle="tab">Most Commented</a>
		</li>
		<li>
			<a href="#most-links-movies" data-toggle="tab">Most Links</a>
		</li>
	</ul>

	<div class="tab-content">
		<div class="tab-pane active" id="recent-movies">
		<?php if(count($featured_movies)) : ?>
			<?php $i=0; foreach($featured_movies as $FMovie): $i++; ?>
			<div class="small-item" <?php if($i%6==1) print 'style="clear:both;"';?>>
			<?php $img_prop = array('src' => '/uploads/' . $FMovie->thumbnail, 
									'width' => 90, 'height' => 140, 'alt' => htmlspecialchars($FMovie->film_title)); ?>
			
			<div style="position:relative;">
			<a href="<?php echo '/watch-movies/'.url_title($FMovie->film_title).'-'.$FMovie->filmID; ?>">
			<?php echo img($img_prop); ?>
			</a>
			<div style="position:absolute;bottom:2px;right:-2px;color:white;background:black;padding:1px;"><?=$FMovie->views?> views</div>
			</div>

			<br/>
			<a href="<?php echo '/watch-movies/'.url_title($FMovie->film_title).'-'.$FMovie->filmID; ?>"><?php echo $FMovie->film_title . ' ('. date("Y", $FMovie->release_date) . ')'; ?></a>
			<br/>
			Rating <?php echo $FMovie->rating > 0 ? number_format($FMovie->rating, 0).'/5' : 'N/A'; ?>
			</div>
		
		<?php endforeach; ?>
		<hr/>
		<div style="clear: both;"></div>
		<?php else: ?>
			- No Movies -
		<?php endif; ?>
		</div><!--recent movies tab-->

		<div class="tab-pane" id="most-commented-movies">
		<?php if(count($commented_movies)) : ?>
			<?php $i=0; foreach($commented_movies as $FMovie): $i++; ?>
			<div class="small-item" <?php if($i%6==1) print 'style="clear:both;"';?>>
			<?php $img_prop = array('src' => '/uploads/' . $FMovie->thumbnail, 
									'width' => 90, 'height' => 140, 'alt' => htmlspecialchars($FMovie->film_title)); ?>
			
			<div style="position:relative;">
			<a href="<?php echo '/watch-movies/'.url_title($FMovie->film_title).'-'.$FMovie->filmID; ?>">
			<?php echo img($img_prop); ?>
			</a>
			<div style="position:absolute;bottom:2px;right:-2px;color:white;background:black;padding:1px;"><?=$FMovie->views?> views</div>
			</div>

			<br/>
			<a href="<?php echo '/watch-movies/'.url_title($FMovie->film_title).'-'.$FMovie->filmID; ?>"><?php echo $FMovie->film_title . ' ('. date("Y", $FMovie->release_date) . ')'; ?></a>
			<br/>
			Rating <?php echo $FMovie->rating > 0 ? number_format($FMovie->rating, 0).'/5' : 'N/A'; ?>
			</div>
		
		<?php endforeach; ?>
		<hr/>
		<div style="clear: both;"></div>
		<?php else: ?>
			- No comments -
		<?php endif; ?>
		</div><!--most commented tab-->

		<div class="tab-pane" id="most-links-movies">
		<?php if(count($linked_movies)) : ?>
			<?php $i=0; foreach($linked_movies as $FMovie): $i++; ?>
			<div class="small-item" <?php if($i%6==1) print 'style="clear:both;"';?>>
			<?php $img_prop = array('src' => '/uploads/' . $FMovie->thumbnail, 
									'width' => 90, 'height' => 140, 'alt' => htmlspecialchars($FMovie->film_title)); ?>
			

			<div style="position:relative;">
			<a href="<?php echo '/watch-movies/'.url_title($FMovie->film_title).'-'.$FMovie->filmID; ?>">
			<?php echo img($img_prop); ?>
			</a>
			<div style="position:absolute;bottom:2px;right:-2px;color:white;background:black;padding:1px;"><?=$FMovie->views?> views</div>
			</div>

			<br/>
			<a href="<?php echo '/watch-movies/'.url_title($FMovie->film_title).'-'.$FMovie->filmID; ?>"><?php echo $FMovie->film_title . ' ('. date("Y", $FMovie->release_date) . ')'; ?></a>
			<br/>
			Rating <?php echo $FMovie->rating > 0 ? number_format($FMovie->rating, 0).'/5' : 'N/A'; ?>
			</div>
		
		<?php endforeach; ?>
		<hr/>
		<div style="clear: both;"></div>
		<?php else: ?>
			- No links -
		<?php endif; ?>
		</div><!--most linked tab-->

		<div class="tab-pane" id="top-rated-movies">
		<?php if(count($top_movies)) : ?>
			<?php $i=0; foreach($top_movies as $FMovie): $i++; ?>
			<div class="small-item" <?php if($i%6==1) print 'style="clear:both;"';?>>
			<?php $img_prop = array('src' => '/uploads/' . $FMovie->thumbnail, 
									'width' => 90, 'height' => 140, 'alt' => htmlspecialchars($FMovie->film_title)); ?>
			
			<div style="position:relative;">
			<a href="<?php echo '/watch-movies/'.url_title($FMovie->film_title).'-'.$FMovie->filmID; ?>">
			<?php echo img($img_prop); ?>
			</a>
			<div style="position:absolute;bottom:2px;right:-2px;color:white;background:black;padding:1px;"><?=$FMovie->views?> views</div>
			</div>

			<br/>
			<a href="<?php echo '/watch-movies/'.url_title($FMovie->film_title).'-'.$FMovie->filmID; ?>"><?php echo $FMovie->film_title . ' ('. date("Y", $FMovie->release_date) . ')'; ?></a>
			<br/>
			Rating <?php echo $FMovie->rating > 0 ? number_format($FMovie->rating, 0).'/5' : 'N/A'; ?>
			</div>
		
		<?php endforeach; ?>
		<hr/>
		<div style="clear: both;"></div>
		<?php else: ?>
			- No votes -
		<?php endif; ?>
		</div><!--top tab-->

	</div><!--movies tabs-->
	<h3><b class="icon-film" style="margin-top:7px;"></b> Watch TV Shows Online</h3>

	<ul class="nav nav-tabs">
		<li class="active">
			<a href="#recent-tv-shows" data-toggle="tab">Recent TV Shows</a>
		</li>
		<li>
			<a href="#top-rated-tv-shows" data-toggle="tab">Top Rated</a>
		</li>
		<li>
			<a href="#most-commented-tv-shows" data-toggle="tab">Most Commented</a>
		</li>
		<li>
			<a href="#most-links-tv-shows" data-toggle="tab">Most Links</a>
		</li>
	</ul>

	<div class="tab-content">
		<div class="tab-pane active" id="recent-tv-shows">
		<?php if(count($movies)) : ?>
			<?php $j = 0; foreach($movies as $FMovie): $j++; ?>
			<div class="small-item" <?php if($j%6==1) print 'style="clear:both;"';?>>
			<?php $img_prop = array('src' => '/uploads/' . $FMovie->thumbnail, 
									'width' => 90, 'height' => 140, 'alt' => htmlspecialchars($FMovie->film_title)); ?>
			
			<div style="position:relative;">
			<a href="<?php echo '/watch-movies/'.url_title($FMovie->film_title).'-'.$FMovie->filmID; ?>">
			<?php echo img($img_prop); ?>
			</a>
			<div style="position:absolute;bottom:2px;right:-2px;color:white;background:black;padding:1px;"><?=$FMovie->views?> views</div>
			</div>

			<br/>
			<a href="<?php echo '/watch-tv-shows/'.url_title($FMovie->film_title).'-'.$FMovie->filmID; ?>"><?php echo $FMovie->film_title . ' ('. date("Y", $FMovie->release_date) . ')'; ?></a>
			<br/>
			Rating <?php echo number_format($FMovie->rating,0); ?>/5
			</div>
		
		<?php endforeach; ?>
		<hr/>
		<div style="clear: both;"></div>
		<?php else: ?>
			- No TV Shows -
		<?php endif; ?>
		</div><!--recent tv shows-->

		<div class="tab-pane" id="most-commented-tv-shows">
		<?php if(count($commented_shows)) : ?>
			<?php $i=0; foreach($commented_shows as $FMovie): $i++; ?>
			<div class="small-item" <?php if($i%6==1) print 'style="clear:both;"';?>>
			<?php $img_prop = array('src' => '/uploads/' . $FMovie->thumbnail, 
									'width' => 90, 'height' => 140, 'alt' => htmlspecialchars($FMovie->film_title)); ?>
			
			<div style="position:relative;">
			<a href="<?php echo '/watch-movies/'.url_title($FMovie->film_title).'-'.$FMovie->filmID; ?>">
			<?php echo img($img_prop); ?>
			</a>
			<div style="position:absolute;bottom:2px;right:-2px;color:white;background:black;padding:1px;"><?=$FMovie->views?> views</div>
			</div>

			<br/>
			<a href="<?php echo '/watch-tv-shows/'.url_title($FMovie->film_title).'-'.$FMovie->filmID; ?>"><?php echo $FMovie->film_title . ' ('. date("Y", $FMovie->release_date) . ')'; ?></a>
			<br/>
			Rating <?php echo $FMovie->rating > 0 ? number_format($FMovie->rating, 0).'/5' : 'N/A'; ?>
			</div>
		
		<?php endforeach; ?>
		<hr/>
		<div style="clear: both;"></div>
		<?php else: ?>
			- No comments -
		<?php endif; ?>
		</div><!--most commented tab-->

		<div class="tab-pane" id="most-links-tv-shows">
		<?php if(count($linked_shows)) : ?>
			<?php $i=0; foreach($linked_shows as $FMovie): $i++; ?>
			<div class="small-item" <?php if($i%6==1) print 'style="clear:both;"';?>>
			<?php $img_prop = array('src' => '/uploads/' . $FMovie->thumbnail, 
									'width' => 90, 'height' => 140, 'alt' => htmlspecialchars($FMovie->film_title)); ?>
			
			<div style="position:relative;">
			<a href="<?php echo '/watch-movies/'.url_title($FMovie->film_title).'-'.$FMovie->filmID; ?>">
			<?php echo img($img_prop); ?>
			</a>
			<div style="position:absolute;bottom:2px;right:-2px;color:white;background:black;padding:1px;"><?=$FMovie->views?> views</div>
			</div>

			<br/>
			<a href="<?php echo '/watch-tv-shows/'.url_title($FMovie->film_title).'-'.$FMovie->filmID; ?>"><?php echo $FMovie->film_title . ' ('. date("Y", $FMovie->release_date) . ')'; ?></a>
			<br/>
			Rating <?php echo $FMovie->rating > 0 ? number_format($FMovie->rating, 0).'/5' : 'N/A'; ?>
			</div>
		
		<?php endforeach; ?>
		<hr/>
		<div style="clear: both;"></div>
		<?php else: ?>
			- No links -
		<?php endif; ?>
		</div><!--most linked tab-->

		<div class="tab-pane" id="top-rated-tv-shows">
		<?php if(count($top_shows)) : ?>
			<?php $i=0; foreach($top_shows as $FMovie): $i++; ?>
			<div class="small-item" <?php if($i%6==1) print 'style="clear:both;"';?>>
			<?php $img_prop = array('src' => '/uploads/' . $FMovie->thumbnail, 
									'width' => 90, 'height' => 140, 'alt' => htmlspecialchars($FMovie->film_title)); ?>
			

			<div style="position:relative;">
			<a href="<?php echo '/watch-movies/'.url_title($FMovie->film_title).'-'.$FMovie->filmID; ?>">
			<?php echo img($img_prop); ?>
			</a>
			<div style="position:absolute;bottom:2px;right:-2px;color:white;background:black;padding:1px;"><?=$FMovie->views?> views</div>
			</div>

			<br/>
			<a href="<?php echo '/watch-movies/'.url_title($FMovie->film_title).'-'.$FMovie->filmID; ?>"><?php echo $FMovie->film_title . ' ('. date("Y", $FMovie->release_date) . ')'; ?></a>
			<br/>
			Rating <?php echo $FMovie->rating > 0 ? number_format($FMovie->rating, 0).'/5' : 'N/A'; ?>
			</div>
		
		<?php endforeach; ?>
		<hr/>
		<div style="clear: both;"></div>
		<?php else: ?>
			- No Votes -
		<?php endif; ?>
		</div><!--top tab-->


	</div><!--tv shows tabs-->
	
	</div>
</div>

<?php require_once 'sidebar.php'; ?>
<div style="clear: both;"></div>

<?php require_once 'footer.php'; ?>