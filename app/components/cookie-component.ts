import { Component } from '@angular/core';
import { Cookie } from 'ng2-cookies';

@Component({
	selector: 'app-root'
})
export class CookieComponent {
	cookies: Object;
	keys: Array<string>;
	cName: string;
	cValue: string;
	rName: string;
	checkName: string;

	constructor() {
		this.update();
		console.log(this.cookies);
	}
	update() {
		this.cookies = Cookie.getAll();
		this.keys = Object.keys(this.cookies);
	}
	addCookie(cName: string, cValue: string) {
		console.log('Adding: ', cName, cValue);
		Cookie.set(cName, cValue);
		this.update();
	}
	removeCookie(rName: string) {
		console.log('Removing: ', rName);
		Cookie.delete(rName);
		this.update();
	}
	removeAll() {
		console.log('Removing all cookies');
		Cookie.deleteAll();
		this.update();
	}
	checkCookie() {
		console.log('Checking: ', this.checkName);
		console.log(Cookie.check(this.checkName));
		window.alert('Check cookie ' + this.checkName + ' returned ' + Cookie.check(this.checkName));
	}
}