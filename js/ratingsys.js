/*
Author: Addam M. Driver
Date: 10/31/2006
*/

var sMax;	// Isthe maximum number of stars
var preSet; // Is the PreSet value onces a selection has been made
var rated;

// Rollover for image Stars //
function rating(num){
	num = $(this)[0];

	sMax = 5;	// Isthe maximum number of stars

	s = num.id.replace("_", ''); // Get the selected star
	for(i=1; i<=sMax; i++){
		if(i<=s){
			document.getElementById("_"+i).className = "icon-star";
			document.getElementById("rateStatus").innerHTML = num.title;
		}else{
			document.getElementById("_"+i).className = "icon-star-empty";
		}
	}
}

// For when you roll out of the the whole thing //
function off(me){
	me = $(this)[0];

	if(!preSet){
		for(i=1; i<=sMax; i++){
			document.getElementById("_"+i).className = "icon-star-empty";
			document.getElementById("rateStatus").innerHTML = me.parentNode.title;
		}
	}else{
		rating(preSet);
		document.getElementById("rateStatus").innerHTML = document.getElementById("ratingSaved").innerHTML;
	}
}

// When you actually rate something //
function rateIt(me){
	me = $(this)[0];

	document.getElementById("rateStatus").innerHTML = me.title;
	preSet = me;
	rated=1;
	sendRate(me);
	rating(me);
}

// Send the rating information somewhere using Ajax or something like that.
function sendRate(sel){
	var number = sel.id.replace('_', '');
	$('#rating').val(number);
	rated = number;
}

function resetRate() {
	rated=0;
	$('#rateMe a').removeClass('icon-star');
	$('#rateMe a').addClass('icon-star-empty');
	$('#rateMe #rateStatus').html('');
}

function setRate(number) {
	for(i=1; i<=sMax; i++){
		if(i <= number){
			document.getElementById("_"+i).className = "icon-star";
		} else {
			document.getElementById("_"+i).className = "icon-star-empty";
		}
	}
}
