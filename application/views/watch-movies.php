<?php require_once 'header.php'; ?>

<?php require_once 'sidebar.php';?>

<div class="span9">
	<div>
		
	<?php if(count($movie_info)) : ?>	
	<h3><b class="icon-film" style="margin-top:6px;"></b> Watch <?php print $movie_info[0]->film_title .' ('.date("Y", $movie_info[0]->release_date).')'; ?> Online</h3>
	<hr/>
	<div id="movID" style="display:none;"><?php echo $movie_info[0]->filmID; ?></div>
	
	<div class="span6" style="font-size:14px;">
		<?php print $movie_info[0]->description; ?>
		
		<div class="sharing_buttons" style="margin-top:20px;">
		<!-- AddThis Button BEGIN -->
		<div class="addthis_toolbox addthis_default_style ">
		<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
		<a class="addthis_button_tweet"></a>
		<a class="addthis_button_pinterest_pinit"></a>
		<a class="addthis_counter addthis_pill_style"></a>
		</div>
		<script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=xa-5092861a53f31e62"></script>
		<!-- AddThis Button END -->
	</div>

	</div>
	
	<div class="span2 single-image">
		<div style="position:relative">
		<?php $img_prop = array('src' => '/uploads/' . $movie_info[0]->thumbnail, 
								'width' => 140, 'height' => 160, 'alt' => htmlspecialchars($movie_info[0]->film_title)); ?>
		<?php echo img($img_prop); ?>
		<div style="position:absolute;bottom:0;right:0;color:white;background:black;padding:3px;"><?=$movie_info[0]->views?> views</div>
		</div>
		<br/>
		Rate this movie : 
		<ul class='star-rating'>
        <li class="current-rating" id="current-rating"><!-- will show current rating --></li>
            <span id="ratelinks">
                <li><a href="javascript:void(0)" title="1 star out of 5" class="one-star">1</a></li>
                <li><a href="javascript:void(0)" title="2 stars out of 5" class="two-stars">2</a></li>
                <li><a href="javascript:void(0)" title="3 stars out of 5" class="three-stars">3</a></li>
                <li><a href="javascript:void(0)" title="4 stars out of 5" class="four-stars">4</a></li>
                <li><a href="javascript:void(0)" title="5 stars out of 5" class="five-stars">5</a></li>
            </span>
        </ul>
        <div id="rate-result"></div>
	</div>
	
	<div style="clear:both;"></div>

		<hr/>
	
	<?php echo anchor($movie_info[0]->imdb_link, '<b class="icon-info-sign icon-white"></b> ImDb', array("class" => "btn btn-mini btn-warning")); ?>
	<a href="javascript:void(0);" class="btn btn-mini btn-danger submit-link"><b class="icon-plus-sign icon-white"></b> Submit Link</a>
	<a href="javascript:void(0);" class="btn btn-mini btn-info btn-dropdown add-to-playlist"><b class="icon-ok icon-white"></b> Add to Playlist</a>
	<div class="addtors"></div>
	
	<div class="well submit-link-div" style="display:none;">
		<?php if(is_user_logged_in()) : ?>
			<form method="post" action="/watchmovies/ajax_link_submit" id="submit-link-form">
				<input type="hidden" name="movieID" value="<?php echo $movie_info[0]->filmID; ?>"/>
				Title:<br/> <input type="text" name="link_title" placeholder="HQ Server #1" class="input-xxlarge"/><br/>
				Link:<br/><input type="text" name="movie_link" placeholder="http://www.example.com" class="input-xxlarge"/><br/>
				<input type="submit" class="btn btn-medium btn-info" value="Send it!"/>
			</form>
			<div class="submit-link-output"></div>
		<?php else: ?>
			- Please login first - 	
		<?php endif; ?>
	</div>
	
	<dl>
	  <dt>Runtime:</dt>
	    <dd><?php print $movie_info[0]->runtime; ?></dd>
	  <dt>Release Date:</dt>
	    <dd><?php print date("jS F Y", $movie_info[0]->release_date); ?></dd>
	  <dt>Genres:</dt>
	    <dd>
	    	<ul class="genres">
	    	<?php foreach($genres as $genre): ?>
	    		<li><a href="/watch-genres/<?php echo url_title($genre->genre); ?>"><?php echo $genre->genre; ?></a></li>
	    	<?php endforeach; ?>
	    	</ul>
	    	<div style="clear:both;"></div>
	    </dd>
	  <dt>Actors:</dt>
	    <dd>
	    	<?php 
	    	$actors = rtrim($movie_info[0]->actors, ", "); 
			
			if(stristr($actors, ",")) {
				$actors = explode(",", $actors);
				array_walk($actors, 'add_url_on_tags', '/watch-movies-by-actor');
				echo ul($actors, array("class" => "genres"));
				echo '<div style="clear:both;"></div>';
			}elseif(!empty($actors)) {
				echo '<ul class="genres">';
					echo'<li><a href="/watch-movies-by-actor/'.url_title($actors).'">'.$actors.'</a></li>'; 
				echo '</ul>'; 
			}else{
				echo '-no actors added to this movie-';
			}
			
	    	?>
		</dd>  
	</dl>
	
	<h3><b class="icon-play-circle" style="margin-top:9px;"></b> <?php print $movie_info[0]->film_title .' ('.date("Y", $movie_info[0]->release_date).')'; ?> Watch Links</h3><hr/>

	<?php
	echo '<ul class="movie_links">';
		echo '<li style="background-color:#dcddcf;text-indent:20px;">'.$ads.'</li>';
	echo "</ul>";
	
	if(count($movie_links)) {

		$tab_links = array();
		foreach($movie_links as $mlink) {
			$tab_links[$mlink->link_tab][$mlink->linkID] = $mlink;
		}
		
		
		$i = 0;
		echo '<br/><ul class="nav nav-tabs">';
		foreach($tab_links as $tab_name => $ml) {			
			$i++;
			if($i == 1) {
				echo '<li class="active"><a href="#' . url_title($tab_name) . '" data-toggle="tab">' . $tab_name . '</a></li>';
			}else{
				echo '<li><a href="#' . url_title($tab_name) . '" data-toggle="tab">' . $tab_name . '</a></li>';
			}
		}
		echo '</ul>';//nav-tabs

			
				echo '<div class="tab-content">';

				$k  = 0;
				foreach($tab_links as $tab_name => $ml) {			
				$k++;

				if($k==1) {
					echo '<div class="tab-pane active" id="' . url_title($tab_name) . '">
					  <ul class="movie_links">';
				}else{
					echo '<div class="tab-pane" id="' . url_title($tab_name) . '">
					  <ul class="movie_links">';
				}

				$i = 0;
				foreach($ml as $l) {
				$i++;


				$l =		(object) $l;
					
				$works = $l->link_ok;
				$broken = $l->link_broken;
				$link_anchor = ($l->link_type == 'External') ? anchor('watchmovies/go/'.$l->linkID, $l->link_title, array("target" => '_blank')) : anchor('/watchmovies/embed/'.$l->linkID, $l->link_title, array('class' => 'modal-embedded', 'data-target' => '/watchmovies/embed/'.$l->linkID));
				
				$color = ($i%2==0) ? '#dcddcf' : '#F2F2F2'; 
				
				echo '<li style="background-color:'.$color.'">
						   <div class="span4">
							' . $link_anchor . '
					   	   </div>
					   	   <div class="span2" style="font-size:13px;width:200px;">
					   	   <a style="color:green;" href="javascript:void(0);" data-lID='.$l->linkID.' class="rate-external" data-type="works"><b class="icon-thumbs-up"></b> Works (<span class="works-'.$l->linkID.'">'.$works.'</span>)</a>
					   	   '.nbs(2).'
					   	   <a style="color:#cc0000;" href="javascript:void(0);" data-lID='.$l->linkID.' class="rate-external" data-type="broken"><b class="icon-thumbs-down"></b> Broken (<span class="broken-'.$l->linkID.'">'.$broken.'</span>)</a>
					   	   <div class="rate-external-result-'.$l->linkID.'"></div> 
					   	   </div>
					   	   <div style="clear:both;"></div>
					 </li>';

				}

				echo '</ul>
					  </div>';
				}

				echo '</div>';
		
	}

	?>
	
	<div style="clear:both;"></div>
	
	<h3><b class="icon-tags" style="margin-top:9px;"></b> <?php print $movie_info[0]->film_title .' ('.date("Y", $movie_info[0]->release_date).')'; ?> Keywords</h3>
	<hr/>
	<?php
	$tags = $movie_info[0]->tags;
	if(stristr($tags, ",")) {
		$tags = explode(",", $tags);
		array_walk($tags, 'add_url_on_tags', '/watch-movies-by-keywords');
		echo '<dl><dd>';
		echo ul($tags, array("class" => "genres"));
		echo '</dd></dl>';
		echo '<div style="clear:both;"></div>';
	}elseif(!empty($tags)) {
		echo '<ul class="genres">';
			echo'<li><a href="/watch-movies-by-keywords/'.url_title($tags).'">'.$tags.'</a></li>'; 
		echo '</ul>';
		echo '<div style="clear:both;"></div>'; 
	}else{
		echo '-no tags-';
	}
	?>

	<h3><b class="icon-share-alt"></b> Related Movies</h3>
	<?php if(isset($related_movies)) : ?>
		<?php if(count($related_movies)) :
			$i=0;
			foreach($related_movies as $ftv):
				$i++;
				?>

				<?php
				$anchor_type = ($ftv->film_type == 'movie') ? 'watch-movies' : 'watch-tv-shows';
				?>

				<?php $img_prop = array('src' => '/uploads/' . $ftv->thumbnail,
					'width' => 50, 'height' => 110, 'alt' => htmlspecialchars($ftv->film_title)); ?>

				<div class="small-item-sidebar">
					<a href="<?php echo '/'.$anchor_type.'/'.url_title($ftv->film_title).'-'.$ftv->filmID; ?>">
						<?php echo img($img_prop); ?>
					</a>
					<br/>
					<a href="<?php echo '/'.$anchor_type.'/'.url_title($ftv->film_title).'-'.$ftv->filmID; ?>">
						<?php echo $ftv->film_title . ' ('. date("Y", $ftv->release_date) . ')'; ?>
					</a>
					<br/>
					Rating <?php echo $ftv->rating > 0 ? number_format($ftv->rating, 0).'/5' : 'N/A'; ?>
				</div>
				<?php if($i%6==0) echo '<br style="clear:both;"/>'; ?>
			<?php endforeach; endif; ?>
	<?php endif; ?>
	<div style="clear:both;"></div>

	<h3><b class="icon-comment" style="margin-top:9px;"></b> <?php print $movie_info[0]->film_title .' ('.date("Y", $movie_info[0]->release_date).')'; ?> Comments</h3><hr/>
	<?php if(is_user_logged_in()) : ?>
		<?php
		echo form_open('/watchmovies/ajax_comment', array('class' => 'form', "id" => 'comment-form'), array('movID' => $movie_info[0]->filmID));
		echo form_textarea(array('name' => 'comment', 'cols' => 24, 'rows' => 6, 'class' => 'input-xxlarge required'));
		echo form_submit('sbComment', 'Submit comment', 'class="btn btn-info"');
		echo form_close();
		?>
		<div id="comment_output"></div>
	<?php else: ?>
		<div class="alert alert-warning">Please login to comment</div>
	<?php endif; ?>
		<hr/>
		
		<?php if(count($movie_comments)) : ?>
		<ul class="user_comments">
		<?php foreach($movie_comments as $c) : ?>
		
		<li data-lastID="<?php echo $c->commID; ?>">
			<span class="comment_author"><b class="icon-user"></b> <?php echo anchor('users/profile/'.url_title($c->username), $c->username); ?> on <b class="icon-calendar"></b><em><?php echo date("jS F Y H:ia", $c->comm_date); ?></em></span>
			<div class="comment_content"><?php echo wordwrap($c->comment, 80, '<br/>', TRUE); ?></div>
		</li>
		
		<?php endforeach; ?>
		<?php endif; ?>
	
	<?php else: ?>
		- Movie info not found -
	<?php endif; ?>
	
	</div>
</div>

<?php require_once 'footer.php'; ?>