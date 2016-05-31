jQuery(document).ready(function($) {
	var nav = $('#post-nav span'),
	W = $(window),
	P = $('#post-nav'),
	C = $('#comments'),
	pH = P.position().top;
	nav.click(function() {
		if ($(this).hasClass('current')) return false;
		nav.removeClass('current');
		$(this).addClass('current');
		var x = $(this).text(),
		y = $('#post-img img').eq(x - 1).attr('data-real'),
		img_current = $('#post-img img.current');
		img_current.removeClass('current');
		$('#post-img img').eq(x - 1).addClass('current');
		$('#post-real').attr('href', y);
	});
	W.scroll(function() {
		var T = pH + W.scrollTop(),
		y = $('#post-img').height() - 27;
		if (T > y) {} else {
			P.animate({
				top: T
			},
			{
				queue: false,
				duration: 500
			});
		}
	});
});