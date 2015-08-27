<?php

/*
Plugin Name: Clink - Countdown then Redirect links
Plugin URI:  http://aryanthemes.com
Description: Countdown then Redirect is a WordPress plugin to manage 301 redirections and count their visits. You can use a countdown before redirect to links.
Version:     1.1
Author:      Aryan Themes
Author URI:  http://aryanthemes.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages 
Text Domain: aryan-themes
*/


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define("CLINK_DIR", dirname(__FILE__));
define("CLINK_URL", plugin_dir_url( __FILE__ ));


/**
 * Load Clink translations
 */
 
function clink_load_textdomain() {
	load_plugin_textdomain( 'aryan-themes', false, dirname( plugin_basename( __FILE__ ) ) .'/languages/' );
}
add_action( 'plugins_loaded', 'clink_load_textdomain', 1 );


/**
 * include major files
 */
 
require_once CLINK_DIR."/inc/cpt.php";
if( is_admin() ){
	require_once CLINK_DIR."/inc/meta-box.php";
	require_once CLINK_DIR."/inc/admin.php";
}


/**
 * set clink single page template
 */
 
function set_clink_single_template($single_template) {

	$object = get_queried_object();
	
	if ($object->post_type == 'clink') {

		function clink_style() {
			global $wp_styles;
			$wp_styles = '';
			wp_enqueue_style( 'clink', CLINK_URL . 'assets/css/style.css');
			if ( get_bloginfo( 'language' ) == "fa-IR" ){
				wp_enqueue_style( 'clink-fa_IR', CLINK_URL . 'assets/css/fa_IR.css');
			}	
		}

		add_action('wp_print_styles','clink_style');
		
		function clink_scripts() {
			global $wp_scripts;
			$wp_scripts = '';
			wp_enqueue_script('jquery');
			wp_enqueue_script( 'countdown360', CLINK_URL . 'assets/js/jquery.countdown360.min.js' );
			wp_enqueue_script( 'clink', CLINK_URL . 'assets/js/main.js' );
		}	
		
		add_action( 'wp_enqueue_scripts', 'clink_scripts' );	
	
        $single_template = CLINK_DIR .'/clink-template.php'; //dirname( clink__FILE__ ) . '/clink-template.php';
		
    }
	
	return $single_template;
    
}
add_filter( 'single_template', 'set_clink_single_template' );

?>