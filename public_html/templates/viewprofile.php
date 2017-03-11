<?php require_once("lib/head-utils.php"); ?>
<body>
	<?php require_once("nav.php"); ?>
	<!-- Button trigger modal -->
	<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#editProfileModal">
		Launch profile modal
	</button>
	<div class="modal fade" tabindex="-1" role="dialog" id="editProfileModal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Edit Profile</h4>
				</div>
				<div class="modal-body">
					<form action="#">
						<div class="form-group">
							<label for="inputFile">Profile Image</label>
							<input type="file" class="form-control" id="inputFile">
							<p class="help-block">Choose your profile image</p>
						</div>
						<div class="form-group">
							<label for="profileType">Profile Type</label>
							<select name="profileType" class="form-control" id="profileType">
								<option value="1">Fan</option>
								<option value="2">Artist</option>
								<option value="3">Venue</option>
							</select>
						</div>
						<div class="form-group">
							<label for="profileUserName">Profile User Name</label>
							<input class="form-control" type="text" id="profileUserName" name="profileUserName" placeholder="current user name here...">
						</div>
						<div class="form-group">
							<label for="profileBio">Profile Bio</label>
							<textarea class="form-control" name="profileBio" id="profileBio" cols="20" rows="7" placeholder="This will become their current profile bio..."></textarea>
						</div>
						<div class="form-group">
							<label for="profileLocation">Location</label>
							<input class="form-control" type="text" id="profileLocation" name="profileLocation" placeholder="current user location here...">
						</div>
						<div class="form-group">
							<label for="profileSoundCloudUser">SoundCloud User Name (optional)</label>
							<input class="form-control" type="text" id="profileSoundCloudUser" name="profileSoundCloudUser" placeholder="current SoundCloud user name here...">
						</div>
					</form>
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