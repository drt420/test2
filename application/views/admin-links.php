<?php
require_once ('header.php');
?>


	<div class="page-header">
		<h1><?php if(isset($links[0])) { echo $links[0]->film_title; }; ?> Links (total <?=count($links)?>)</h1>
		
		<?php require_once 'admin-menu.php'; ?>
		
		<div class="well">
			<form method="post" action="/watchmovies/ajax_link_submit" id="submit-link-form">
				<input type="hidden" name="movieID" value="<?php echo $movieID; ?>"/>
				Tab Name:<br/> <input type="text" name="link_tab" placeholder="Series 1, Series 2, etc." class="input-xxlarge"/><br/>
				Title:<br/> <input type="text" name="link_title" placeholder="HQ Server #1" class="input-xxlarge"/><br/>
				Type:<br/>
				<select name="link_type">
					<option>External</option>
					<option>Embed</option>
				</select>

				<br/>
				Link/Embed Code:<br/>
				<textarea name="movie_link" placeholder="http://www.example.com" class="input-xxlarge" rows="5"/></textarea>

				<br/>
				<input type="submit" class="btn btn-medium btn-info" value="Save"/>
			</form>
			<div class="submit-link-output"></div>
		</div>
		
		
		<?php
		if(!count($links)) {
			print '-No links-';
		}else{
		?>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>Link Tab</th>
					<th>Link Title</th>
					<th>Link By</th>
					<th>Destination</th>
					<th>OK</th>
					<th>Broken</th>
					<th>Status</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($links as $l) : ?>
					<?php
					$status = ($l->status == 'pending') ? "Pending " . anchor('/admin/movielinks/'.$movieID.'/do/approve/'.$l->linkID, "Approve") : 'Live';
					?>
					<tr>
						<td><strong><?=$l->link_tab; ?></strong></td>
						<td><?=$l->link_title; ?></td>
						<td><?=$l->username!=NULL ? anchor('/users/profile/'.url_title($l->username), $l->username,array('target' => '_blank')) : '--'?></td>
						<td><?php
							if($l->link_type == 'External') : 
								echo anchor($l->link_destination, $l->link_destination, array('target' => '_blank')); 
							else:
								echo htmlspecialchars($l->link_destination);
							endif;
							?>
						</td>
						<td><?=$l->link_ok?></td>
						<td><?=$l->link_broken?></td>
						<td><?=$status?></td>
						<td>
							<a href="/admin/movielinks/<?=$movieID?>/remove/<?=$l->linkID?>"><b class="icon-remove"></b>
								<a href="/admin/movielinksedit/<?=$movieID?>/<?=$l->linkID?>"><b class="icon-edit"></b>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php	
		}
		?>
		
	</div>


<?php
	#require_once 'sidebar.php';
 ?>

<?php
	require_once ('footer.php');
?>