<?php
require_once ('header.php');
?>

<div class="span8" style="margin-left:0px;">

	<div class="page-header">
		<h1>Comments from members</h1>

		<?php require_once 'admin-menu.php'; ?>
		
		<?php if(count($comments)) : ?>
		<div class="alert alert-warning"><?php echo count($comments) . ' total comments in database'; ?></div>
		
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
				<?php foreach($comments as $m) : ?>
			
				<tr>
					<td><?=anchor('/watch-movies/'.url_title($m->film_title).'-'.$m->filmID, $m->film_title, array('target' => '_blank')); ?></td>
					<td><?=$m->comment?></td>
					<td><?=date('jS F Y', $m->comm_date)?></td>
					<td><?=$m->username.'<br/>'.long2ip($m->ip)?></td>
					<td><a href="/admin/comments/remove/<?=$m->commID;?>"><b class="icon-remove"></b></a></td>
				</tr>
			
				<?php endforeach; ?>
			</tbody>
		</table>
		
		<?php else: ?>
			
			- no comments -
		
		<?php endif; ?>
	</div>

</div>

<?php
	require_once 'sidebar.php';
 ?>

<?php
	require_once ('footer.php');
?>