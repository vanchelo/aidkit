(function ($) {
	init();

	var BASE_URL = $('base').attr('href'),
		TEMPLATE_URL = BASE_URL + '/js/';

	var HTMLcover = $('<div>', {class: 'js-cover'}),
		HTMLalert = $('<div>', {class: 'js-alert'});

	/* EVENTS */

	$(window).resize(function () {
		console.log('now');
		fitContainers();
	});

	$('body').delegate('a.js-remove', 'click', function (evt) {
		evt.preventDefault();
		evt.stopPropagation();

		$('body').append(HTMLcover);
		$('#wrapper').addClass('blur');

		includeHTMLcontent('delete');

	});

	$('body').delegate('.js-cover', 'click', function (evt) {
		$('.js-cover, .js-alert').remove();
		$('#wrapper').removeClass('blur');
	});

	/* FUNCTIONS */

	function init() {
		fitContainers();
	}

	function fitContainers() {
		var $wrapper = $('#wrapper'),
			$contentwrapper = $('#contentwrapper'),
			$aside = $('aside'),
			minHeight = $wrapper.height();

		$contentwrapper.css('min-height', minHeight);
		$aside.height(minHeight);
	}

	function includeHTMLcontent(name) {
		$.get(TEMPLATE_URL + name, function (data) {
			$('body').append(HTMLalert);
			$('.js-alert').html(data);
		});
	}

})(jQuery);

