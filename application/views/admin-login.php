<?php require_once ('header.php'); ?>

<div class="span8" style="margin-left:0px;">
	
<div class="page-header">
	<h1>Admin Login.</h1>
	
	<?php if(isset($form_message)) print $form_message; ?>
	
	<form method="post" action="/admin/login" class="form">
		<input type="text" name="u" placeholder="username"/><br/>
		<input type="password" name="p" placeholder="****"/><br/>
		<input type="submit" name="sbLogin" value="Login" class="btn btn-inverse"/>
	</form>
	
</div>

</div>

<?php require_once 'sidebar.php'; ?>

<?php require_once ('footer.php'); ?>