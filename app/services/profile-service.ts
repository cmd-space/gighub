import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base-service";
import {Profile} from "../classes/profile";
import {Status} from "../classes/status";

@Injectable()
export class ProfileService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private profileUrl = "api/profile/";

	getProfileByProfileId(profileId: number) : Observable<Profile> {
		return (this.http.get(this.profileUrl + profileId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getProfileByProfileOAuthId(profileOAuthId: number) : Observable<Profile> {
		return (this.http.get(this.profileUrl + profileOAuthId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getProfileByProfileTypeId(profileTypeId: number) : Observable<Profile[]> {
		return (this.http.get(this.profileUrl + profileTypeId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getProfileByLocationContent(profileLocation: string) : Observable<Profile[]> {
		return (this.http.get(this.profileUrl + profileLocation)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getProfileBySoundCloudUser(profileSoundCloudUser: string) : Observable<Profile[]> {
		return (this.http.get(this.profileUrl + profileSoundCloudUser)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getProfileByProfileUserName(profileUserName: string) : Observable<Profile[]> {
		return (this.http.get(this.profileUrl + profileUserName)
			.map(this.extractData)
			.catch(this.handleError));
	}

	putProfile(profile: Profile) : Observable<Profile>{
		return(this.http.put(this.profileUrl + profile.profileId, profile)
			.map(this.extractMessage)
			.catch(this.handleError));

	}
	deleteProfile(profile: Profile) : Observable<Profile>{
		return(this.http.delete(this.profileUrl + profile.profileId)
			.map(this.extractMessage)
			.catch(this.handleError));
	}
}