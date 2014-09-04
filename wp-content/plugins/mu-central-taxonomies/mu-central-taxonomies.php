<?php
/*
Plugin Name: MU Central Taxonomies
Plugin URI: http://www.bang-on.net/
Description: On a multisite network, this makes a child site use the main site's categories and taxonomies instead of its own.
Version: 1.0
Author: Marcus Downing
Author URI: http://www.bang-on.net/
License: Private
*/

if (!defined('MU_CENTRAL_TAXONOMIES_DEBUG'))
  define('MU_CENTRAL_TAXONOMIES_DEBUG', false);

if (MU_CENTRAL_TAXONOMIES_DEBUG) do_action('log', 'Central taxonomies: Init', $wpdb);
add_action('muplugins_loaded', 'mu_central_taxonomies');
add_action('plugins_loaded', 'mu_central_taxonomies');
add_action('init', 'mu_central_taxonomies');
add_action('wp_loaded', 'mu_central_taxonomies');
add_action('switch_blog', 'mu_central_taxonomies');
add_action('template_redirect', 'mu_central_taxonomies');
function mu_central_taxonomies () {
  global $wpdb;

  $prefix = $wpdb->base_prefix;
  $wpdb->terms = $prefix."terms";
  $wpdb->term_taxonomy = $prefix."term_taxonomy";
  if (MU_CENTRAL_TAXONOMIES_DEBUG) do_action('log', 'Central taxonomies', '!prefix,terms,term_relationships,term_taxonomy', $wpdb);
}
