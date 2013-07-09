(function($){

	init();

	/* EVENTS */

	$(window).resize(function() {
		console.log('now');
	  	fitContainers();
	});

	/* FUNCTIONS */

	function init(){
		fitContainers();
	}

	function fitContainers(){
		var $wrapper = $('#wrapper'),
			$contentwrapper = $('#contentwrapper'),
			$aside = $('aside'),
			minHeight = $wrapper.height();

		$contentwrapper.css('min-height',minHeight);
		$aside.height(minHeight);
	}

})(jQuery);

