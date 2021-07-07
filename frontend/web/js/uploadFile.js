var csrfToken = yii.getCsrfToken();

var dropzone = new Dropzone("div.create__file", {
	url: "upload-file",
	paramName: "Attach",
	params: {'_csrf-frontend': csrfToken}
});
