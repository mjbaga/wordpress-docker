<?php

namespace SiteThemeComponents\Shared;

class Navigation
{
	public static function get_primary_navigation() 
	{
		$args = array(
		    'theme_location' => 'primary',
		    'menu' => 'Primary',
		    'container' => '',
		    'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		    'depth' => 3,
		    'echo' => false
		);
		return wp_nav_menu( $args );
	}

  public static function get_footer_navigation() {
    $args = array(
        'theme_location' => 'footer',
        'menu' => 'Footer',
        'container' => 'div',
        'container_class' => '',
        'menu_class' => 'footer-links',
        'echo' => false
    );
    return wp_nav_menu( $args );
  }
}