<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              cubedesigns.gr
 * @since             1.0.0
 * @package           Cds_Theme_Page_Dev
 *
 * @wordpress-plugin
 * Plugin Name:       Theme Development - Page Name
 * Plugin URI:        cubedesigns.gr/wp-plugins/cds-theme-page-dev
 * Description:       If you are admin, it will diplay a small message about the name of the template currently used in the viewing page.
 * Version:           1.0.0
 * Author:            Apostolos Gouvalas
 * Author URI:        cubedesigns.gr
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cds-theme-page-dev
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ){
	echo 'Not Allowed! Get out of here!';
	exit();
}

/*
function get_current_template() {
	global $wp_query;
	$template_name = str_replace('.php','',get_post_meta($wp_query->post->ID,'_wp_page_template',true));
	if ( $template_name ) return $template_name;
	else return false;
}
*/

/**
 * Define current template file
 *
 * Create a global variable with the name of the current
 * theme template file being used.
 *
 * @param $template The full path to the current template
 */
function define_current_template( $template ) {
	$GLOBALS['current_theme_template'] = basename($template);

	return $template;
}
add_action('template_include', 'define_current_template', 1000);


/**
 * Get Current Theme Template Filename
 *
 * Get's the name of the current theme template file being used
 *
 * @global $current_theme_template Defined using define_current_template()
 * @param $echo Defines whether to return or print the template filename
 * @return The name of the template filename, including .php
 */
function get_current_template( $echo = false ) {
	if ( !isset( $GLOBALS['current_theme_template'] ) ) {
		trigger_error( '$current_theme_template has not been defined yet', E_USER_WARNING );
		return false;
	}
	if ( $echo ) {
		echo $GLOBALS['current_theme_template'];
	}
	else {
		return $GLOBALS['current_theme_template'];
	}
}



// Add scripts to wp_footer()
function cds_theme_page_dev_script() {
	// If the current user can manage options(ie. an admin)
	if( current_user_can( 'manage_options' ) ){
		// Print the saved global
		$per = "%";
		printf( '<div style="position:fixed; top:50%s; margin-top:-75px; z-index:9999; background-color: rgba(69, 247, 75, 0.76); padding:15px;"><strong>Current template:</strong><span style="color:red; font-size:22px;"> %s </span></div>', $per, get_current_template() );
	}
}

add_action( 'wp_footer', 'cds_theme_page_dev_script' );
