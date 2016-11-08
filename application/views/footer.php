<div id="footer">
	<div class="pull-left">
	<ul>
		<li><a href="<?php echo base_url(); ?>">Home</a></li>
		<li><a href="<?php echo base_url(); ?>watch/tv-shows">TV Shows</a></li>
		<li><a href="<?php echo base_url(); ?>watch/movies">Movies</a></li>
		<li><a href="<?php echo base_url(); ?>home/tos">TOS</a></li>
	</ul>
	</div>
	<div class="pull-right">
		<?php
		$ci = &get_instance();
		$site_title = $this->config->item('site_title');
		?>
		<h4><a href="<?php echo base_url(); ?>" style="text-decoration: none;color:#666699;"><?php echo $site_title ?></a></h4>
	</div>
</div>
</div><!--container-->
</body>
</html>