<?php

namespace SiteEvents\Post;

class Post {

	private static $instance;
	private $slug;
	private $label;

	/**
	* Returns an instance of this class. An implementation of the singleton design pattern.
	*
	* @return   Post    A reference to an instance of this class.
	* @since    1.0.0
	*/
	public static function get_instance() {

		if( null == self::$instance ) {
			self::$instance = new Post();
		} // end if

		return self::$instance;
	}

	function __construct() {
		$this->slug = 'site-event';
		$this->label = __( 'Event' );

		add_action( 'init', array( $this, 'init_post' ) );
		add_action( 'init', array( $this, 'register_fields' ) );
		add_action( 'init', array( $this, 'init_taxonomy' ) );
		add_action( 'init', array( $this, 'init_event_template' ) );
	}

	/**
	* Initiate the single template for event post
	*/
	function init_event_template() {
		//add template
		add_filter( 'single_template', array( $this, '_site_event_single_template' ), 10, 1 );
	}

	/**
	* Callback for single template filter for event post type
	* 
	* @param string $single_template
	* @return string
	*/
	function _site_event_single_template( $single_template ) {
		$object = get_queried_object();

		if( $object->post_type != $this->slug ) {
			return $single_template;
		}

		$single_template = SITE_EVENT_PLUGIN_DIR . '/templates/Post/single-' . $this->slug . '.php';
		return $single_template;
	}

	function init_post()
	{
		$args = array(
			'label' => $this->label,
			'public' => TRUE,
			'rewrite' => array( 'slug' => 'event' ),
			'menu_icon' => 'dashicons-album',
			'supports' => array(
				'title',
				'thumbnail',
				'editor',
				'excerpt'
			)
		);
		register_post_type( $this->slug, $args );
	}

	// Sample Taxonomy
	function init_taxonomy()
	{
		$labels = array(
			'name'              => _x( 'Types', 'taxonomy general name', 'textdomain' ),
			'singular_name'     => _x( 'Type', 'taxonomy singular name', 'textdomain' ),
			'search_items'      => __( 'Search Types', 'textdomain' ),
			'all_items'         => __( 'All Types', 'textdomain' ),
			'parent_item'       => __( 'Parent Type', 'textdomain' ),
			'parent_item_colon' => __( 'Parent Type:', 'textdomain' ),
			'edit_item'         => __( 'Edit Type', 'textdomain' ),
			'update_item'       => __( 'Update Type', 'textdomain' ),
			'add_new_item'      => __( 'Add New Type', 'textdomain' ),
			'new_item_name'     => __( 'New Type Name', 'textdomain' ),
			'menu_name'         => __( 'Type', 'textdomain' ),
		);

		$args = array(  
			'hierarchical' => true,  
			'labels' => $labels,
			'query_var' => true,
			'update_count_callback' => '_update_post_term_count',
			'rewrite' => array(
				'slug' => 'event-type'
			)
		);

		register_taxonomy('event_type', 'site-event', $args); 
	}

	function register_fields()
	{
		// Register fields with ACF
	}
}
