/**** CSS Animated General JS *********/
jQuery(document).ready(function() {

	/******************* Attention seekers *****************************************/

	//add flash effect
	function cssanimated_add_flash_effects() {
		jQuery(".add-flash-effects-parent").hover(function() {
			var child = jQuery(this).find(".add-flash-effects-child");
			child.toggleClass("animated flash");
		});
	}

	//add bounce effect
	function cssanimated_add_bounce_effects() {
		jQuery(".add-bounce-effects-parent").hover(function() {
			var child = jQuery(this).find(".add-bounce-effects-child");
			child.toggleClass("animated bounce");
		});
	}

	//add shake effect
	function cssanimated_add_shake_effects() {
		jQuery(".add-shake-effects-parent").hover(function() {
			var child = jQuery(this).find(".add-shake-effects-child");
			child.toggleClass("animated shake");
		});
	}

	//add tada effect
	function cssanimated_add_tada_effects() {
		jQuery(".add-tada-effects-parent").hover(function() {
			var child = jQuery(this).find(".add-tada-effects-child");
			child.toggleClass("animated tada");
		});
	}

	//add swing effect
	function cssanimated_add_swing_effects() {
		jQuery(".add-swing-effects-parent").hover(function() {
			var child = jQuery(this).find(".add-swing-effects-child");
			child.toggleClass("animated swing");
		});
	}

	//add wobble effect
	function cssanimated_add_wobble_effects() {
		jQuery(".add-wobble-effects-parent").hover(function() {
			var child = jQuery(this).find(".add-wobble-effects-child");
			child.toggleClass("animated wobble");
		});
	}

	//add wiggle effect
	function cssanimated_add_wiggle_effects() {
		jQuery(".add-wiggle-effects-parent").hover(function() {
			var child = jQuery(this).find(".add-wiggle-effects-child");
			child.toggleClass("animated wiggle");
		});
	}

	//add pulse effect
	function cssanimated_add_pulse_effects() {
		jQuery(".add-pulse-effects-parent").hover(function() {
			var child = jQuery(this).find(".add-pulse-effects-child");
			child.toggleClass("animated pulse");
		});
	}

	cssanimated_add_flash_effects();
	cssanimated_add_wiggle_effects();
	cssanimated_add_bounce_effects();
	cssanimated_add_shake_effects();
	cssanimated_add_tada_effects();
	cssanimated_add_swing_effects();
	cssanimated_add_wobble_effects();
	cssanimated_add_pulse_effects();

	/******************* Flippers (currently Webkit, Firefox, & IE10 only) *****************************************/

	//add flip effect
	function cssanimated_add_flip_effects() {
		jQuery(".add-flip-effects-parent").hover(function() {
			var child = jQuery(this).find(".add-flip-effects-child");
			child.toggleClass("animated flip");
		});
	}

	//add flipinx effect
	function cssanimated_add_flipinx_effects() {
		jQuery(".add-flipinx-effects-parent").hover(function() {
			var child = jQuery(this).find(".add-flipinx-effects-child");
			child.toggleClass("animated flipInX");
		});
	}

	//add flipoutx effect
	function cssanimated_add_flipoutx_effects() {
		jQuery(".add-flipoutx-effects-parent").hover(function() {
			var child = jQuery(this).find(".add-flipoutx-effects-child");
			child.toggleClass("animated flipOutX");
		});
	}

	//add flipiny effect
	function cssanimated_add_flipiny_effects() {
		jQuery(".add-flipiny-effects-parent").hover(function() {
			var child = jQuery(this).find(".add-flipiny-effects-child");
			child.toggleClass("animated flipInY");
		});
	}

	//add flipouty effect
	function cssanimated_add_flipouty_effects() {
		jQuery(".add-flipouty-effects-parent").hover(function() {
			var child = jQuery(this).find(".add-flipouty-effects-child");
			child.toggleClass("animated flipOutY");
		});
	}

	cssanimated_add_flip_effects();
	cssanimated_add_flipinx_effects();
	cssanimated_add_flipoutx_effects();
	cssanimated_add_flipiny_effects();
	cssanimated_add_flipouty_effects();

	/******************* Fading entrances *****************************************/

	//add fadeIn effect
	function cssanimated_add_fadein_effects() {
		jQuery(".add-fadein-effects-parent").hover(function() {
			var child = jQuery(this).find(".add-fadein-effects-child");
			child.toggleClass("animated fadeIn");
		});
	}

	//add fadeInup effect
	function cssanimated_add_fadeinup_effects() {
		jQuery(".add-fadeinup-effects-parent").hover(function() {
			var child = jQuery(this).find(".add-fadeinup-effects-child");
			child.toggleClass("animated fadeInUp");
		});
	}

	//add fadeIndown effect
	function cssanimated_add_fadeindown_effects() {
		jQuery(".add-fadeindown-effects-parent").hover(function() {
			var child = jQuery(this).find(".add-fadeindown-effects-child");
			child.toggleClass("animated fadeInDown");
		});
	}

	//add fadeInleft effect
	function cssanimated_add_fadeinleft_effects() {
		jQuery(".add-fadeinleft-effects-parent").hover(function() {
			var child = jQuery(this).find(".add-fadeinleft-effects-child");
			child.toggleClass("animated fadeInLeft");
		});
	}

	//add fadeInright effect
	function cssanimated_add_fadeinright_effects() {
		jQuery(".add-fadeinright-effects-parent").hover(function() {
			var child = jQuery(this).find(".add-fadeinright-effects-child");
			child.toggleClass("animated fadeInRight");
		});
	}

	//add fadeInupbig effect
	function cssanimated_add_fadeinupbig_effects() {
		jQuery(".add-fadeinupbig-effects-parent").hover(function() {
			var child = jQuery(this).find(".add-fadeinupbig-effects-child");
			child.toggleClass("animated fadeInUpBig");
		});
	}

	//add fadeIndownbig effect
	function cssanimated_add_fadeindownbig_effects() {
		jQuery(".add-fadeindownbig-effects-parent").hover(function() {
			var child = jQuery(this).find(".add-fadeindownbig-effects-child");
			child.toggleClass("animated fadeInDownBig");
		});
	}

	//add fadeInleftbig effect
	function cssanimated_add_fadeinleftbig_effects() {
		jQuery(".add-fadeinleftbig-effects-parent").hover(function() {
			var child = jQuery(this).find(".add-fadeinleftbig-effects-child");
			child.toggleClass("animated fadeInLeftBig");
		});
	}

	//add fadeInrightbig effect
	function cssanimated_add_fadeinrightbig_effects() {
		jQuery(".add-fadeinrightbig-effects-parent").hover(function() {
			var child = jQuery(this).find(".add-fadeinrightbig-effects-child");
			child.toggleClass("animated fadeInRightBig");
		});
	}


	cssanimated_add_fadein_effects();
	cssanimated_add_fadeinup_effects();
	cssanimated_add_fadeindown_effects();
	cssanimated_add_fadeinleft_effects();
	cssanimated_add_fadeinright_effects();
	cssanimated_add_fadeinupbig_effects();
	cssanimated_add_fadeindownbig_effects();
	cssanimated_add_fadeinleftbig_effects();
	cssanimated_add_fadeinrightbig_effects();

	/******************* Bouncing entrances *****************************************/

	//add bouncein effect
	function cssanimated_add_bouncein_effects() {
		jQuery(".add-bouncein-effects-parent").hover(function() {
			var child = jQuery(this).find(".add-bouncein-effects-child");
			child.toggleClass("animated bounceIn");
		});
	}

	//add bounceindown effect
	function cssanimated_add_bounceindown_effects() {
		jQuery(".add-bounceindown-effects-parent").hover(function() {
			var child = jQuery(this).find(".add-bounceindown-effects-child");
			child.toggleClass("animated bounceInDown");
		});
	}

	//add bounceinup effect
	function cssanimated_add_bounceinup_effects() {
		jQuery(".add-bounceinup-effects-parent").hover(function() {
			var child = jQuery(this).find(".add-bounceinup-effects-child");
			child.toggleClass("animated bounceInUp");
		});
	}

	//add bounceinleft effect
	function cssanimated_add_bounceinleft_effects() {
		jQuery(".add-bounceinleft-effects-parent").hover(function() {
			var child = jQuery(this).find(".add-bounceinleft-effects-child");
			child.toggleClass("animated bounceInLeft");
		});
	}

	//add bounceinright effect
	function cssanimated_add_bounceinright_effects() {
		jQuery(".add-bounceinright-effects-parent").hover(function() {
			var child = jQuery(this).find(".add-bounceinright-effects-child");
			child.toggleClass("animated bounceInRight");
		});
	}

	//add bounceindownfadeoutup effect
	function cssanimated_add_bounceindownfadeoutup_effects() {
		jQuery(".add-bounceindownfadeoutup-effects-parent").hover(
			function() {
				var child = jQuery(this).find(".add-bounceindownfadeoutup-effects-child");
				child.removeClass("fadeOutUp");
				child.addClass("animated bounceInDown");
			},
			function() {
				var child = jQuery(this).find(".add-bounceindownfadeoutup-effects-child");
				child.removeClass("bounceInDown");
				child.addClass("animated fadeOutUp");
			}
		);
	}

	cssanimated_add_bouncein_effects();
	cssanimated_add_bounceindown_effects();
	cssanimated_add_bounceinup_effects();
	cssanimated_add_bounceinleft_effects();
	cssanimated_add_bounceinright_effects();
	cssanimated_add_bounceindownfadeoutup_effects();

	/******************* Rotating entrances *****************************************/

	//add rotatein effect
	function cssanimated_add_rotatein_effects() {
		jQuery(".add-rotatein-effects-parent").hover(function() {
			var child = jQuery(this).find(".add-rotatein-effects-child");
			child.toggleClass("animated rotateIn");
		});
	}

	//add rotateindownleft effect
	function cssanimated_add_rotateindownleft_effects() {
		jQuery(".add-rotateindownleft-effects-parent").hover(function() {
			var child = jQuery(this).find(".add-rotateindownleft-effects-child");
			child.toggleClass("animated rotateInDownLeft");
		});
	}

	//add rotateindownright effect
	function cssanimated_add_rotateindownright_effects() {
		jQuery(".add-rotateindownright-effects-parent").hover(function() {
			var child = jQuery(this).find(".add-rotateindownright-effects-child");
			child.toggleClass("animated rotateInDownRight");
		});
	}

	//add rotateinupleft effect
	function cssanimated_add_rotateinupleft_effects() {
		jQuery(".add-rotateinupleft-effects-parent").hover(function() {
			var child = jQuery(this).find(".add-rotateinupleft-effects-child");
			child.toggleClass("animated rotateInUpLeft");
		});
	}

	//add rotateinupright effect
	function cssanimated_add_rotateinupright_effects() {
		jQuery(".add-rotateinupright-effects-parent").hover(function() {
			var child = jQuery(this).find(".add-rotateinupright-effects-child");
			child.toggleClass("animated rotateInUpRight");
		});
	}

	cssanimated_add_rotatein_effects();
	cssanimated_add_rotateindownleft_effects();
	cssanimated_add_rotateindownright_effects();
	cssanimated_add_rotateinupleft_effects();
	cssanimated_add_rotateinupright_effects();

	/******************* Lightspeed and Specials *****************************************/

	//add lightspeedin effect
	function cssanimated_add_lightspeedin_effects() {
		jQuery(".add-lightspeedin-effects-parent").hover(function() {
			var child = jQuery(this).find(".add-lightspeedin-effects-child");
			child.toggleClass("animated lightSpeedIn");
		});
	}

	//add lightspeedout effect
	function cssanimated_add_lightspeedout_effects() {
		jQuery(".add-lightspeedout-effects-parent").hover(function() {
			var child = jQuery(this).find(".add-lightspeedout-effects-child");
			child.toggleClass("animated lightSpeedOut");
		});
	}

	//add hinge effect
	function cssanimated_add_hinge_effects() {
		jQuery(".add-hinge-effects-parent").hover(function() {
			var child = jQuery(this).find(".add-hinge-effects-child");
			child.toggleClass("animated hinge");
		});
	}

	//add rollin effect
	function cssanimated_add_rollin_effects() {
		jQuery(".add-rollin-effects-parent").hover(function() {
			var child = jQuery(this).find(".add-rollin-effects-child");
			child.toggleClass("animated rollIn");
		});
	}

	//add rollout effect
	function cssanimated_add_rollout_effects() {
		jQuery(".add-rollout-effects-parent").hover(function() {
			var child = jQuery(this).find(".add-rollout-effects-child");
			child.toggleClass("animated rollOut");
		});
	}
	
	cssanimated_add_lightspeedin_effects();
	cssanimated_add_lightspeedout_effects();
	cssanimated_add_hinge_effects();
	cssanimated_add_rollin_effects();
	cssanimated_add_rollout_effects();

});