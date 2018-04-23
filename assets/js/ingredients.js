var closeButtons;
$(document).ready(function() {
	$('form').on('submit',removeCheckbox);
	$("#addNewBtn").click(insertEmptyIngredient);
	closeButtons = $(".close");
	if (closeButtons.length > 1) {
		$(".close").show();
		
		for (var closeBtn of closeButtons) {
			$(closeBtn).on("click", function (e) {
				e.stopPropagation();
				removeIngredient(e);
			})
		}
	} else {
		$(".close").hide();
	} 


});


//ADD NEW INGREDIENT ITEM
function insertEmptyIngredient() {
	var newIngredient = $('#ingredientsList li:last-child').clone(false);
	$('#ingredientsList').append(newIngredient);
	//ADD LISTENER TO EACH INGREDIENT ROW
	closeButtons = document.querySelectorAll(".close");
		for (var closeBtn of closeButtons) {
			$(closeBtn).on("click", function (e) {
				e.stopPropagation();
				removeIngredient(e);
			})
		}

	if (closeButtons.length >1) {
		$(".close").show();
	}

}

//FIX WHICH CHECKBOX IS SUBMITTED ON SUBMIT OF INGREDIENTS
function removeCheckbox() {
	var checkboxes = $(".form-check-input:checked");
	for (var i = 0; i < checkboxes.length; i++) {
		checkboxes[i].nextElementSibling.disabled = true;
	}
}

//WHEN INGREDIENT IS ADDED ON THE LIST, USE THE X TO DELETE AN INGREDIENT FROM THE RECIPE
function removeIngredient(event) {
	var targetListItem = event.target.parentElement.parentElement;
	
	if (closeButtons.length > 1) {
		$(targetListItem).remove();
	}
	closeButtons = document.querySelectorAll(".close");
	
	if (closeButtons.length <= 1) {
		//CHECK TOTAL OF INGREDIENT ROWS, REMOVE THE DELETE BUTTON
		$(".close").hide();
	} 
}

