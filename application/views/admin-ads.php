<?php
require_once ('header.php');
?>

<div class="span8" style="margin-left:0px;">

	<div class="page-header">
		<h1>Update AD Code to show before download links</h1>

		<?php require_once 'admin-menu.php'; ?>
		<?php if(isset($error)) echo $error; ?>
		
		<form method="post" action="">
		<textarea name="ads" class="input-xxlarge" rows="25" cols="45"><?=$ads;?></textarea>
		
		<input type="submit" name="sb" value="Save TOS" class="btn btn-large btn-info"/>	
		</form>
		
	</div>

</div>

<?php
	require_once 'sidebar.php';
 ?>

<?php
	require_once ('footer.php');
?>