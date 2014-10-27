<?php
/*
Plugin Name: Taxonomy Sync
Version: 0.1
Plugin URI: http://aristeides.com
Author URI: http://aristeides.com
Description: Sync MarketPress product categories network-wide
Author: Aristeides Stathopoulos
Network: true
*/

// Taxonomies
$taxonomies_to_sync = array( 'product_category' ); // Change These!

function ms_taxonomy_sync_add_menu() {
	add_submenu_page( 'index.php', __('Taxonomy Sync'), __('Taxonomy Sync'), 'manage-options', 'ms-taxonomy-sync-'.basename(__FILE__), 'ms_taxonomy_sync_page');
}
add_action('network_admin_menu', 'ms_taxonomy_sync_add_menu');

function ms_taxonomy_sync_page() {
	
	if ( !current_user_can('manage_options') )
    	wp_die( __('You do not have sufficient permissions to access this page.') );

	$ms_taxonomy_sync = 'ms-taxonomy-sync';
	
	if ( isset($_POST[ $ms_taxonomy_sync ]) && $_POST[ $ms_taxonomy_sync ] == '1' ) { 
		ms_taxonomy_sync(); ?>
		<div class="updated"><p><strong><?php _e('Taxonomy synchronization completed.'); ?></strong></p></div>
	<?php }
	
	echo '<div class="wrap">';
    echo '<h2>' . __( 'Sync Taxonomies Across Network') . '</h2>';
	?>
	
	<form name="ms-taxonomy-sync" method="post" action="">
	<input type="hidden" name="<?php echo $ms_taxonomy_sync; ?>" value="1">
	<p class="submit">
	<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Sync Taxonomies') ?>" />
	</p>
	</form>
	
	<?php
	echo '</div>';
}

// Taxonomy Sync
function ms_taxonomy_sync() {
	
	// Globals
	global $wpdb;
	global $switched;
	global $current_site;
	global $taxonomies_to_sync;
	
	// Master Site?
	if ($current_site->id == 1) :
	
		foreach ($taxonomies_to_sync as $taxonomy_to_sync) :
	
			// Get Master Taxonomies
			$query = "SELECT * FROM ".$wpdb->prefix."terms a, ".$wpdb->prefix."term_taxonomy b where a.term_id = b.term_id and b.taxonomy = '".$taxonomy_to_sync."'";
			$mastertaxonomies = $wpdb->get_results($query);
			//print_r($mastertaxonomies); echo '<br /><br />'; // For Debugging
		
			// Get An Array of Slugs
			$masterslugs = array();
			foreach ($mastertaxonomies as $mastertaxonomy) :
				$masterslugs[] = $mastertaxonomy->slug;
			endforeach;
	
			// Query Sites in Network
			$query = $wpdb->prepare("select blog_id from $wpdb->blogs");
			$sites = $wpdb->get_results($query);
		
			// Use This Later
			$childrentaxonomies = array();

			// For Each Site
			foreach ($sites as $site) :
				// Skip Master Site
				if ($site->blog_id != 1) :				
					// Switch
					switch_to_blog($site->blog_id);
					// Get Taxonomies
					$query = "SELECT * FROM ".$wpdb->prefix."terms a, ".$wpdb->prefix."term_taxonomy b where a.term_id = b.term_id and b.taxonomy = '".$taxonomy_to_sync."'";
					$taxonomies = $wpdb->get_results($query);
					//print_r($taxonomies); echo '<br /><br />'; // For Debugging
					// If a Taxonomy shouldn't be here, delete it
					foreach ($taxonomies as $key => $taxonomy) :
						if (!in_array($taxonomy->slug, $masterslugs)) :
							wp_delete_term( $taxonomy->term_id, $taxonomy_to_sync );
						endif;
					endforeach;
					$query = "SELECT * FROM ".$wpdb->prefix."terms a, ".$wpdb->prefix."term_taxonomy b where a.term_id = b.term_id and b.taxonomy = '".$taxonomy_to_sync."'";
					$taxonomies = $wpdb->get_results($query);
					//print_r($taxonomies); echo '<br /><br />'; // For Debugging
					// Updated Array of Slugs
					$updatedslugs = array();
					foreach ($taxonomies as $taxonomy) :
						$updatedslugs[] = $taxonomy->slug;
					endforeach;
					// If a Taxonomy needs to be here, add it
					foreach ($mastertaxonomies as $key => $mastertaxonomy) :
						if (!in_array($mastertaxonomy->slug, $updatedslugs)) :
							// Does this Taxonomy have a parent?
							if ($mastertaxonomy->parent == 0) :
								$term = wp_insert_term($mastertaxonomy->name, $taxonomy_to_sync, array('description' => $mastertaxonomy->taxonomy_description, 'slug' => $mastertaxonomy->slug, 'parent' => '0'));
							// Let's come back to this and go through the rest so we get ALL parent ID's
							else :
								foreach ($mastertaxonomies as $i => $tax) :
									if ($mastertaxonomy->parent == $tax->term_id) :
										$parenttaxslug = $mastertaxonomies[$i]->slug;
										$childrentaxonomies[] = array('name' => $mastertaxonomy->name, 'description' => $mastertaxonomy->taxonomy_description, 'slug' => $mastertaxonomy->slug, 'parent_slug' => $parenttaxslug);
									endif;
								endforeach;
							endif;
						endif;
					endforeach;
					$query = "SELECT * FROM ".$wpdb->prefix."terms a, ".$wpdb->prefix."term_taxonomy b where a.term_id = b.term_id and b.taxonomy = '".$taxonomy_to_sync."'";
					$taxonomies = $wpdb->get_results($query);
					//print_r($taxonomies); echo '<br /><br />'; // For Debugging
					// Now we can deal with the child taxonomies
					if ($childrentaxonomies) :
						foreach ($childrentaxonomies as $key => $childtaxonomy) :
							foreach ($taxonomies as $i => $tax) :
								if ($childtaxonomy['parent_slug'] == $tax->slug) :
									$childtaxonomyparent = $taxonomies[$i]->term_id;
									if ($childtaxonomyparent) :
										// Insert Child Taxonomy
										$term = wp_insert_term($childtaxonomy['name'], $taxonomy_to_sync, array('description' => $childtaxonomy['description'], 'slug' => $childtaxonomy['slug'], 'parent' => $childtaxonomyparent));
									endif;
								endif;
							endforeach;
						endforeach;
					endif;
					// Restore
					restore_current_blog();
				endif;
			endforeach;
			// Clear Term Cache For Each Site
			foreach ($sites as $site) :
				// Skip Master Site
				if ($site->blog_id != 1) :				
					// Switch
					switch_to_blog($site->blog_id);
					$query = "SELECT * FROM ".$wpdb->prefix."terms a, ".$wpdb->prefix."term_taxonomy b where a.term_id = b.term_id and b.taxonomy = '".$taxonomy_to_sync."'";
					$taxonomies = $wpdb->get_results($query);
					foreach ($taxonomies as $tax) :
						ms_taxonomy_sync_clean_term_cache($tax->term_id, $taxonomy_to_sync, true, true);
					endforeach;
					restore_current_blog();
				endif;
			endforeach;	
		
		// End For Each Taxonomy
		endforeach;
		
	endif;
}

// Debug
function ms_taxonomy_sync_debug() {
	if (isset($_GET['ms_taxonomy_sync_debug'])) :
		ms_taxonomy_sync();
	endif;
}
add_action( 'admin_init', 'ms_taxonomy_sync_debug' );

function ms_taxonomy_sync_clean_term_cache($ids, $taxonomy = '', $clean_taxonomy = true, $force_clean_taxonomy = false) {
	global $wpdb;
	static $cleaned = array();

	if ( !is_array($ids) )
		$ids = array($ids);

	$taxonomies = array();
	// If no taxonomy, assume tt_ids.
	if ( empty($taxonomy) ) {
		$tt_ids = array_map('intval', $ids);
		$tt_ids = implode(', ', $tt_ids);
		$terms = $wpdb->get_results("SELECT term_id, taxonomy FROM $wpdb->term_taxonomy WHERE term_taxonomy_id IN ($tt_ids)");
		$ids = array();
		foreach ( (array) $terms as $term ) {
			$taxonomies[] = $term->taxonomy;
			$ids[] = $term->term_id;
			wp_cache_delete($term->term_id, $term->taxonomy);
		}
		$taxonomies = array_unique($taxonomies);
	} else {
		$taxonomies = array($taxonomy);
		foreach ( $taxonomies as $taxonomy ) {
			foreach ( $ids as $id ) {
				wp_cache_delete($id, $taxonomy);
			}
		}
	}

	foreach ( $taxonomies as $taxonomy ) {
		if ( isset($cleaned[$taxonomy]) && ! $force_clean_taxonomy )
			continue;
		$cleaned[$taxonomy] = true;

		if ( $clean_taxonomy ) {
			wp_cache_delete('all_ids', $taxonomy);
			wp_cache_delete('get', $taxonomy);
			
			// clear get_terms cache
			$cache_keys = wp_cache_get( 'get_terms:cache_keys', 'terms' );
			if ( ! empty( $cache_keys ) ) {
				foreach ( $cache_keys as $key => $cache_taxonomies ) {
					if ( in_array( $taxonomy, $cache_taxonomies ) ) {
						wp_cache_delete( "get_terms:{$key}", 'terms' );
						unset( $cache_keys[$key] );
					}
				}
			} else {
				$cache_keys = array();
			}
			wp_cache_set( 'get_terms:cache_keys', $cache_keys, 'terms' );
			
			delete_option("{$taxonomy}_children");
			// Regenerate {$taxonomy}_children
			_get_term_hierarchy($taxonomy);
		}

		do_action('clean_term_cache', $ids, $taxonomy);
	}
}