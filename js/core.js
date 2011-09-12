$(document).ready(function() {
	// setup the page with current trends
	populateTrending();
	// animate the trends
	setupEvents();

});

// apparently need to call anytime I add content to the DOM
function setupEvents() {
	$('.tag').hover(
		function() {
			$(this).animate({
				left: '+=50'
			}, 10);
		},
		function() {
			$(this).animate({
				left: '-=50'
			}, 10);
		}
	);
	return true;
}

function populateTrending() {
	$.get(
		'/proxy.php?api=twitter&funct=/1/trends.json',
		function(data) {
			trends = data.trends;
			for (trend in trends) {
				tag = trends[trend]['name'];
				link = trends[trend]['url'];
				$('#tags').append("<div class=\"tag\">"+tag+"<a href=\""+link+"\">[.]</a></div>");
			}
			setupEvents();
		},
	    'json'
	);
	return true;
}