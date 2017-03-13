<?php

?>

<main-nav></main-nav>

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

<div *ngIf="profile.profileId === this.profileId">
	<h1>hai</h1>
</div>