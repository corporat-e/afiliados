<?php
/**
 * Footer manager for apus framework
 *
 * @package    apus-framework
 * @author     Team Apusthemes <apusthemes@gmail.com >
 * @license    GNU General Public License, version 3
 * @copyright  2015-2016 Apus Framework
 */
 
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

class Apus_PostType_Footer {

  	public static function init() {
    	add_action( 'init', array( __CLASS__, 'register_post_type' ) );
    	add_action( 'init', array( __CLASS__, 'register_footer_vc' ) );
  	}

  	public static function register_post_type() {
	    $labels = array(
			'name'                  => __( 'Apus Footer', 'apus-framework' ),
			'singular_name'         => __( 'Footer', 'apus-framework' ),
			'add_new'               => __( 'Add New Footer', 'apus-framework' ),
			'add_new_item'          => __( 'Add New Footer', 'apus-framework' ),
			'edit_item'             => __( 'Edit Footer', 'apus-framework' ),
			'new_item'              => __( 'New Footer', 'apus-framework' ),
			'all_items'             => __( 'All Footers', 'apus-framework' ),
			'view_item'             => __( 'View Footer', 'apus-framework' ),
			'search_items'          => __( 'Search Footer', 'apus-framework' ),
			'not_found'             => __( 'No Footers found', 'apus-framework' ),
			'not_found_in_trash'    => __( 'No Footers found in Trash', 'apus-framework' ),
			'parent_item_colon'     => '',
			'menu_name'             => __( 'Apus Footers', 'apus-framework' ),
	    );

	    register_post_type( 'apus_footer',
	      	array(
		        'labels'            => apply_filters( 'apus_postype_footer_labels' , $labels ),
		        'supports'          => array( 'title', 'editor' ),
		        'public'            => true,
		        'has_archive'       => true,
		        'menu_position'     => 51,
		        'menu_icon'         => 'dashicons-admin-home',
	      	)
	    );

  	}

  	public static function register_footer_vc() {
	    $options = get_option('wpb_js_content_types');
	    if ( is_array($options) && !in_array('apus_footer', $options) ) {
	      	$options[] = 'apus_footer';
	      	update_option( 'wpb_js_content_types', $options );
	    }
  	}
  
}

Apus_PostType_Footer::init();