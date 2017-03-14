import {RouterModule, Routes} from "@angular/router";
import {HomeComponent} from "./components/home-component";
import {MainNavComponent} from "./components/mainnav-component";
import {NotFoundComponent} from "./components/notfound-component";
import {AboutComponent} from "./components/about-component";
import {ContactComponent} from "./components/contact-component";
import {FacebookLoginComponent} from "./components/facebooklogin-component";
import {FeedComponent} from "./components/feed-component";
import {VenueComponent} from "./components/venue-component";
import {VenueDetailComponent} from "./components/venuedetail-component";
import {ProfileComponent} from "./components/profile-component";
import {ViewProfileComponent} from "./components/viewprofile-component";
import {FileUploadComponent} from "./components/fileupload-component";
import {FileSelectDirective} from 'ng2-file-upload';
import {PostComponent} from "./components/post-component";

export const allAppComponents = [HomeComponent, MainNavComponent, AboutComponent, ContactComponent, FeedComponent, FacebookLoginComponent, VenueComponent, VenueDetailComponent, ProfileComponent, ViewProfileComponent, NotFoundComponent, FileUploadComponent, FileSelectDirective, PostComponent];

export const routes: Routes = [
	{path: "feed", component: FeedComponent},
	{path: "venue", component: VenueComponent},
	{path: "venue/:venueId", component: VenueDetailComponent},
	{path: "about", component: AboutComponent},
	{path: "post/:postId", component: PostComponent},
	{path: "contact", component: ContactComponent},
	{path: "profile", component: ProfileComponent},
	{path: "profile/:profileId", component: ViewProfileComponent},
	{path: "file-upload", component: FileUploadComponent},
	{path: "", component: HomeComponent},
	{path: "**", component: NotFoundComponent}
];

export const appRoutingProviders: any[] = [];

export const routing = RouterModule.forRoot(routes);