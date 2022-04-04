<?php

namespace SiteEvents\Widget;

use SiteEvents\Api\Api;
use SiteEvents\Post\Query;

class Widget extends \WP_Widget
{

	public function __construct()
	{
		$this->widget_slug = 'site_event_widget';
		$this->widget_template_slug = 'widget';
		$this->widget_template = 'content-event-widget.php';

		add_action( 'save_post_' . SITE_EVENT_PLUGIN_DIR, array( $this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );

		parent::__construct(
			$this->widget_slug, // Base ID
			__( 'Events Widget', $this->widget_slug ), // Name
			array( 'description' => __( 'A widget to display events.', $this->widget_slug ), ) // Args
		);

		add_action( 'init', array( $this, 'register_fields' ) );
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		echo $this->parse_widget( $instance );
		echo $args['after_widget'];
	}

	/**
	 *
	 * @param type $instance instance of this widget specified in widget area.
	 * @return String html for all the sideposts to be rendered. Returns from cache if cache exists.
	 */
	public function parse_widget( $instance ) {
		$cache_key = $this->id;
		$cache = get_transient( $cache_key );
		$cache_time = 1800; 

		if( $cache ) {
			return $cache;
		}

		// get 3 items
		$events = Api::get_events(3);

		$data = array();
		$data['title'] = get_field( 'title', 'widget_' . $this->id );
		$data['description'] = get_field( 'description', 'widget_' . $this->id );

		global $post;

		foreach( $events as $post ) {
			setup_postdata( $post );
			$data['events'][] = Query::get_event_details();
		}

		wp_reset_postdata();

		$html = Api::render( $this->widget_template, $data );

		set_transient( $cache_key, $html, $cache_time );
		return $html;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		
	}
	
	public function flush_widget_cache() {
		$cache_key = $this->widget_slug . '_' . $this->id;
		delete_transient( $cache_key );
	}

	function register_fields()
	{
		// Register widget fields with ACF
	}

}