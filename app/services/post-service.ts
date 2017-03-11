import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base-service";
// import {Profile} from "../classes/profile";
// import {Venue} from "../classes/venue";
import {Post} from "../classes/post";
import {Status} from "../classes/status";

@Injectable()
export class PostService extends BaseService {
	constructor(protected http: Http){
		super(http);
	}

	private postUrl = "api/post/";

	getAllPosts() : Observable<Post[]> {
		return(this.http.get(this.postUrl)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getPostByPostId(postId: number) : Observable<Post> {
		return(this.http.get(this.postUrl + postId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getPostByPostProfileId(postProfileId: number) : Observable<Post[]> {
		return(this.http.get(this.postUrl + postProfileId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getPostByPostContent(postContent: string) : Observable<Post[]> {
		return(this.http.get(this.postUrl + postContent)
			.map(this.extractData)
			.catch(this.handleError));
	}

	postPost(post: Post) : Observable<Status> {
		return(this.http.post(this.postUrl, post)
			.map(this.extractMessage)
			.catch(this.handleError));
	}
	putPost(post: Post) : Observable<Post>{
		return(this.http.put(this.postUrl + post.postId, post)
			.map(this.extractMessage)
			.catch(this.handleError));
	}
	deletePost(post: Post) : Observable<Post>{
		return(this.http.delete(this.postUrl + post.postId)
			.map(this.extractMessage)
			.catch(this.handleError));
	}
}