<?php

namespace SiteEvents;

use SiteEvents\Post\Post;
use SiteEvents\Page\ListingPage;
use SiteEvents\Api\Api;

class Event
{

	public $settings;

	protected static $instance;

	/**
	 * Returns an instance of this class. An implementation of the singleton design pattern.
	 *
	 * @return   Event    A reference to an instance of this class.
	 * @since    0.1.0
	 */
	public static function get_instance() 
	{
		if( null == self::$instance ) {
			self::$instance = new Event();
		}

		return self::$instance;
	}

	private function __construct()
	{
		$this->init_custom_posts();
		$this->init_widgets();
		$this->init_page_templates();
		// $this->init_events_api();
	}

	function init_custom_posts() 
	{
		$events = Post::get_instance();
	}

	private function init_widgets() 
	{
		add_action( 'widgets_init', array( $this, 'register_widgets' ) );
	}

	function register_widgets() 
	{
		register_widget( 'SiteEvents\\Widget\\Widget' );
	}

	function init_page_templates() 
	{
		$page_templates = ListingPage::get_instance();
	}

	// Custom REST API call
	function init_events_api()
	{
		add_action( 'rest_api_init', function () {
			// Calls to /events/latest
			register_rest_route( 'events', 'latest',array(
					'methods'  => array('GET'), // Add 'POST' for post calls
					'callback' => array('\\SiteEvents\\Api\\Api', 'get_latest_events')
			));
		});
	}

}