<?php
/*
Plugin Name: WooCommerce to Bussk Export
Plugin URI: https://implementareapi.ro
Description: Export Products to Bussk Marketplace
Version: 1.0
Author: ImplementareApi (Andrei O Laurentiu)
Author URI: https://implementareapi.ro
*/


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define ( 'BUSSK_EXP_PLUGIN_PATH' , plugin_dir_path( __FILE__ ) );
define('BUSSK_EXP_DOMAIN', 'bussk-woocommerce-exporter');
define( 'BUSSK_EXP_URL', plugin_dir_url( __FILE__ ) );

//only proceed if we are in admin mode!
if( ! is_admin() ){
	return;
}

//Globals
global $bussk_export_globals;


$entities = array();
$entities[] = "Produse";


//Create an array of which entities are active
$active = array();
$active["Produse"] = true;


$bussk_export_globals['entities'] = $entities;
$bussk_export_globals['active'] = $active;

//Include the basic stuff
include_once(BUSSK_EXP_PLUGIN_PATH . 'inc/bussk-exporter.php');
include_once(BUSSK_EXP_PLUGIN_PATH . 'inc/BaseEntity.php');

//include the entities
foreach($bussk_export_globals['entities'] as $entity){
	include_once(BUSSK_EXP_PLUGIN_PATH . 'inc/' . $entity . '.php');

}

/**
 * Loads the right js & css assets
*/
function load_bussk_exp_scripts(){



	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-core');
	//wp_enqueue_script('jquery-ui-tabs');
	
 	//Need the jquery CSS files
	global $wp_scripts;
	$jquery_version = isset( $wp_scripts->registered['jquery-ui-core']->ver ) ? $wp_scripts->registered['jquery-ui-core']->ver : '1.9.2';
	// Admin styles for WC pages only
	wp_enqueue_style( 'woocommerce_admin_styles', WC()->plugin_url() . '/assets/css/admin.css', array(), WC_VERSION );
	wp_enqueue_style( 'jquery-ui-style', '//code.jquery.com/ui/' . $jquery_version . '/themes/smoothness/jquery-ui.css', array(), $jquery_version );
	
	
	wp_enqueue_style('dashicons');
		
	wp_enqueue_script( 'bussk-css',  plugin_dir_url( __FILE__ ). 'js/main.js' );
	wp_enqueue_style( 'bussk-css',  plugin_dir_url( __FILE__ ). 'css/bussk-export-lite.css' );
}


add_action('admin_enqueue_scripts', 'load_bussk_exp_scripts');

$bussk_exporter_lite = new BUSSK_exporter_lite();

?>