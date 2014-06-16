<?php
 /**
 * Template Name: cb-homepage
 *
 * @package WordPress
 */
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
 ?>
<!--<meta http-equiv="refresh" content="0; url=http://cardiganbasket.co.uk/marketplace/categories/fruit/" />-->
 <?php
 get_header();
 ?>   
<div id="content">
    	    		
         <!--<div id="mp-product-grid"> -->
         
				<?php 	mp_list_global_products(
                        array(
                            'echo' => true,
                            'paginate' => true,
                            'per_page' => 15,
                                'order_by' => 'date',
                            'order' => 'DESC',
                                'category' => '',
                            'tag' => '',
                                'show_thumbnail' => true,
                                'thumbnail_size' => 150,
                                'context' => 'list',
                                'show_price' => true,
                                'text' => 'excerpt',
                                'as_list' => false
                            ));?>
                           
                   <?php mp_global_products_nav_link(array(
                                'echo' => true,
                            'per_page' => 15,
                                'category' => '',
                            'tag' => '',
                                'sep' => ' — ',
                                'prelabel' => __('&laquo; Previous', 'mp'),
                                'nxtlabel' => __('Next &raquo;', 'mp')
                            ));
							
							
							?> 
							
		
		<!--</div>-->			         

</div>    
<?php
	get_sidebar();
    get_footer();
 ?>   



