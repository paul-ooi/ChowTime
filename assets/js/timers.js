// $(window).onload(pageReady);
window.addEventListener('load', pageReady, false);
function pageReady() {
//Run script when window is loaded

	//get link that toggles list of saved TIMERS
	//add listeners for buttons
	addListeners($('.start-time'), "click", startTimer);
	addListeners($('.stop-time'),"click", stopTimer);
	addListeners($('.del-time'),"click", removeTimer);

	$('#timers-tg').click(function(){
		$('#storedTimers').toggleClass('hidden');	
	});
}

function addListeners(targets, action, callback) {
	for (let target of targets) {
		this.addEventListener(action, callback, false);
	}
}

function startTimer() {

}

function stopTimer() {

}

function removeTimer() {

}
