import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base-service";
import {Status} from "../classes/status";

@Injectable()
export class LogoutService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private logoutUrl = "api/logout/";

	get(): Observable<Status> {
		return (this.http.get(this.logoutUrl)
			.map(this.extractData)
			.catch(this.handleError));
	}
}