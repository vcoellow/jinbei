$(function() {
	$('.fullwidth').utilCarousel({
		breakPoints: [[600, 1], [900, 2], [1200, 3], [1500, 4], [1800, 5]],
		mouseWheel: false,
		rewind: true,
		autoPlay: true
	});

	$('#modelos').on('mouseenter', function(){
		$('.subnav').fadeIn(450);
	});
					
	$('#menu').children().each(function(i, v){
		if(v.id !== 'modelos'){
			$(v).on('mouseenter', function(){
				$('.subnav').fadeOut(450);
			});
		}
	});
	
	$('.alternado', '.swiper-container').mouseenter(function(e){
		e.stopImmediatePropagation();
		$('.subnav').fadeOut(450);
	});
					
	$('section').mouseenter(function(e){
		e.stopImmediatePropagation();
		$('.subnav').fadeOut(450);
	});
					
	$('iframe').mouseenter(function(e){
		e.stopImmediatePropagation();
		$('.subnav').fadeOut(450);
	});

	$('.cajas-home').hover(function(){
		// $(this) -> elemento específico
		// $(this).children() -> muestra todos los hijos en un array [0,1,2,3] = ['<i>', '<h2', '<p>']
		$($(this).children()[0]).css({
				'color' : '#333',
				'background' : '#FFF'
		});
	},function(){
		$($(this).children()[0]).css({
				'color' : '#333',
				'background' : '#CCC'
		});
	});

	$('.Collage').magnificPopup({
		delegate: 'a', // child items selector, by clicking on it popup will open
		type: 'image'
	});

	var swiper = new Swiper('.swiper-container', {
		autoplay: 5000,
		autoplayDisableOnInteraction: false,
		pagination: '.swiper-pagination',
		paginationClickable: true,
		nextButton: '.swiper-button-next',
		prevButton: '.swiper-button-prev',
	});

});