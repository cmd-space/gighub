<?php
require_once(dirname(__DIR__, 2) . "/php/classes/autoload.php");
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
?>

<form action="#">
	<div class="form-group">
		<label for="inputFile">Profile Image</label>
		<input type="file" class="form-control" id="inputFile">
		<p class="help-block">Choose your post image</p>
	</div>
	<div class="form-group">
		<label for="postTitle">Title</label>
		<input class="form-control" type="text" id="profileUserName" name="profileUserName"
				 placeholder="current user name here...">
	</div>
	<div class="form-group">
		<label for="eventDescription">Event Description</label>
		<textarea class="form-control" name="profileBio" id="profileBio" cols="20" rows="7"
					 placeholder="This will become their current profile bio..."></textarea>
	</div>
</form>

