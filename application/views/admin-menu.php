<?php
$ci = & get_instance();
?>
<ul class="nav nav-tabs">
	<li<?php if($ci->router->fetch_method() == 'index') print ' class="active"'; ?>>
		<a href="/admin">Movies</a>
	</li>
	<li<?php if($ci->router->fetch_method() == 'addmovie') print ' class="active"'; ?>>
		<a href="/admin/addmovie">Add Movie</a>
	</li>
	<li<?php if($ci->router->fetch_method() == 'genres') print ' class="active"'; ?>>
		<a href="/admin/genres">Genres</a>
	</li>
	<li<?php if($ci->router->fetch_method() == 'users') print ' class="active"'; ?>>
		<a href="/admin/users">Users</a>
	</li>
	<li<?php if($ci->router->fetch_method() == 'comments') print ' class="active"'; ?>>
		<a href="/admin/comments">Comments</a>
	</li>
	<li<?php if($ci->router->fetch_method() == 'tos') print ' class="active"'; ?>>
		<a href="/admin/tos">TOS</a>
	</li>
	<li<?php if($ci->router->fetch_method() == 'ads') print ' class="active"'; ?>>
		<a href="/admin/ads">Ads</a>
	</li>
	<li>
		<a href="/admin/logout">Log out</a>
	</li>
</ul>