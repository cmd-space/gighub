<?php require_once( "lib/head-utils.php" ); ?>
<body class="sfooter">
	<div class="sfooter-content">
		<?php require_once( "nav.php" ); ?>
		<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#profileModal">
			Launch profile modal
		</button>
		<div class="modal fade" tabindex="-1" role="dialog" id="profileModal">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
								aria-hidden="true">&times;</span></button>
						<h4 class="modal-title text-center">{{ profileUserName }}</h4>
					</div>
					<div class="modal-body">
						<img src="http://www.fillmurray.com/140/200" alt="ALL the BMs" class="img-responsive center-block">
						<h2 class="text-center">{{ profileLocation }}</h2>
						<p class="text-center">{{ profileType }}</p>
						<p class="text-center">{{ profileSoundCloudUser }}</p>
						<p class="text-center">{{ profileBio }}</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	</div>
	<?php require_once( "footer.php" ); ?>
</body>
</html>