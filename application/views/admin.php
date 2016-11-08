<?php
require_once ('header.php');
?>

<div class="span8" style="margin-left:0px;">

	<div class="page-header">
		<h1>Movies/TV Shows Database</h1>

		<?php require_once 'admin-menu.php'; ?>
		
		<?php if(count($movies)) : ?>
		<div class="alert alert-warning"><?php echo count($movies) . ' total movies & tv shows in database'; ?></div>
		
		<table class="table table-bordered table-striped" id="dataTbl">
			<thead>
				<tr>
					<th>Title</th>
					<th>Released</th>
					<th>Featured</th>
					<th>Links</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($movies as $m) : ?>
			
				<tr>
					<td><?=anchor('/watch-movies/'.url_title($m->film_title).'-'.$m->filmID, $m->film_title, array('target' => '_blank')); ?></td>
					<td><?=date("jS F Y", $m->release_date)?></td>
					<td><?=strtoupper($m->is_featured)?></td>
					<td><?=anchor('/admin/movielinks/'.$m->filmID, $m->tL .' Links', ($m->tPending > 0) ? array("style" => "color:#cc0000;") : '')?></td>
					<td>
						<a href="/admin/update_movie/<?=$m->filmID;?>"><b class="icon-edit"></b></a>
						&nbsp; 
						<a href="/admin/index/remove/<?=$m->filmID;?>"><b class="icon-remove"></b></a>
					</td>
				</tr>
			
				<?php endforeach; ?>
			</tbody>
		</table>
		
		<?php endif; ?>
	</div>

</div>

<?php
	require_once 'sidebar.php';
 ?>

<?php
	require_once ('footer.php');
?>