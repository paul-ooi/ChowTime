window.addEventListener('load', pageReady, false);
function pageReady() {

	//Click to reveal more options for search bar
	$('#searchOptions').click(function(){
		$('#moreOptions').toggleClass('hidden');
	});
}
