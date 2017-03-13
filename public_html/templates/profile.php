<main-nav></main-nav>
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
				<input type="file" class="form-control" id="inputFile">
				<p class="help-block">Choose your profile image</p>
			</div>
			<div class="form-group">
				<label for="profileType">Profile Type</label>
				<select name="profileType" class="form-control" id="profileType" [(ngModel)]="profile.profileTypeId" #profileType="ngModel">
					<option [value]="1">Fan</option>
					<option [value]="2">Artist</option>
					<option [value]="3">Venue</option>
				</select>
			</div>
			<div class="form-group">
				<label for="profileUserName">Profile User Name</label>
				<input class="form-control" type="text" id="profileUserName" name="profileUserName"
						 placeholder="current user name here..." [(ngModel)]="profile.profileUserName" #profileUserName="ngModel">
			</div>
			<div class="form-group">
				<label for="profileBio">Profile Bio</label>
				<textarea class="form-control" name="profileBio" id="profileBio" cols="20" rows="7"
							 placeholder="This will become their current profile bio..." [(ngModel)]="profile.profileBio" #profileBio="ngModel"></textarea>
			</div>
			<div class="form-group">
				<label for="profileLocation">Location</label>
				<input class="form-control" type="text" id="profileLocation" name="profileLocation"
						 placeholder="current user location here..." [(ngModel)]="profile.profileLocation" #profileLocation="ngModel">
			</div>
			<div class="form-group">
				<label for="profileSoundCloudUser">SoundCloud User Name (optional)</label>
				<input class="form-control" type="text" id="profileSoundCloudUser" name="profileSoundCloudUser"
						 placeholder="current SoundCloud user name here..." [(ngModel)]="profile.profileSoundCloudUser" #profileSoundCloudUser="ngModel">
			</div>

			<button class="btn btn-lg btn-info" type="submit" [disabled]="profileForm.invalid"><i class="fa fa-check"></i>&nbsp;Save</button>
		</form>
	</div>
</div>