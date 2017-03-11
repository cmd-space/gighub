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

export const allAppComponents = [HomeComponent, MainNavComponent, AboutComponent, ContactComponent, FeedComponent, FacebookLoginComponent, VenueComponent, VenueDetailComponent, ProfileComponent, NotFoundComponent];

export const routes: Routes = [
	{path: "feed", component: FeedComponent},
	{path: "venue", component: VenueComponent},
	{path: "venue/:venueId", component: VenueDetailComponent},
	{path: "about", component: AboutComponent},
	{path: "contact", component: ContactComponent},
	{path: "profile", component: ProfileComponent},
	{path: "", component: HomeComponent},
	{path: "**", component: NotFoundComponent}
];

export const appRoutingProviders: any[] = [];

export const routing = RouterModule.forRoot(routes);