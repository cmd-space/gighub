import {Component, OnInit} from '@angular/core';
import {FileUploader} from 'ng2-file-upload';
import {Cookie} from "ng2-cookies";

const URL = './api/image/';

@Component({
	selector: 'file-upload',
	templateUrl: './template/file-upload.php'
})
export class FileUploadComponent implements OnInit {
	public uploader:FileUploader = new FileUploader({url: URL, headers: [{name: "X-XSRF-TOKEN", value: Cookie.get("XSRF-TOKEN")}]});
	public hasBaseDropZoneOver:boolean = false;
	public hasAnotherDropZoneOver:boolean = false;

	public fileOverBase(e:any):void {
		this.hasBaseDropZoneOver = e;
	}

	public fileOverAnother(e:any):void {
		this.hasAnotherDropZoneOver = e;
	}
	ngOnInit() : void {
		this.uploader.onSuccessItem = (item:any, response:string, status:number, headers:any)=>{
			console.log("re-Hi All!");
			console.log(response);
		};
	}
}