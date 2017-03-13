import {Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {Profile} from "../classes/profile";
import {ProfileService} from "../services/profile-service";
import {Status} from "../classes/status";
import "rxjs/add/operator/switchMap";


@Component({
	templateUrl: "./templates/viewprofile.php"
})

	export class ViewProfileComponent implements OnInit {
	profile: Profile = new Profile(null, null, null, null, null, null, null, null, null);
	status: Status = null;

	constructor(private profileService: ProfileService, private route: ActivatedRoute) {
	}

	ngOnInit(): void {
		this.getProfileByProfileId();
	}
	getProfileByProfileId() : void {
		this.route.params
			.switchMap((params : Params) => this.profileService.getProfileByProfileId(+params["profileId"]))
			.subscribe(profile => this.profile = profile);
	}

	putProfile() : void {
		this.profileService.putProfile(this.profile).subscribe(status => this.status = status);
	}
}