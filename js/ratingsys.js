/*
Author: Addam M. Driver
Date: 10/31/2006
*/

var sMax = 5;	// Isthe maximum number of stars
var preSet; // Is the PreSet value onces a selection has been made
var rated = 0;

// Rollover for image Stars //
function rating(e){
	node = $(e.target);

	node.removeClass('icon-star-empty');
	node.addClass('icon-star');

	node.siblings('a').each(function(i, element) {
		element = $(element);
		if (element.data('rating') <= node.data('rating')) {
			element.removeClass('icon-star-empty');
			element.addClass('icon-star');
			node.siblings('.rateStatus').html(node.attr('title'));
		} else {
			element.removeClass('icon-star');
			element.addClass('icon-star-empty');
		}
	});
}

// For when you roll out of the the whole thing //
function off(e){
	if (rated === 0) {
		node = $(e.target);

		node.addClass('icon-star-empty');
		node.removeClass('icon-star');

		node.siblings('a').each(function(i, element) {
			element = $(element);
			element.removeClass('icon-star');
			element.addClass('icon-star-empty');
			node.siblings('.rateStatus').html('');
		});
	} else {
		if (node.data('rating') == rated) {
			rating({target: node});
		} else {
			node.siblings('a').each(function(i, element) {
			element = $(element);
			if (element.data('rating') == rated) {
				rating({target: element});
				return;
			}
		});
		}
	}
}

// When you actually rate something //
function rateIt(e){
	node = $(e.target);

	node.siblings('.rateStatus').html(node.attr('title'));
	sendRate(node);
	rating(e);
}

// Send the rating information somewhere using Ajax or something like that.
function sendRate(node){
	node.siblings('[name="rating"]').val(node.data('rating'));
	rated = node.data('rating');
}

function resetRate() {
	rated = 0;
	$('.rateMe a').removeClass('icon-star');
	$('.rateMe a').addClass('icon-star-empty');
	$('.rateMe .rateStatus').html('');
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
