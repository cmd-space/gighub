<main-nav></main-nav>
<div class="container" id="feed">
	<div class="row" *ngFor="let  of applicationCohorts" (click)="switchApplication(applicationCohort.info[0]);">
		<div class="col-md-2"></div>
		<div class="col-md-8 pull-left">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Post Title</h3>
				</div>
						<img src="" alt="">
					Feed content
				</div>
			</div>
		</div>
	</div>
</div>