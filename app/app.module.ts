import {NgModule} from "@angular/core";
import {BrowserModule} from "@angular/platform-browser";
import {FormsModule} from "@angular/forms";
import {HttpModule} from "@angular/http";
import {AppComponent} from "./app.component";
import {allAppComponents, appRoutingProviders, routing} from "./app.routes";
import {VenueService} from "./services/venue-service";
import {baseService} from "./services/base-service";
import {imageService} from "./services/image-service";
import {oAuthService} from "./services/oAuth-service";
import {postService} from "./services/post-service";
import {profileServie} from "./services/profile-service";
import {profileTypeService} from "./services/profileType-service";
import {tagService} from "./services/tag-service";
import {venueService} from "./services/venue-service";

const moduleDeclarations = [AppComponent];

@NgModule({
	imports:      [BrowserModule, FormsModule, HttpModule, routing],
	declarations: [...moduleDeclarations, ...allAppComponents],
	bootstrap:    [AppComponent],
	providers:    [appRoutingProviders, VenueService, baseService, imageService, oAuthService, postService, profileService, profileType, tagService, venueService]
})
export class AppModule {}


// just incase i screwed up here's a copy of the original below
// this on top may not be correct
// do not crucify me
// do not harsh my mellow
// let's talk about this
// no wait plz
// don't do that


import {NgModule} from "@angular/core";
import {BrowserModule} from "@angular/platform-browser";
import {FormsModule} from "@angular/forms";
import {HttpModule} from "@angular/http";
import {AppComponent} from "./app.component";
import {allAppComponents, appRoutingProviders, routing} from "./app.routes";
import {VenueService} from "./services/venue-service";

const moduleDeclarations = [AppComponent];

@NgModule({
	imports:      [BrowserModule, FormsModule, HttpModule, routing],
	declarations: [...moduleDeclarations, ...allAppComponents],
	bootstrap:    [AppComponent],
	providers:    [appRoutingProviders, VenueService]
})
export class AppModule {}