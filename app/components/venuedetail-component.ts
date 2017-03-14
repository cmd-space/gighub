import {Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {Venue} from "../classes/venue";
import {VenueService} from "../services/venue-service";
import {Status} from "../classes/status";
import "rxjs/add/operator/switchMap";


@Component({
	templateUrl: "./templates/venue-detail.php"
})

export class VenueDetailComponent implements OnInit {
	venue: Venue = new Venue(null, null, null, null, null, null, null, null);
	status: Status = null;

	constructor(private venueService: VenueService, private route: ActivatedRoute) {
	}

	ngOnInit(): void {
		this.getVenueByVenueId();
	}
	getVenueByVenueId() : void {
		this.route.params
			.switchMap((params : Params) => this.venueService.getVenueByVenueId(+params["venueId"]))
			.subscribe(reply => this.venue = reply);
	}

	putVenue() : void {
		this.venueService.putVenue(this.venue).subscribe(status => this.status = status);
	}

	postVenue() : void {
		this.venueService.postVenue(this.venue).subscribe(status => this.status = status);
	}
}