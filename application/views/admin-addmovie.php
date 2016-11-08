<?php
require_once ('header.php');
?>

<div class="span8" style="margin-left:0px;">

	<div class="page-header">
		<h1>Add new movie/tv show</h1>

		<?php require_once 'admin-menu.php'; ?>

		<form method="post" action="/admin/ajax_add_movie" id="ajax-movie-add" enctype="multipart/form-data">
			
			<label>ImDb Link</label>
			<input type="text" name="imdb_link" id="imdb_link" value="" class="input-xxlarge"/>
			<div id="imdb-load" style="display:none;"><img src="/img/ajax-loader.gif" /> Please wait trying to fetch data from IMDB. It may take up to 120 seconds...</div>
			<div id="imdb-error"></div>
			<br/> 
			
			<label>Title</label>
			<input type="text" name="film_title" id="title" value="" class="input-xxlarge"/>
			<br/>
			
			<div class="row">
			<span class="span3">	
			<label>Type</label>
			<input type="radio" name="film_type" value="movie" checked="checked"/> Movie 
			<input type="radio" name="film_type" value="tv-show" /> TV Show
			</span>
			
			<span class="span3">
			<label>Featured (appears on sidebar)</label>
			<input type="radio" name="is_featured" value="y" checked="checked"/> Yes 
			<input type="radio" name="is_featured" value="n" /> No
			</span>
			</div>
			
			<label>Runtime</label>
			<input type="text" name="runtime" id="runtime" value="" class="input-xxlarge"/>
			<br/>
			
			<label>Release Date <span class="muted">ex : 17th January 2011</span></label>
			<input type="text" name="release_date" id="release_date" value="" class="input-xxlarge"/>
			<br/>
			
			<label>Description</label>
			<textarea name="description" id="description" rows="5" value="" class="input-xxlarge"></textarea>
			<br/>
			
			<label>Tags <span class="muted">separated by comma</span></label>
			<textarea name="tags" rows="5" value="" class="input-xxlarge"></textarea>
			<br/>
			
			<label>Actors <span class="muted">separated by comma</span></label>
			<textarea name="actors" rows="5" value="" class="input-xxlarge" id="actors"></textarea>
			<br/>
			
			<label>Genres</label>
			<?php foreach($genres as $g) { ?>
			<input type="checkbox" name="genres[]" value="<?php echo $g->genreID; ?>" class="input-xxlarge" id="<?=$g->genre;?>"/> <?php echo $g->genre; ?>
			<?php } ?>
			<br/><br/>
			
			<label>Picture <span class="muted">Link or Upload</span></label>
			<span class="muted">provide remote url</span>
			<input type="text" name="thumbnail_url" id="thumb" class="input-xxlarge" placeholder="http://www."/>
			<br/><span class="muted">or upload file</span>
			<input type="file" name="thumbnail_file" class="input-xlarge"/>
			<br>
			<br/>
			
			<input type="submit" name="sb" id="sbaddmov" value="Save" class="btn btn-large btn-info"/>
		</form>
		
		<div class="ajax-movie-out"></div>
		

	</div>

</div>

<?php
	require_once 'sidebar.php';
 ?>

<?php
	require_once ('footer.php');
?>