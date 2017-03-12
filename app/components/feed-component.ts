import {Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {Post} from "../classes/post";
import {PostService} from "../services/post-service";
import {Status} from "../classes/status";
import "rxjs/add/operator/switchMap";


@Component({
	templateUrl: "./templates/feed.php"
})

export class FeedComponent implements OnInit {
	post: Post = new Post(null, null, null, null, null, null, null, null);
	status: Status = null;
	post: Posts[] = [];


	constructor(
		private postService: PostService, private route: ActivatedRoute) {
	}

	ngOnInit(): void {
		this.getPostByPostId();
		this.getAllPosts();
	}

	getPostByPostId() : void {
		this.route.params
			.switchMap((params : Params) => this.postService.getPostByPostId(+params["postId"]))
			.subscribe(reply => this.post = reply);
	}

	//ngOnInit(): void {
	//	this.getAllPosts();
	//}

	getAllPosts() : void {
		this.postService.getAllPosts()
			.subscribe(posts => this.post = posts);
	}
}