<?php require_once("lib/head-utils.php"); ?>
<body>
	<?php require_once("nav.php"); ?>
	<!-- Button trigger modal -->
	<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#editProfileModal">
		Launch Post modal
	</button>
	<div class="modal fade" tabindex="-1" role="dialog" id="editProfileModal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Create Post</h4>
				</div>
				<div class="modal-body">
					<form action="#">
						<div class="form-group">
							<label for="inputFile">Profile Image</label>
							<input type="file" class="form-control" id="inputFile">
							<p class="help-block">Choose your post image</p>
						</div>
						<div class="form-group">
							<label for="postTitle">Title</label>
							<input class="form-control" type="text" id="profileUserName" name="profileUserName" placeholder="current user name here...">
						</div>
						<div class="form-group">
							<label for="eventDescription">Event Description</label>
							<textarea class="form-control" name="profileBio" id="profileBio" cols="20" rows="7" placeholder="This will become their current profile bio..."></textarea>
						</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Save changes</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</body>
</html>