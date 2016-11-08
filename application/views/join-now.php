<?php require_once ('header.php'); ?>

<div class="span4 offset3">
	
<div class="page-header">
	<h1>Join Now. It's Free!</h1>
	 
	<form method="post" action="/users/ajax_join" id="signup-form" accept-charset="UTF-8">
		<label>
			Username:
		</label>
		<input type="text" name="username" placeholder="username" class="required"/>
		
		<br/>
		
		<label>
			Email:
		</label>
		<input type="email" name="email" placeholder="email" class="required" />
		
		<br/>
		
		<label>
			Password:
		</label>
		<input type="password" name="password" placeholder="****" class="required" />
		
		<br/>
		
		<input type="submit" name="sb_signup" value="Join Now" class="btn btn-warning"/>
	
	</form>
	
	<div id="signup_output_div"></div>
	
</div>

</div>

<div class="span2"></div>

<?php require_once 'sidebar.php'; ?>

<?php require_once ('footer.php'); ?>