import { createHooks } from "@wordpress/hooks";

window.isEditMode = false;
window.ts = {
	hooks: createHooks(),
	isEditMode: false,
};

ts.hooks.addAction("widgets.reinit", "ts", ($content) => {
	
});

jQuery(window).on("elementor/frontend/init", function () {
	window.isEditMode = elementorFrontend.isEditMode();
	window.ts.isEditMode = elementorFrontend.isEditMode();

	// hooks
	ts.hooks.doAction("init");

	// init edit mode hook
	if (ts.isEditMode) {
		ts.hooks.doAction("editMode.init");
	}
});

(function ($) {
	$('a').on('click', function (e) {
		var hashURL = $(this).attr('href'),
			isStartWithHash;

		hashURL = hashURL === undefined ? '' : hashURL;
		isStartWithHash = hashURL.startsWith('#');

		if (!isStartWithHash) {
			hashURL = hashURL.replace(localize.page_permalink, '');
			isStartWithHash = hashURL.startsWith('#');
		}

		// we will try and catch the error but not show anything just do it if possible
		try {
			if (isStartWithHash && ($(hashURL).hasClass('ts-tab-item-trigger') || $(hashURL).hasClass('ts-accordion-header'))) {
				$(hashURL).trigger('click');
			}
		} catch (err) {
			// nothing to do
		}
	});
})(jQuery);