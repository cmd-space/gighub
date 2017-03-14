<?php
require_once( dirname( __DIR__, 2 ) . "/php/classes/autoload.php" );
if ( session_status() !== PHP_SESSION_ACTIVE ) {
	session_start();
}
?>
<main-nav></main-nav>
<div class="container">
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
	if ( empty( $_SESSION['profile'] ) === false ) {
		?>
		 <div class="row">
			 <div class="col-xs-12">
				 <h1 class="text-center">Editing {{ post.postTitle }}</h1>
			 </div>
		 </div>

		 <div class="row">
			 <div class="col-md-4"></div>
			 <div class="col-md-4">
				 <form #postForm="ngForm" name="postForm" id="postForm" (ngSubmit)="putPost();" novalidate>
					 <div class="form-group">
						 <label for="inputFile">Post Image</label>
						 <input type="file" class="form-control" name="inputFile" id="inputFile">
						 <p class="help-block">Choose your post image</p>
					 </div>

					 <div class="form-group">
						 <label for="postTitle">Post Title</label>
						 <textarea class="form-control" name="postType" id="postType" cols="20" rows="7"
									  placeholder="This is where you put the title. put it." [(ngModel)]="post.postTitle"
									  #postTitle="ngModel" required></textarea>
						 <div [hidden]="postTitle.valid || postTitle.pristine" class="alert alert-danger" role="alert">
							 <p *ngIf="postTitle.errors?.required">Bloop</p>
						 </div>
					 </div>


					 <div class="form-group">
						 <label for="postContent">Post Content</label>
						 <input class="form-control" type="text" id="postContent" name="postContent"
								  placeholder="Post Content Here..." [(ngModel)]="post.postContent" #postContent="ngModel">
						 <div [hidden]="postContent.valid || postContent.pristine" class="alert alert-danger" role="alert">
							 <p *ngIf="postContent.errors?.required">Bloop</p>
						 </div>
					 </div>

					 <div class="form-group">
						 <label for="postEventDate">Event Date</label>
						 <input class="form-control" type="text" id="postEventDate" name="postEventDate"
								  placeholder="current user location here..." [(ngModel)]="post.postEventDate"
								  #postEventDate="ngModel" required>
						 <div [hidden]="postEventDate.valid || postEventDate.pristine" class="alert alert-danger"
								role="alert">
							 <p *ngIf="postEventDate.errors?.required">Bloop</p>
						 </div>
					 </div>

				 </form>
			 </div>
		 </div>

		<?php
	} else {
		?>
		 <div class="row">
			 <div class="col-xs-12">
				 <p class="text-center">Please Login if you would like to edit your post. That'd be great.</p>
			 </div>
		 </div>
	<?php } ?>
</div>
