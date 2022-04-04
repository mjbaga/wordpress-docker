<?php

namespace SiteThemeComponents\Shared;

class Header
{
	public static function get_data()
	{
		$data = array();
    // Fill header data here
		$data['is_home'] = is_home();
		$data['site_title'] = SITE_NAME;
		$data['logo'] = get_custom_logo();
		$data['primary_navigation'] = Navigation::get_primary_navigation();

		return $data;
	}
}