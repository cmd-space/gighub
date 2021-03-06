<?php
require_once( dirname( __DIR__, 2 ) . "/php/classes/autoload.php" );
if ( session_status() !== PHP_SESSION_ACTIVE ) {
	session_start();
}
?>

<main-nav></main-nav>
<body>
<div class="container" id="venue-detail">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<h1 class="text-center">{{ venue.venueName }}</h1>
			<img src="https://www.fillmurray.com/140/200" alt="ALL the BMs" class="img-responsive center-block">
			<h2 class="text-center">{{venue.venueStreet1}}</h2>
			<h2 class="text-center">{{venue.venueStreet2}}</h2>
			<p class="text-center">{{venue.venueCity}}</p>
			<p class="text-center">{{venue.venueState}}</p>
			<p class="text-center">{{venue.venueZip}}</p>
		</div>
	</div>

	<?php
	if ( empty( $_SESSION['profile'] ) === false ) {
		?>

		 <div class="row">
			 <div class="col-xs-12">
				 <h1 class="text-center">Editing {{venue.venueName}}</h1>
			 </div>
		 </div>

		 <!-- Venue Image Block-->
		 <div class="row">
			<div class="col-md-4"></div>
			 <div class="col-md-4">
				 <form #venueForm="ngForm" name="venueForm" id="venueForm" (ngSubmit)="putVenue()" novalidate>
					 <div class="form-group">
						 <label for="inputFile">Venue Image</label>
						 <input type="file" class="form-control" name="inputFile">
						 <p class="help-block">Choose your Venue's profile Image</p>
					 </div>

					 <!-- Venue name Block-->
					 <div class="form-group">
						 <label for="venueName">Venue Name</label>
						 <input class="form-control" type="text" id="venueName" name="venueName"
								  placeholder="{{ venue.venueName }}" [(ngModel)]="venue.venueName" #venueName="ngModel"
								  required>
						 <div [hidden]="venueName.valid || venueName.pristine" class="alert alert-danger" role="alert">
							 <p *ngIf="venueName.errors?.required">Flop</p>
						 </div>
					 </div>

					 <!-- Address 1 bloc-->
					 <div class="form-group">
						 <label for="venueStreet1">Street Address</label>
						 <input class="form-control" type="text" id="venueStreet1" name="venueStreet1"
								  placeholder="current user location here..." [(ngModel)]="venue.venueStreet1"
								  #venueStreet1="ngModel" required>
						 <div [hidden]="venueStreet1.valid || venueStreet1.pristine" class="alert alert-danger" role="alert">
							 <p *ngIf="venueStreet1.errors?.required">Flop</p>
						 </div>
					 </div>

					 <!-- Address 2 Block -->
					 <div class="form-group">
						 <label for="venueStreet2">Street Address 2</label>
						 <input class="form-control" type="text" id="venueStreet2" name="venueStreet2"
								  placeholder="Optional Secondary Street Address..." [(ngModel)]="venue.venueStreet2"
								  #venueStreet2="ngModel" required>
						 <div [hidden]="venueStreet2.valid || venueStreet2.pristine" class="alert alert-danger" role="alert">
							 <p *ngIf="venueStreet2.errors?.required">Flop</p>
						 </div>
					 </div>

					 <!--Venue City Block -->
					 <div class="form-group">
						 <label for="venueCity">City</label>
						 <input class="form-control" type="text" id="venueCity" name="venueCity"
								  placeholder="Current user city name..." [(ngModel)]="venue.venueCity" #venueCity="ngModel"
								  required>
						 <div [hidden]="venueCity.valid || venueCity.pristine" class="alert alert-danger" role="alert">
							 <p *ngIf="venueCity.errors?.required">Flop</p>
						 </div>
					 </div>

					 <!-- Venue State Block -->
					 <div class="form-group">
						 <label for="venueState">State</label>
						 <input class="form-control" type="text" id="venueState" name="venueState"
								  placeholder="{{ venue.venueState }}" [(ngModel)]="venue.venueState"
								  #venueState="ngModel" required>
						 <div [hidden]="venueState.valid || venueState.pristine" class="alert alert-danger" role="alert">
							 <p *ngIf="venueState.errors?.required">Please enter a valid state</p>
						 </div>
					 </div>

					 <!-- Venue Zip Code -->
					 <div class="form-group">
						 <label for="venueZip">Zip Code</label>
						 <input class="form-control" type="text" id="venueZip" name="venueZip"
								  placeholder="{{ venue.venueZip }}" [(ngModel)]="venue.venueZip" #venueZip="ngModel" required>
						 <div [hidden]="venueZip.valid || venueZip.pristine" class="alert alert-danger" role="alert">
							 <p *ngIf="venueZip.errors?.required">Please enter a valid zip</p>
						 </div>
					 </div>

					 <button class="btn btn-lg btn-info" type="submit" [disabled]="venueForm.invalid"><i
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
				 <p class="text-center">D E N I E D!! Login if you would like to edit your Venue profile.</p>
			 </div>
		 </div>
	<?php } ?>
	}
</div>
</body>