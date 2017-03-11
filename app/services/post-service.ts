import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base-service";
import {Application} from "../classes/application";
import {Status} from "../classes/status";

@Injectable()
export class ApplicationService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private postId
}