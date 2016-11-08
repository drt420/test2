<?php require_once ('header.php'); ?>

<?php #require_once 'sidebar.php'; ?>


	
<div class="well">
	<h3>Links Moderator Panel</h3>
	
	<ul class="nav nav-tabs">
		<li class="active"><?php echo anchor(base_url() . 'users/moderator', 'Links'); ?></li>
		<li><?php echo anchor(base_url() . 'users/moderator_comments', 'Comments'); ?></li>
	</ul>

	<?php
		if(!count($links_to_moderate)) {
			print '-No links to moderate-';
		}else{
		?>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>Link Movie</th>
					<th>Link Tab</th>
					<th>Link Title</th>
					<th>Link By</th>
					<th>Destination</th>
					<th>Status</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($links_to_moderate as $l) : ?>
					<?php
					$movieID = $l->mID;
					$status = ($l->status == 'pending') ? "Pending " . anchor('/admin/movielinks/'.$movieID.'/do/approve/'.$l->linkID, "Approve") : 'Live';
					?>
					<tr>
						<td><strong><a target="_blank" href="/watch-movies/<?=url_title($l->film_title)?>-<?=$l->filmID?>"><?=$l->film_title; ?></strong></td>
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

<?php require_once ('footer.php'); ?>