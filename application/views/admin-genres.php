<?php
require_once ('header.php');
?>

<div class="span8" style="margin-left:0px;">

	<div class="page-header">
		<h1>Movies &amp; TV Shows Genres</h1>

		<?php require_once 'admin-menu.php'; ?>
		
		<?php if(count($comments)) : ?>
		<div class="alert alert-warning"><?php echo count($comments) . ' total genres in database'; ?></div>
		
		<?php if(isset($error)) print $error; ?>
		<form method="post" action="" class="form-horizontal">
			New Genre : <input type="text" name="genre" /><input type="submit" name="sb" value="Add" class="btn"/>
		</form>
		
		<table class="table table-bordered table-striped" id="dataTbl">
			<thead>
				<tr>
					<th>ID</th>
					<th>Genre Name</th>
					<th>Movies</th>
					<th>Remove</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($comments as $m) : ?>
			
				<tr>
					<td><?=$m->genreID?></td>
					<td><?=$m->genre?></td>
					<td><?=$m->tMovies?></td>
					<td><a href="/admin/genres/remove/<?=$m->genreID;?>"><b class="icon-remove"></b></a></td>
				</tr>
			
				<?php endforeach; ?>
			</tbody>
		</table>
		
		<?php else: ?>
			
			- no genres -
		
		<?php endif; ?>
	</div>

</div>

<?php
	require_once 'sidebar.php';
 ?>

<?php
	require_once ('footer.php');
?>