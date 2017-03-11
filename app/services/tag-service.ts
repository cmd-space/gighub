import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base-service";
import {Tag} from "../classes/tag";
import {Status} from "../classes/status";

@Injectable()
export class TagService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private tagUrl = "api/tag/";

	getTagByTagId(tagId: number) : Observable<Tag> {
		return (this.http.get(this.tagUrl + tagId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getTagByTagContent(tagContent: string) : Observable<Tag[]> {
		return (this.http.get(this.tagUrl + tagContent)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getAllTags() : Observable<Tag[]> {
		return (this.http.get(this.tagUrl)
			.map(this.extractData)
			.catch(this.handleError));
	}

	postTag(tag: Tag) : Observable<Status> {
		return(this.http.post(this.tagUrl, tag)
			.map(this.extractMessage)
			.catch(this.handleError));
	}
}