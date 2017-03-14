<form>
	<div class="form-group">
		<label for="postImage" class="modal-labels">Upload an image</label>
		<input type="file" id="postImage" ng2FileSelect [uploader]="uploader" />
		<button type="button" (click)="uploader.uploadAll();">Submit</button>
	</div>
</form>