jQuery.extend(jQuery.easing, {
	easeInOutBack: function(e, f, a, i, h, g) {
		if (g == undefined) {
			g = 1.70158
		}
		if ((f /= h / 2) < 1) {
			return i / 2 * (f * f * (((g *= (1.525)) + 1) * f - g)) + a
		}
		return i / 2 * ((f -= 2) * f * (((g *= (1.525)) + 1) * f + g) + 2) + a
	}
});
jQuery(document).ready(function(u) {
	u("#container").waterfall({
		isResizable: true,
		isAnimated: true,
		Duration: 500,
		Easing: 'easeInOutBack'
	});
	u(".post-thumbnail a").colorTip({});
});