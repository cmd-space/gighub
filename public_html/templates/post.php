<body>
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<h1 class="text-center">Create a new post</h1>
			</div>
		</div>

		<div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<form #postForm="ngForm" name="postForm" id="postForm" (ngSubmit)="postPost();" novalidate>

					<div class="form-group">
						<label for="postTitle">Post Title</label>
						<textarea class="form-control" name="postTitle" id="postTitle" cols="20" rows="7"
									 placeholder="Post title..." [(ngModel)]="post.postTitle"
									 #postTitle="ngModel" required></textarea>
						<div [hidden]="postTitle.valid || postTitle.pristine" class="alert alert-danger" role="alert">
							<p *ngIf="postTitle.errors?.required">Please include a valid post title</p>
						</div>
					</div>


					<div class="form-group">
						<label for="postContent">Post Content</label>
						<input class="form-control" type="text" id="postContent" name="postContent"
								 placeholder="Post Content..." [(ngModel)]="post.postContent" #postContent="ngModel">
						<div [hidden]="postContent.valid || postContent.pristine" class="alert alert-danger" role="alert">
							<p *ngIf="postContent.errors?.required">Please enter a valid description</p>
						</div>
					</div>

					<div class="form-group">
						<label for="postEventDate">Event Date</label>
						<input class="form-control" type="datetime" id="postEventDate" name="postEventDate"
								 [(ngModel)]="post.postEventDate"
								 #postEventDate="ngModel" required>
						<div [hidden]="postEventDate.valid || postEventDate.pristine" class="alert alert-danger"
							  role="alert">
							<p *ngIf="postEventDate.errors?.required">Please choose a valid date</p>
						</div>
					</div>
					<button class="btn btn-lg btn-info" type="submit" [disabled]="postForm.invalid"><i
							class="fa fa-check"></i>&nbsp;Post
					</button>
				</form>
			</div>
		</div>
	</div>
</body>