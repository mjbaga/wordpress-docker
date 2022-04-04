<?php

/**
 * Site Prefix
 */
if( !defined('EVENT_SITE_PREFIX') ) {
	define( 'EVENT_SITE_PREFIX', 'event-' );
}

/**
 * Plugin Directory
 */
if( !defined('SITE_EVENT_PLUGIN_DIR') ) {
	define( 'SITE_EVENT_PLUGIN_DIR', dirname( __FILE__ ) . '/..' );
}

/**
 * Site Prefix
 */
if( !defined('SITE_EVENT_SLUG') ) {
	define( 'SITE_EVENT_SLUG', 'site-event' );
}

/*
 * Event Listing Cache Time for featured items
 */
if( !defined( 'SITE_EVENT_CACHE_TIME' ) ) {
	define( 'SITE_EVENT_CACHE_TIME', 1800 ); //30 * 60
}

/**
 * Event Options name in cms settings
 */
if( !defined( 'SITE_EVENT_OPTIONS_NAME' ) ) {
  	define( 'SITE_EVENT_OPTIONS_NAME', 'site_events_options_name' );
}