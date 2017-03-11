import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base-service";
import {Venue} from "../classes/venue";
import {Status} from "../classes/status";

@Injectable()
export class VenueService extends BaseService {
	constructor(protected http: Http){
		super(http);
	}

	private venueUrl = "api/venue/";

	getVenueByVenueId(venueId: number) : Observable<Venue> {
		return(this.http.get(this.venueUrl + venueId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getVenueByVenueProfileId(venueProfileId: number) : Observable<Venue> {
		return(this.http.get(this.venueUrl + venueProfileId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getVenueByVenueCity(venueCity: string) : Observable<Venue[]> {
		return(this.http.get(this.venueUrl + venueCity)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getVenueByVenueName(venueName: string) : Observable<Venue[]> {
		return(this.http.get(this.venueUrl + venueName)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getVenueByVenueStreet1(venueStreet1: string) : Observable<Venue[]> {
		return(this.http.get(this.venueUrl + venueStreet1)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getVenueByVenueZip(venueZip: string) : Observable<Venue[]> {
		return(this.http.get(this.venueUrl + venueZip)
			.map(this.extractData)
			.catch(this.handleError));
	}

	postVenue(venue: Venue) : Observable<Status> {
		return(this.http.post(this.venueUrl, venue)
			.map(this.extractMessage)
			.catch(this.handleError));
	}
	putVenue(venue: Venue) : Observable<Venue>{
		return(this.http.put(this.venueUrl + venue.venueId, venue)
			.map(this.extractMessage)
			.catch(this.handleError));
	}
	deleteVenue(venue: Venue) : Observable<Venue>{
		return(this.http.delete(this.venueUrl + venue.venueId)
			.map(this.extractMessage)
			.catch(this.handleError));
	}
}