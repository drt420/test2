<?php require_once ('header.php'); ?>

<div class="span8" style="margin-left:0px;">
	
<div class="page-header">
	<h1>Terms Of Service</h1>
	
	<?php if(isset($tos) AND count($tos)) print $tos->tos; ?>
	
</div>

</div>

<?php require_once 'sidebar.php'; ?>

<?php require_once ('footer.php'); ?>