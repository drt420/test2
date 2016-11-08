<?php
require_once ('header.php');
?>

<div class="span8" style="margin-left:0px;">

	<div class="page-header">
		<h1>Site Members</h1>

		<?php require_once 'admin-menu.php'; ?>
		
		<?php if(count($users)) : ?>
		<div class="alert alert-warning"><?php echo count($users) . ' total members in database'; ?></div>
		
		<table class="table table-bordered table-striped" id="dataTbl">
			<thead>
				<tr>
					<th>ID</th>
					<th>IP Addr</th>
					<th>Username</th>
					<th>Email</th>
					<th>Role</th>
					<th>Remove</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($users as $m) : ?>
			
				<tr>
					<td><?=$m->userID?></td>
					<td><?=long2ip($m->ip)?></td>
					<td><?=$m->username?></td>
					<td><?=($m->email)?></td>
					<td>
						<?php
						echo 'Role : <em>' . $m->role . '</em><br/>';

						if($m->role == 'user') :
							echo anchor('/admin/users/promote/' . $m->userID, 'Set Moderator');
						else:
							echo anchor('/admin/users/regular/' . $m->userID, 'Set Regular');
						endif;
						
						?>
					</td>
					<td><a href="/admin/users/remove/<?=$m->userID;?>"><b class="icon-remove"></b></a></td>
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