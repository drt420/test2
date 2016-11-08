<?php
require_once ('header.php');
?>

<div class="span8" style="margin-left:0px;">

	<div class="page-header">
		<h1>Edit Movie Links</h1>
		
		<?php require_once 'admin-menu.php'; ?>
		
		<?php if(isset($msg)) echo $msg; ?>

		<div class="well">
			<form method="post" action="">
				<input type="hidden" name="movieID" value="<?php echo $movieID; ?>"/>

				Tab Name:<br/> <input type="text" name="link_tab" value="<?=$m->link_tab?>" class="input-xxlarge"/><br/>
				Title:<br/> <input type="text" name="link_title" value="<?=$m->link_title?>" class="input-xxlarge"/><br/>
				
				Type:<br/>
				<select name="link_type">
					<option value="External" <?php if($m->link_type == 'External') echo 'selected' ?>>External</option>
					<option value="Embed" <?php if($m->link_type == 'Embed') echo 'selected' ?>>Embed</option>
				</select>

				<br/>
				Link/Embed Code:<br/>
				<textarea name="movie_link" placeholder="http://www.example.com" class="input-xxlarge" rows="5"/><?=htmlspecialchars($m->link_destination)?></textarea>

				<input type="submit" class="btn btn-medium btn-info" value="Save"/>
			</form>
		</div>
		
		
		
	</div>

</div>

<?php
	require_once 'sidebar.php';
 ?>

<?php
	require_once ('footer.php');
?>