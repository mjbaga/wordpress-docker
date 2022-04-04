<?php

/*
	Plugin Name: Site Events
	Description: Sample plugin for events leveraging ACF
	Version: 1.0
	Author: mjdbaga@gmail.com
	Author URI: http://mjbaga.tech/
 */

if( !defined('ABSPATH') )
	die('Access denied.');

require_once dirname( __FILE__ ) . '/includes/plugin-config.php';
require_once dirname( __FILE__ ) . '/vendor/autoload.php';

/** Returns Plugin Directory Path */
function site_events_plugin_path () {
	return plugin_dir_path(__FILE__);
}

/**
 * Returns the absolute path of the specified template
 *
 * @param       string $template template path relative to templates directory
 *
 * @return      string absolute path to template
 */
function site_events_template_path ($template) {
	return site_events_plugin_path() . 'templates/' . $template;
}

/**
 * Autoloader for Plugin classes
 *
 * @param       string $className Name of the class that shall be loaded
 */
function site_events_autoload ($className) {

	$filepath = site_events_plugin_path() . '/' . str_replace('\\', '/', $className) . '.php';

	if (file_exists($filepath))
		require_once($filepath);
}

// Backup autoload
// spl_autoload_register('site_events_autoload');

$site_events = SiteEvents\Event::get_instance();