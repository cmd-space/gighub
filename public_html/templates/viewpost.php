<?php
require_once(dirname(__DIR__, 2) . "/php/classes/autoload.php");
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
?>
	<main-nav></main-nav>

	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<h1 class="text-center">{{ post.postTitle }}</h1>
			<img src="https://www.fillmurray.com/140/200" alt="ALL the BMs" class="img-responsive center-block">
			<p class="text-center">{{ post.postImage }}</p>
			<h2 class="text-center">{{ post.postContent }}</h2>
			<p class="text-center">{{ post.postEventDate }}</p>
		</div>
	</div>
<?php
if(empty($_SESSION['post']) === false) {
	?>
	<div class="row">
		<div class="col-xs-12">
			<h1 class="text-center">Editing {{ post.postContent }}</h1>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<form #profileForm="ngForm" name="postForm" id="postForm" (ngSubmit)="putPost();" novalidate>
				<div class="form-group">
					<label for="inputFile">Post Image</label>
					<input type="file" class="form-control" name="inputFile" id="inputFile">
					<p class="help-block">Choose your post image</p>
				</div>
				<div class="form-group">
					<label for="postTitle">Post Title</label>
					<select name="postTitle" class="form-control" id="postTitle" [(ngModel)]="post.postTitleId" #postTitle="ngModel" required>
						<option [value]="2">Artist</option>
						<option [value]="3">Venue</option>
					</select>
					<div [hidden]="postTitle.valid || postTitle.pristine" class="alert alert-danger" role="alert">
						<p *ngIf="postTitle.errors?.required">Bloop</p>
					</div>
				</div>
				<div class="form-group">
					<label for="postId">Post Name</label>
					<input class="form-control" type="text" id="postId" name="postId"
							 placeholder="current user name here..." [(ngModel)]="post.postId" #postId="ngModel" required>
					<div [hidden]="postId.valid || postId.pristine" class="alert alert-danger" role="alert">
						<p *ngIf="postId.errors?.required">Bloop</p>
					</div>
				</div>
				<div class="form-group">
					<label for="postTitle">Post Title</label>
					<textarea class="form-control" name="postTitle" id="postTitle" cols="20" rows="7"
								 placeholder="This will become their current post title..." [(ngModel)]="post.postTitle" #profileBio="ngModel" required></textarea>
					<div [hidden]="postcontent.valid || postContent.pristine" class="alert alert-danger" role="alert">
						<p *ngIf="postContent.errors?.required">Bloop</p>
					</div>
				</div>
				<div class="form-group">
					<label for="postEventDate">Event Date</label>
					<input class="form-control" type="text" id="postEventDate" name="postEventDate"
							 placeholder="current Event Date Here..." [(ngModel)]="post.postEventDate" #postEventDate="ngModel" required>
					<div [hidden]="postEventDate.valid || postEventDate.pristine" class="alert alert-danger" role="alert">
						<p *ngIf="postEventDate.errors?.required">Bloop</p>
					</div>
				</div>
				<div class="form-group">
					<label for="profileSoundCloudUser">SoundCloud User Name (optional)</label>
					<input class="form-control" type="text" id="profileSoundCloudUser" name="profileSoundCloudUser"
							 placeholder="current SoundCloud user name here..." [(ngModel)]="profile.profileSoundCloudUser" #profileSoundCloudUser="ngModel">
					<div [hidden]="profileSoundCloudUser.valid || profileSoundCloudUser.pristine" class="alert alert-danger" role="alert">
						<p *ngIf="profileSoundCloudUser.errors?.required">Bloop</p>
					</div>
				</div>

				<button class="btn btn-lg btn-info" type="submit" [disabled]="profileForm.invalid"><i class="fa fa-check"></i>&nbsp;Save</button>
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