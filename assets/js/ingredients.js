$(document).ready(function() {

	// var addNew =
	$("#addNewBtn").click(insertEmptyIngredient);

});

function insertEmptyIngredient() {
	var newIngredient = $('#ingredientsList li:last-child').clone(true);
	// $('#ingredientsList > li').last().before(newIngredient);
	$('#ingredientsList').append(newIngredient);
	$('.d-none').first().removeClass('d-none');
}
