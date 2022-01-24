
const textFields = document.querySelectorAll('.mdc-text-field');

textFields.forEach(field => {
	mdc.textField.MDCTextField.attachTo(field);
});