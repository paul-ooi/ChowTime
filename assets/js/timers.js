"use strict";
$(document).ready(pageReady);
// window.addEventListener('load', pageReady, false);
var timersArray;//Create the Array to hold objects of timers present on the page


function pageReady() {
//Run script when window is loaded

	//Add listeners for Start, Stop, Remove buttons
	addListeners($('.start-time'), "click", startTimer);
	addListeners($('.stop-time'),"click", stopTimer);
	addListeners($('.del-time'),"click", removeTimer);

	//Toggle Saved Timer List
	$('#timers-tg').click(function(){
		$('#storedTimers').toggleClass('hidden');
	});

	//Setup Timer Objects
	setupTimerArray();
}

function addListeners(targets, action, callback) {
	for (let target of targets) {
		target.addEventListener(action, callback, false);
	}
}

function startTimer() {
	console.log("startTimer");
	let timerPosition = timers.index(this.parentElement.parentElement);
	if (!timersArray[timerPosition].active) {
		timersArray[timerPosition].active = true;
		timersArray[timerPosition].countdown();
	}
	$(this).toggleClass('hidden');
	$(this.nextElementSibling).toggleClass('hidden');
}//end of startTimer

function stopTimer() {
	console.log("stopTimer");
	let timerPosition = timers.index(this.parentElement.parentElement);
	timersArray[timerPosition].pause();

	$(this).toggleClass('hidden');
	$(this.previousElementSibling).toggleClass('hidden');

}//end of stopTimer

function removeTimer() {
	console.log("removeTimer");
	// Must remove from DB as well
	// INSERT CODE FOR DB REMOVAL OF TIMER


	//clear the Interval before removing the Timer.
	let timerPosition = timers.index(this.parentElement.parentElement);
	timersArray[timerPosition].pause();

	// Remove the list item belonging to this timer
	this.parentElement.parentElement.remove(); //currently only removes from the DOM

}//end of removeTimer

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

function setTimerValue(hh, mm, ss) {
	// Get individual values from form
	// calculate total seconds value
	let hours = parseInt(hh, 10) * 60 * 60;
	let minutes = parseInt(mm, 10) * 60;
	let seconds = parseInt(ss, 10);

	let totalTime = hours + minutes + seconds;

	return totalTime;
}//end of setTimerValue



function Timer (originalTime, timerName = "untitled timer", position) {
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

			//end at zero
			if (_timer.remainingTime == 0) {
				_timer.active = false;
				clearInterval(interval);
			}
			displayTimer(_timer.remainingTime, _timer.position);
		}, 1000);
	};
	this.pause = function() {
		_timer.active = false;
		clearInterval(interval);
	};
}

var timers;
var timersArrayJSON;
function setupTimerArray() {

	// var xmlhttp = new XMLHttpRequest();
	// xmlhttp.onreadystatechange = function() {
	// 	if (this.readyState == 4 && this.status == 200) {
	// 		console.log("success");
	// 		timersArrayJSON = JSON.parse(this.responseText);
	// 		console.log(timersArray);
	// 		console.log(timersArrayJSON);
	// 	}
	// };
	// xmlhttp.open("GET", "../controllers/timers/timer_file.php?action=getTimers", true);
	// xmlhttp.send();

	// $.ajax( "../controllers/timers/timer_file.php", {
	// 	converters: {"array json": jQuery.parseJSON},
	// 	data:{'action': 'getTimers'},
	//  	datatype:"json",
	// 	success: function (response) {
	// 		timersArrayJSON = response;
	// 		console.log(timersArrayJSON);
	// 	}
	// });



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
		timersArray.push(new Timer (setTimerValue(hours, minutes, seconds), name, position));
		position++;
	};
	//console.log(timersArray);
}

// var a = new Timer(5, "my A Timer");
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
		// let timerO = displayTimer(timerObject.remainingTime);
		// console.log(timerO);
		console.log(timerObject.remainingTime);
	}, 1000);
}
