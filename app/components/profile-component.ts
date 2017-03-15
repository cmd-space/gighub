import {Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {Profile} from "../classes/profile";
import {ProfileService} from "../services/profile-service";
import {LogoutService} from "../services/logout-service";
import {Router} from "@angular/router";
import {Status} from "../classes/status";
import "rxjs/add/operator/switchMap";


@Component({
	templateUrl: "./templates/profile.php"
})

export class ProfileComponent implements OnInit {
	profile: Profile = new Profile(null, null, null, null, null, null, null, null, null);
	status: Status = null;

	constructor(private profileService: ProfileService, private route: ActivatedRoute, private logoutService: LogoutService, private router: Router) {
	}

	ngOnInit(): void {
		this.getProfileByProfileId();
		this.get();
	}

	getProfileByProfileId() : void {
		this.route.params
			.switchMap((params : Params) => this.profileService.getProfileByProfileId(+params["profileId"]))
			.subscribe(reply => this.profile = reply);
	}

	get(): void {
		this.logoutService.get()
			.subscribe(status => this.status = status);
					this.router.navigate(['']);
	}
}