window.addEventListener('load', pageReady, false);
function pageReady() {

	$('#searchRecipesBtn').click(searchAll);
	$('#searchAll').submit(searchAll);
	$('#form_search').keyup(searchAll);

	//Click to reveal more options for search bar
	$('#searchOptions').click(function(){
		$('#moreOptions').toggleClass('hidden');
	});
}

function searchAll() {
	//IF THE SEARCH BAR IS EMPTY, DO NOT CALL DB & CLEAR RESULTS
	if (this.value == undefined || this.value == "") {
		$('#searchResults').html("");
		return false;
	}

	$.ajax('controllers/search/index.php',
	{
		data: {'action' : 'searchKey',
				'phrase': this.value //encodeURIComponent(uri)
		},
		method: "GET",
		success: function(response) {
			//target the Results div and show Results
			$('#searchResults').html(response);
			// console.log(response);
		}
	});
	return false;
}
