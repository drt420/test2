<?php require_once ('header.php'); ?>

<?php require_once 'sidebar.php'; ?>

<div class="span8">
	
<div class="well">
	<h3>My Account. <?php echo anchor(base_url() . 'users/logout', 'Logout'); ?> / <a href="/users/profile/<?php echo url_title($user->username) ?>">My Playlists</a></h3>
	
	<?php
	if(isset($form_message)) print $form_message;
	?>
	
	<form method="post" action="" id="acc-form" accept-charset="UTF-8">
		<label>
			Username: <span class="muted">cannot change</span>
		</label>
		<input type="text" name="username" value="<?php print htmlspecialchars($user->username); ?>" class="required" readonly="readonly"/>
		
		<br/>
		
		<label>
			Email Address:
		</label>
		<input type="email" name="email" value="<?php print htmlspecialchars($user->email); ?>" class="required" />
		
		<br/>
		
		<label>
			Password: <span class="muted">current or a new one</span>
		</label>
		<input type="password" name="password" placeholder="****" class="required" />
		
		<br/>
		
		<label>About: <span class="muted">max 255 characters (no links or spam)</span></label>
		<textarea name="about" rows="6" cols="45" class="input-xlarge"><?php print htmlspecialchars($user->about); ?></textarea>
		
		<br/>
		
		<input type="submit" name="sb_signup" value="Update" class="btn btn-info"/>
	
	</form>
	
	<div id="signup_output"></div>
	
</div>

</div>

<?php require_once ('footer.php'); ?>