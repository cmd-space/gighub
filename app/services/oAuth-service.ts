import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base-service";
import {OAuth} from "../classes/oAuth";

@Injectable()
export class PostService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private oAuthUrl = "api/oauth/";

	getAllOAuths(): Observable<OAuth> {
		return (this.http.get(this.oAuthUrl)
			.map(this.extractData)
			.catch(this.handleError));
	}
}