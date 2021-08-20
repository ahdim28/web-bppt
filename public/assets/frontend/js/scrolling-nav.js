var offset = 80;
var offsetChange = 98;

$(function() {
    $('a.page-scroll').bind('click', function(event) {
        var $anchor = $(this);
		if ($(window).width() > 992) {
			$('html, body').stop().animate({
				scrollTop: $($anchor.attr('href')).offset().top - offsetChange
			}, 1000, 'easeInOutExpo');
		} else {
			$('html, body').stop().animate({
				scrollTop: $($anchor.attr('href')).offset().top - offset
			}, 1000, 'easeInOutExpo');	
		}
        event.preventDefault();
    });
});

