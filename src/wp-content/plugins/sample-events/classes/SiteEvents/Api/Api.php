<?php

namespace SiteEvents\Api;

use SiteEvents\Post\Query;
use SiteEvents\Util\ViewRenderer;

class Api
{
	/**
	 * This function renders templates on specified path
	 * @param  string $template_path
	 * @param  array $data
	 */
	public static function render($template_path, $data)
	{
		$vr = new ViewRenderer(site_events_template_path($template_path), $data);
		$vr->render();
	}

	/**
	 * This function returns all event details of event post. Use 
	 * this function after starting the loop.
	 * 
	 * @return array
	 */
	public static function get_event_details() {
	    try{
	        $data = Query::get_event_details();
	        return $data;
	    } catch (Exception $ex) {
	        error_log( $ex->getMessage() );
	        return array();
	    }
	}

	/**
	 * This function returns all list of events from API call
	 * 
	 * @return array
	 */
	public static function get_latest_events($params) {
	    $events = Query::get_latest_events($params);
		return $events;
	}
	
	public static function get_events($n)
	{
		$events = Query::get_events($n);
		return $events;
	}

	public static function get_page_details()
	{
		$listing = Query::get_page_details();
		return $listing;
	}

	public static function get_posts_data($page = 1, $perpage = -1)
	{
		try{
		    $data = Query::get_posts_data($page, $perpage);
		    return $data;
		} catch (Exception $ex) {
		    error_log( $ex->getMessage() );
		    return array();
		}
	}
}