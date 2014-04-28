// Filterable jQuery

function scaleDown() {

	jQuery('#mpt-product-grid .span6.well.well-small').removeClass('current').addClass('not-current');
	jQuery('#mpt-product-grid .span4.well.well-small').removeClass('current').addClass('not-current');
	jQuery('#mpt-product-grid .span3.well.well-small').removeClass('current').addClass('not-current');
	jQuery('ul.mpt-product-categories > li').removeClass('current-li');

}

function show(category) {

	scaleDown();

	jQuery('#' + category).addClass('current-li');
	jQuery('.' + category).removeClass('not-current');
	jQuery('.' + category).addClass('current');

	if (category == "all") {
		jQuery('ul.mpt-product-categories > li').removeClass('current-li');
		jQuery('#all').addClass('current-li');
		jQuery('#mpt-product-grid .span6.well.well-small').removeClass('current, not-current').addClass('all');
		jQuery('#mpt-product-grid .span4.well.well-small').removeClass('current, not-current').addClass('all');
		jQuery('#mpt-product-grid .span3.well.well-small').removeClass('current, not-current').addClass('all');
	}

}

jQuery(document).ready(function(){

	jQuery('#all').addClass('current-li');

	jQuery("ul.mpt-product-categories > li").click(function(){
		show(this.id);
	});

});