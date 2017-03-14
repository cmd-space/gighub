<?php
require_once( dirname( __DIR__, 2 ) . "/php/classes/autoload.php" );
require_once( dirname( __DIR__, 2 ) . "/php/lib/xsrf.php" );
if ( session_status() !== PHP_SESSION_ACTIVE ) {
	session_start();
}
?>
<main-nav></main-nav>
<div class="container">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<h1 class="text-center">{{ profile.profileUserName }}</h1>
			<img src="https://www.fillmurray.com/140/200" alt="ALL the BMs" class="img-responsive center-block">
			<h2 class="text-center">{{ profile.profileLocation }}</h2>
			<p class="text-center">{{ profile.profileSoundCloudUser }}</p>
			<p class="text-center">{{ profile.profileBio }}</p>
		</div>
	</div>
	<?php
	if ( empty( $_SESSION['profile'] ) === false ) {
		?>
		 <div class="row">
			 <div class="col-xs-12">
				 <h1 class="text-center">Editing {{ profile.profileUserName }}</h1>
			 </div>
		 </div>

		 <div class="row">
			 <div class="col-md-4"></div>
			 <div class="col-md-4">
				 <form #profileForm="ngForm" name="profileForm" id="profileForm" (ngSubmit)="putProfile();" novalidate>
					 <div class="form-group">
						 <label for="inputFile">Profile Image</label>
						 <input type="file" class="form-control" name="inputFile" id="inputFile">
						 <p class="help-block">Choose your profile image</p>
					 </div>
					 <div class="form-group">
						 <label for="profileType">Profile Type</label>
						 <select name="profileType" class="form-control" id="profileType" [(ngModel)]="profile.profileTypeId"
									#profileType="ngModel" required>
							 <option [value]="1">Fan</option>
							 <option [value]="2">Artist</option>
							 <option [value]="3">Venue</option>
						 </select>
						 <div [hidden]="profileType.valid || profileType.pristine" class="alert alert-danger" role="alert">
							 <p *ngIf="profileType.errors?.required">Bloop</p>
						 </div>
					 </div>
					 <div class="form-group">
						 <label for="profileUserName">Profile User Name</label>
						 <input class="form-control" type="text" id="profileUserName" name="profileUserName"
								  placeholder="current user name here..." [(ngModel)]="profile.profileUserName"
								  #profileUserName="ngModel" required>
						 <div [hidden]="profileUserName.valid || profileUserName.pristine" class="alert alert-danger"
								role="alert">
							 <p *ngIf="profileUserName.errors?.required">Bloop</p>
						 </div>
					 </div>
					 <div class="form-group">
						 <label for="profileBio">Profile Bio</label>
						 <textarea class="form-control" name="profileBio" id="profileBio" cols="20" rows="7"
									  placeholder="This will become their current profile bio..."
									  [(ngModel)]="profile.profileBio" #profileBio="ngModel" required></textarea>
						 <div [hidden]="profileBio.valid || profileBio.pristine" class="alert alert-danger" role="alert">
							 <p *ngIf="profileBio.errors?.required">Bloop</p>
						 </div>
					 </div>
					 <div class="form-group">
						 <label for="profileLocation">Location</label>
						 <input class="form-control" type="text" id="profileLocation" name="profileLocation"
								  placeholder="current user location here..." [(ngModel)]="profile.profileLocation"
								  #profileLocation="ngModel" required>
						 <div [hidden]="profileLocation.valid || profileLocation.pristine" class="alert alert-danger"
								role="alert">
							 <p *ngIf="profileLocation.errors?.required">Bloop</p>
						 </div>
					 </div>
					 <div class="form-group">
						 <label for="profileSoundCloudUser">SoundCloud User Name (optional)</label>
						 <input class="form-control" type="text" id="profileSoundCloudUser" name="profileSoundCloudUser"
								  placeholder="current SoundCloud user name here..." [(ngModel)]="profile.profileSoundCloudUser"
								  #profileSoundCloudUser="ngModel">
						 <div [hidden]="profileSoundCloudUser.valid || profileSoundCloudUser.pristine"
								class="alert alert-danger" role="alert">
							 <p *ngIf="profileSoundCloudUser.errors?.required">Bloop</p>
						 </div>
					 </div>

					 <button class="btn btn-lg btn-info" type="submit" [disabled]="profileForm.invalid"><i
							 class="fa fa-check"></i>&nbsp;Save
					 </button>
				 </form>
			 </div>
		 </div>

		<?php
	} else {
		?>
		 <div class="row">
			 <div class="col-xs-12">
				 <p class="text-center">Please Login if you would like to edit your profile. That'd be great.</p>
			 </div>
		 </div>
	<?php } ?>
</div>
