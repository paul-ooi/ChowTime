$(document).ready(function() {

	// var addNew =
	$("#addNewBtn").click(insertEmptyIngredient);

});

function insertEmptyIngredient() {
	var newIngredient = $('li.d-none').clone();
	// $('#ingredientsList > li').last().before(newIngredient);
	$('#ingredientsList').append(newIngredient);
	$('.d-none').first().removeClass('d-none');
}
