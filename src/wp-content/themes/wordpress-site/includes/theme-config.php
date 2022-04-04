<?php

/**
 * Site constants
 */
if( !defined( 'SITE_NAME') ) {
	define( 'SITE_NAME', get_bloginfo( 'name' ) );
}
if( !defined( 'THEME_ABSOLUTE_PATH') ) {
	define( 'THEME_ABSOLUTE_PATH', get_stylesheet_directory() );
}
if( !defined( 'SITE_DESCRIPTION') ) {
	define( 'SITE_DESCRIPTION', get_bloginfo( 'description' ) );
}
if( !defined( 'THEME_URL') ) {
	define( 'THEME_URL', get_stylesheet_directory_uri() );
}
if( !defined( 'ASSETS_URL') ) {
	define( 'ASSETS_URL', site_get_assets_url() );
}
if( !defined( 'HOME_URL') ) {
	define( 'HOME_URL', home_url() );
}
