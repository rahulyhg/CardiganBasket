/**** MP Checkout Recommendation JS *********/
jQuery(document).ready(function() {

	function mpcr_next_btn_listeners() {
		jQuery("button.mpcr-next-btn").click(function() {
			var input = jQuery(this);
			var container = jQuery(input).parents('div#mp-checkout-recommendation').find('.mpcr-row-container');
			var lastChild = container.find('.mpcr-row-fluid').last();
			var activated = container.find('.mpcr-row-fluid.activated');
			var next = activated.next('.mpcr-row-fluid');

			activated.removeClass('activated animated fadeInLeft fadeInRight').remove();
			lastChild.after(activated);
			next.addClass('activated animated fadeInRight');

		});
	}


	function mpcr_previous_btn_listeners() {
		jQuery("button.mpcr-previous-btn").click(function() {
			var input = jQuery(this);
			var container = jQuery(input).parents('div#mp-checkout-recommendation').find('.mpcr-row-container');
			var lastChild = container.find('.mpcr-row-fluid').last().remove();
			var activated = container.find('.mpcr-row-fluid.activated').before(lastChild);
			var previous = activated.prev('.mpcr-row-fluid');

			activated.removeClass('activated animated fadeInLeft fadeInRight');
			previous.addClass('activated animated fadeInLeft');

		});
	}

	mpcr_previous_btn_listeners();
	mpcr_next_btn_listeners();

});