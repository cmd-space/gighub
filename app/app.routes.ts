import {RouterModule, Routes} from "@angular/router";
import {HomeComponent} from "./components/home-component";
import {MainNavComponent} from "./components/mainnav-component";
import {NotFoundComponent} from "./components/notfound-component";
import {AboutComponent} from "./components/about-component";

export const allAppComponents = [HomeComponent, MainNavComponent, AboutComponent, NotFoundComponent];

export const routes: Routes = [
	{path: "", component: HomeComponent},
	{path: "about", component: AboutComponent},
	{path: "**", component: NotFoundComponent}
];

export const appRoutingProviders: any[] = [];

export const routing = RouterModule.forRoot(routes);