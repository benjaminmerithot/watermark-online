(function ($) {
	$(function () {
		// Add SVG to body
		$.ajax({
			url: "/wp-content/themes/watermark-theme/assets/images/svg-symbols.svg",
			context: document.body
		}).done(function (data) {
			$('svg', data).attr('class', 'visually-hidden').prependTo('body');
		});

		// Menu Toggle
		$('[data-menu-toggle]').click(function() {
			$(this).toggleClass('active').focus();
			$('[data-mobile-menu]').toggleClass('is-active');
			$('body').toggleClass('mobile-menu-active');
		});

		// Mobile Menu Dropdowns
		$('.menu--mobile .menu-item-has-children > a').click(function(e) {
			e.preventDefault();
			$(this).parent().toggleClass('is-active');
		});

		// Carousel
		$('[data-carousel]').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			fade: true,
			autoplay: true,
			autoplaySpeed: 8000,
			prevArrow: '<button type="button" class="slick-prev"><svg class="icon arrow-left"><use xlink:href="#arrow-left-long"></use></svg></button>',
			nextArrow: '<button type="button" class="slick-next"><svg class="icon arrow-right"><use xlink:href="#arrow-right-long"></use></svg></button>',
		});

		$('[data-carousel-nav]').slick({
			slidesToShow: 4,
			slidesToScroll: 1,
			asNavFor: '[data-carousel]',
			focusOnSelect: true,
			arrows: false,
			responsive: [
				{
					breakpoint: 768,
					settings: 'unslick',
				}
			]
		});

		$('[data-search-toggle]').click(function() {
			$(this).toggleClass('active').focus();
			$('[data-search-form], .navbar__search').toggleClass('is-active');
			$('[data-header-nav]').toggleClass('is-hidden');
		});

		// TODO: add category carousel that doesn't have nav

	});
})(jQuery);
