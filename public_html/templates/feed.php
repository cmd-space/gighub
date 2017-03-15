<main-nav></main-nav>
<body>
	<div class="container" id="feed">
		<div class="row" *ngFor="let post of posts">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">{{ post.postTitle }}</h3>
					</div>
					<p style="color: black;">{{ post.postContent }}</p>
					<p style="color: black;">{{ post.postEventDate['date'] | date: 'MM/dd/yyyy' }}</p>
				</div>
			</div>
		</div>
	</div>
</body>