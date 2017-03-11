import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base-service";
import {Image} from "../classes/image";
import {Status} from "../classes/status";

@Injectable()
export class ImageService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private imageUrl = "api/image/";

	postImage(image: Image) : Observable<Status> {
		return(this.http.post(this.imageUrl, image)
			.map(this.extractMessage)
			.catch(this.handleError));
	}
}