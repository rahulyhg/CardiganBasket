	<!-- Load JS -->
	<script type="text/javascript">
	
	jQuery(document).ready(function () {
	
		// prettyPhoto
    	jQuery("a[rel^='prettyPhoto']").prettyPhoto({
    		social_tools: false
    	});

    	// tooltip
    	jQuery('.tool-tip').tooltip();

		jQuery("#header-wrapper .nav-collapse.collapse .nav li.dropdown").hover(function() {
		    var navMenu = jQuery(this).find("#header-wrapper .nav-collapse.collapse");
		    navMenu.toggleClass("in");
		});


    	<?php if (get_option('mpt_enable_sticky_header') == 'true') { ?>

	    	//Waypoints
			jQuery.waypoints.settings.scrollThrottle = 30;
			jQuery('#body-wrapper').waypoint(function(event, direction) {
				offset: '-100%'
			}).find('#header-wrapper').waypoint(function(event, direction) {
				jQuery(this).toggleClass('navbar-fixed-top', direction === "down");
			});

		<?php } ?>

	});

	</script>