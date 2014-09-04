<?php
/*
Plugin Name: Disable Pointers
Plugin URI: https://github.com/lumpysimon/wp-disable-pointers
Description: Disable the admin pointer tooltips introduced in WordPress 3.3
Version: 0.2
Author: Simon Blackbourn
Author URI: http://lumpylemon.co.uk



	This is a plugin for WordPress (http://wordpress.org).

	Released under the GPL license:
	http://www.opensource.org/licenses/gpl-license.php

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.



*/



$lumpy_disable_pointers = new lumpy_disable_pointers;



class lumpy_disable_pointers {



	public function __construct() {

		add_action( 'wp_default_scripts', array( $this, 'no_pointer_script' ) );
		add_action( 'wp_default_styles',  array( $this, 'no_pointer_style'  ) );

	}



	function no_pointer_script( $scripts ) {

		$scripts->remove( 'wp-pointer' );

	}



	function no_pointer_style( $styles ) {

		$styles->remove( 'wp-pointer' );

	}



} // class
