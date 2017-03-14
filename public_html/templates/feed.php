<main-nav></main-nav>
<body>
	<div class="container" id="feed">
		<div class="row" *ngFor="let post of posts">
			<div class="col-md-2"></div>
			<div class="col-md-8 pull-left">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">{{ post.postTitle }}</h3>
						<p></p>
					</div>
					<img src="" alt="">
					Feed content
				</div>
			</div>
		</div>
	</div>
</body>