$(document).ready(function() {
	$('form').on('submit',removeCheckbox);

	$("#addNewBtn").click(insertEmptyIngredient);
});

function insertEmptyIngredient() {
	var newIngredient = $('#ingredientsList li:last-child').clone(true);
	// $('#ingredientsList > li').last().before(newIngredient);
	$('#ingredientsList').append(newIngredient);
	$('.d-none').first().removeClass('d-none');
}

function removeCheckbox() {
	console.log("fire");
	var checkboxes = $(".form-check-input:checked");
	console.log(checkboxes);
	for (var i = 0; i < checkboxes.length; i++) {
		console.log(checkboxes[i].nextElementSibling);
		checkboxes[i].nextElementSibling.disabled = true;
	}
}
