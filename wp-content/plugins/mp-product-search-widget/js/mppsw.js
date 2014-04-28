/**** MP Product Search Widget Ajax JS *********/
jQuery(document).ready(function() {

	// Search query listener
	function mppsw_search_query_listeners() {
		jQuery("button.mppsw-search-submit-button").click(function() {
			var input = jQuery(this);
			var formElm = jQuery(input).parents('form.mppsw-product-search-form');
			var rsmodal = jQuery('div.mppsw-product-search-results-modal');
			var tempHtml = formElm.html();
			var serializedForm = formElm.serialize();
			formElm.html('<img src="'+MPPSW_Ajax.imgUrl+'" alt="'+MPPSW_Ajax.loadingList+'" /> <span>'+MPPSW_Ajax.loadingList+'</span>');
			jQuery.post(MPPSW_Ajax.ajaxUrl, serializedForm, function(data) {
				var result = data.split('||', 3);
				if (result[0] == 'error') {
					formElm.html(result[1]);
					mppsw_search_reset();
				} else {
					formElm.fadeOut(1000, function(){
						formElm.html(result[1]).fadeIn('fast');
						rsmodal.html(result[2]);
						mppsw_search_results_updater();
						mppsw_search_query_listeners();
						mppsw_search_reset();
					});
				}
			});
			return false;
		});
	}

	// Filter By Listener
	function mppsw_filter_by_listeners() {
		jQuery("select.mppsw-filterbyselect").change(function() {
			var input = jQuery(this);
			var val = input.find("option:selected").val();
			var filterCat = jQuery("div.filter-by-category-select");
			var filterTag = jQuery("div.filter-by-tag-select");
			if (val == 'filterbycategory' ){
				filterTag.hide();
				filterCat.show('1000');
			} else if (val == 'filterbytag' ){
				filterCat.hide();
				filterTag.show('1000');
			} else {
				filterCat.hide();
				filterTag.hide();
			}
			mppsw_filter_by_listeners();
		});
	}

	// Search Reset
	function mppsw_search_reset() {
		jQuery("button.mppsw-reset-search-link").click(function() {
			var input = jQuery(this);
			var formElm = jQuery(input).parents('form.mppsw-product-search-form');
			var rsmodal = jQuery('div.mppsw-product-search-results-modal');
			var tempHtml = formElm.html();
			var serializedForm = formElm.serialize();
			formElm.html('<img src="'+MPPSW_Ajax.imgUrl+'" alt="'+MPPSW_Ajax.loadingList+'" /> <span>'+MPPSW_Ajax.loadingList+'</span>');
			jQuery.post(MPPSW_Ajax.ajaxUrl, serializedForm, function(data) {
				var result = data.split('||', 2);
				formElm.fadeOut(1000, function(){
					formElm.html(result[1]).fadeIn('fast');
					rsmodal.html('');
					mppsw_search_query_listeners();
					mppsw_filter_by_listeners();
				});
				
			});
			return false;
		});
	}

	// Search Results Update
	function mppsw_search_results_updater() {
		jQuery("button.mppsw-search-results-update-btn").click(function() {
			var input = jQuery(this);
			var formElm = jQuery(input).parents('form.mppsw-search-results-listing-form');
			var tempHtml = formElm.html();
			var serializedForm = formElm.serialize();
			formElm.html('<img src="'+MPPSW_Ajax.imgUrl+'" alt="'+MPPSW_Ajax.loadingList+'" /> <span>'+MPPSW_Ajax.loadingList+'</span>');
			jQuery.post(MPPSW_Ajax.ajaxUrl, serializedForm, function(data) {
				var result = data.split('||', 2);
				if (result[0] == 'error') {
					formElm.html(tempHtml);
					formElm.find('tbody.mppsw-table-search-results-body').html(result[1]);
					mppsw_search_query_listeners();
					mppsw_search_results_updater();
					mppsw_search_reset();
				} else {
					formElm.html(result[1]);
					mppsw_search_query_listeners();
					mppsw_search_results_updater();
					mppsw_search_reset();
				}				
			});
			return false;
		});
	}

	mppsw_search_query_listeners();
	mppsw_filter_by_listeners();
});