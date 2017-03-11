import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base-service";
import {ProfileType} from "../classes/profileType";
// import {Status} from "../classes/status";

@Injectable()
export class ProfileTypeService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private profileTypeUrl = "api/profileType/";

	getProfileTypeByProfileTypeId(profileTypeId: number) : Observable<ProfileType> {
		return (this.http.get(this.profileTypeUrl + profileTypeId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getProfileTypesByProfileTypeName(profileTypeName: string) : Observable<ProfileType> {
		return (this.http.get(this.profileTypeUrl + profileTypeName)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getAllProfileTypes() : Observable<ProfileType> {
		return (this.http.get(this.profileTypeUrl)
			.map(this.extractData)
			.catch(this.handleError));
	}
}