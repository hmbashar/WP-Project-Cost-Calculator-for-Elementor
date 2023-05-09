<?php
/*
Plugin Name: WP Project Cost Calculator for Elementor
Description: Custom widget for Elementor that calculate project cost.
Version: 1.0
Author: Md Abul Bashar
Author URI: https://facebook.com/hmbashar
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

define('WP_PROJECT_COST_CAL_DIR_URI', plugin_dir_url( __FILE__ ));

// Load the text domain for translations
function wpProCal_file_load()
{
    load_plugin_textdomain('wp-project-cal', false, dirname(plugin_basename(__FILE__)) . '/languages/');

    	// Load plugin file
	require_once( __DIR__ . '/config.php' );

	// Run the plugin
	\wpProjectCostCal\Plugin::instance();

}

add_action('plugins_loaded', 'wpProCal_file_load');


function wpProCal_assets_enqueue() {
   

    wp_enqueue_style( 'wp-project-cal-stylesheet', WP_PROJECT_COST_CAL_DIR_URI. '/assets/style.css');
}

add_action( 'wp_enqueue_scripts', 'wpProCal_assets_enqueue' );

