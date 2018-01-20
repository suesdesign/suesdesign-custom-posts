<?php
/**
 * @package Suesdesign Custom Posts
 * @version 1.0
 */
/*
Plugin Name: Suesdesign Custom Posts
Plugin URI: http://suesdesign.co.uk/
Description: Example of custom posts
Author: Sue Johnson
Version: 1.0
Author URI: http://suesdesign.co.uk/
*/

/*
 * register custom post type
*/

function suesdesign_custom_register_post_type() {
	$labels = array( 
		'name'               => _x( 'Custom Posts', 'suesdesign_posts' ),
		'singular name'      => _x( 'Custom Post', 'suesdesign_posts' ),
		'add_new'            => _x( 'Add new Custom Post', 'suesdesign_posts' ),
		'add_new_item'       => __( 'Add new Custom Post', 'suesdesign_posts' ),
		'edit_item'          => __( 'Edit Custom Post', 'suesdesign_posts' ),
		'new_item'           => __( 'New Custom Post', 'suesdesign_posts' ),
		'all_items'          => __( 'All Custom Posts', 'suesdesign_posts' ),
		'view_item'          => __( 'View Custom Post', 'suesdesign_posts' ),
		'search_items'       => __( 'Search Custom Posts', 'suesdesign_posts' ),
		'not_found'          => __( 'No Custom Posts', 'suesdesign_posts' ),
		'not_found_in_trash' => __( 'No Custom Posts found in trash', 'suesdesign_posts' )
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'has archive' => true,
		'supports' => array( 'title', 'editor', 'thumbnail' )
	);
	
	register_post_type( 'suesdesign_posts', $args );
}

add_action( 'init', 'suesdesign_custom_register_post_type' );
	

/*
 * Get template from theme, if not in theme get template from plugin
*/	

function suesdesign_include_template_function( $template_path ) {
   
	if ( is_page('custom-posts') ) {
	// checks if the file exists in the theme first,
	// otherwise serve the file from the plugin
		if ( $theme_file = locate_template( array ( 'suesdesign_custom_posts-page.php' ) ) ) {
				$template_path = $theme_file;
			} else {
				$template_path = plugin_dir_path( __FILE__ ) . 'templates/suesdesign_custom_posts-page.php';
			}
	}

	else if ( is_singular( 'suesdesign_posts' ) ) {
		if ( $theme_file = locate_template( array ( 'single-suesdesign_posts.php' ) ) ) {
				$template_path = $theme_file;
			} else {
				$template_path = plugin_dir_path( __FILE__ ) . 'templates/single-suesdesign_posts.php';
			}
	}
   
	return $template_path;
}

add_filter( 'template_include', 'suesdesign_include_template_function', 1 );


/* 
 * Flush permalinks on plugin activation
*/

register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );
register_activation_hook( __FILE__, 'suesdesign_custom_posts_flush_rewrites' );
function suesdesign_custom_posts_flush_rewrites() {
	// call custom posts registration function
	suesdesign_custom_register_post_type();
	flush_rewrite_rules();
}