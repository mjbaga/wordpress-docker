<?php

namespace SiteThemeComponents\Shared;

class Footer
{
	public static function get_data() {
		$data = array();
    // Fill footer data here
		$data['footer_navigation'] = Navigation::get_footer_navigation();

	  return $data;
	}
}