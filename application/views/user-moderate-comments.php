<?php require_once ('header.php'); ?>

<?php require_once 'sidebar.php'; ?>

<div class="span8">
	
<div class="well">
	<h3>Comments Moderator Panel.</h3>

	<ul class="nav nav-tabs">
		<li><?php echo anchor(base_url() . 'users/moderator', 'Links'); ?></li>
		<li class="active"><?php echo anchor(base_url() . 'users/moderator_comments', 'Comments'); ?></li>
	</ul>
	
	<?php if(count($comments_to_moderate)) : ?>
	<div class="alert alert-warning"><?php echo count($comments_to_moderate) . ' total comments in database'; ?></div>
	
	<table class="table table-bordered table-striped" id="dataTbl">
		<thead>
			<tr>
				<th>Movie</th>
				<th>Comment</th>
				<th>Date</th>
				<th>User</th>
				<th>Remove</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			foreach($comments_to_moderate as $m) : 
			?>
			<tr>
				<td><?=anchor('/watch-movies/'.url_title($m->film_title).'-'.$m->filmID, $m->film_title, array('target' => '_blank')); ?></td>
				<td><?=$m->comment?></td>
				<td><?=date('jS F Y', $m->comm_date)?></td>
				<td><?=$m->username.'<br/>'.@long2ip($m->ip_address)?></td>
				<td><a href="/users/moderator_comments/remove/<?=$m->commID;?>"><b class="icon-remove"></b></a></td>
			</tr>
		
			<?php endforeach; ?>
		</tbody>
	</table>
	
	<?php else: ?>
		
		- no comments -
	
	<?php endif; ?>

	
</div>

</div>

<?php require_once ('footer.php'); ?>