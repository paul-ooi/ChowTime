$(document).ready(pageReady);
var timersArray;//Create the Array to hold objects of timers present on the DOM


function pageReady() {
//Run script when window is loaded

	//Add listeners for Start, Stop, Remove buttons
	addListeners($('.start-time'), "click", startTimer);
	addListeners($('.stop-time'),"click", stopTimer);
	addListeners($('.del-time'),"click", removeTimer);

	//Hide Stop buttons on load
	$('.stop-time').hide();

	//Toggle Saved Timer List
	$('#timers-tg').click(function(){
		$('#storedTimers').toggleClass('hidden');
	});

	//Setup Timer Objects
	setupTimerArray();

	// //Start Timer Button from New Timer - WIP
	// $("#startTimerBtn").on("click", function(event){
	// 	var button = this;
	// 	var form = $($(this).parent()).parent();
	// 	ajaxSendForm(form, button);
	// });
}

// HELPER FUNCTION TO ADD LISTENERS
function addListeners(targets, action, callback) {
	for (let target of targets) {
		target.addEventListener(action, callback, false);
	}
}

// START THE TIMER BUTTON PROCEDURE
function startTimer() {
	console.log("startTimer");
	let timerPosition = timers.index(this.parentElement.parentElement);
	console.log(timersArray[timerPosition]);
	
	if (!timersArray[timerPosition].active) {
		timersArray[timerPosition].active = true;
		//Check that there's still time left before starting the countdown
		if (timersArray[timerPosition].remainingTime != 0){ 
			timersArray[timerPosition].countdown();
		} else {
			timersArray[timerPosition].remainingTime = timersArray[timerPosition].setTime
			timersArray[timerPosition].countdown();
		}
	}
	
	//HIde the start button upon start
	$(this).hide();
	$(this.nextElementSibling).show();
}//end of startTimer


// STOP/PAUSE THE TIMER BUTTON PROCEDURE
function stopTimer() {
	console.log("stopTimer");
	let timerPosition = timers.index(this.parentElement.parentElement);
	timersArray[timerPosition].pause();

	if (timersArray[timerPosition].remainingTime == 0) {
		$(this.previousElementSibling).html("Restart");
		$(this.previousElementSibling).show();
		$(this).hide();
	} else {
		$(this).hide();
		$(this.previousElementSibling).html("Start");
		$(this.previousElementSibling).show();
	}

}//end of stopTimer


//CALL FUNCTION VIA AJAX TO REMOVE TIMER FOR THE DATABASE
function removeTimer() {
	console.log("removeTimer");
	var _button = this;
	let timerPosition = timers.index(_button.parentElement.parentElement);

	$.ajax("../controllers/timers/timer_file.php", {
		data: {'action' : 'delTimer',
		 		'timerName' : timersArray[timerPosition].name,
				'origTime' :  timersArray[timerPosition].setTime
		},
		method: "GET",
		success: function(response) {
			//clear the Interval before removing the Timer.
			timersArray[timerPosition].pause();
			// Remove the list item belonging to this timer
			_button.parentElement.parentElement.remove(); //removes from the DOM
			$("#storedTimerFeedback").html(response);
		}
	});
}//end of removeTimer

//UPDATE THE TIMER DISPLAYED ON THE DOM 
function displayTimer(remainingTime, position) {
	//get remaining time in seconds
	let hours = Math.floor(remainingTime / 3600);
	let minutes = Math.floor((remainingTime % 3600) / 60);
	let seconds = Math.floor(remainingTime % 60);

	//Make single digit values still display as pre-pended by
	(hours < 10) ? hours = "0"+ hours.toString() : hours = hours.toString();
	(minutes < 10) ? minutes = "0"+ minutes.toString() : minutes = minutes.toString();
	(seconds < 10) ? seconds = "0"+ seconds.toString() : seconds = seconds.toString();

	//Change the HTML shown on the page
	timers[position].querySelector(".hours").textContent = hours;
	timers[position].querySelector(".minutes").textContent = minutes;
	timers[position].querySelector(".seconds").textContent = seconds;

}//end of displayTimer

//HELPER FUNCTION CREATE TIMER OBJECTS FOR THE DOM
function setTimerValue(hh, mm, ss) {
	// Get individual values from form
	// calculate total seconds value
	let hours = parseInt(hh, 10) * 60 * 60;
	let minutes = parseInt(mm, 10) * 60;
	let seconds = parseInt(ss, 10);

	let totalTime = hours + minutes + seconds;

	return totalTime;
}//end of setTimerValue


//Timer Constructor
function Timer (originalTime, position, timerName = "untitled timer") {
	var _timer = this;
	var interval;
	this.name = timerName;
	this.setTime = originalTime;
	this.active = false; //Active == true or Stopped == false
	this.remainingTime = null;
	this.position = position;
	this.countdown = function () {
		interval = setInterval(function () {
			if (_timer.remainingTime == null) {
				_timer.remainingTime = _timer.setTime;
			}
			_timer.remainingTime-= 1;//subtract from total

			displayTimer(_timer.remainingTime, _timer.position);
			//end at zero
			if (_timer.remainingTime == 0) {
				_timer.active = false;
				clearInterval(interval);
				//find a way to alert the user without interupting the other timers	
				//alert(timerName.toUpperCase() + " Timer finished");		
			}
		}, 1000);
	};
	this.pause = function() {
		_timer.active = false;
		clearInterval(interval);
	};
}

var timers;
var timersArrayJSON;
//USE TIMERARRAY TO TRACK TIMERS ON THE DOM
function setupTimerArray() {

	//Get Timers
	timers = $('.timer');
	timersArray = [];
	var position = 0;
	for (let timer of timers) {
		let name = timer.querySelector('.timer-name').textContent;
		let hours = timer.querySelector('.hours').textContent;
		let minutes = timer.querySelector('.minutes').textContent;
		let seconds = timer.querySelector('.seconds').textContent;
		//Store timers in Array - maybe send this to DB
		timersArray.push(new Timer (setTimerValue(hours, minutes, seconds), position, name));
		position++;
	};
	//console.log(timersArray);
}

// FUNCTION TO COUNDOWN THE TIMER
function countdown(timerObject) {
	let interval = setInterval(function () {
		if (timerObject.remainingTime == null) {
			timerObject.remainingTime = timerObject.setTime;
		}
		timerObject.remainingTime-= 1;

		//end at zero
		if (timerObject.remainingTime == 0) {
			clearInterval(interval);
		}

	}, 1000);
}//End of Countdown


//SAVE AND THEN START TIMER FROM FORM -- WIP
function ajaxSendForm(form, button) {
	//save timer then start it
	var hours = form[0][0].value;
	var minutes = form[1][0].value;
	var seconds = form[2][0].value;
	var name = form[3][0].value;

	$.ajax( "../controllers/timers/timer_file.php", {
		converters: {"array json": jQuery.parseJSON},
		data: {'action': button.name,
				'hours': hours,
				'minutes': minutes,
				'seconds': seconds,
				'name': name,
		},
	 	datatype:"json",
		success: function (response) {
			timersArrayJSON = response;
			console.log(timersArrayJSON);
		}
	});
	// $(form).submit();
}
