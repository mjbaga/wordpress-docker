<?php

namespace SiteEvents\Post;

use Carbon\Carbon;

class Query
{
	/**
	* Implementation of get_event_details() function. returns details for event
	* 
	* @param post $event
	*/
	public static function get_event_details()
	{
		$data = array();
		$data['title'] = apply_filters( 'the_title', get_the_title());
		$data['image'] = get_the_post_thumbnail_url( null , 'full' );
		$image_alt = get_the_post_thumbnail_caption(null);

		if(!$image_alt) {
			$image_alt = get_post(get_post_thumbnail_id())->post_title;
		}
    $data['image_alt'] = $image_alt;
    $data['content'] = apply_filters( 'the_content', get_the_content());
	  $data['url'] = get_the_permalink();
		$data['excerpt'] = strip_tags( apply_filters( 'the_excerpt', get_the_excerpt() ) );

		return $data;
	}

	/**
	 * Get a specified number of events
	 * @param  int $n number of events
	 * @return array    retrieved posts
	 */
	public static function get_events($n)
	{
		$today = date( 'Ymd' );

		$args = array(
			'post_type' => SITE_EVENT_SLUG,
			'numberposts' => $n,
			'post_status' => 'publish',
			'meta_query'	=> array(
				array(
					'key' => 'event_end_date',
					'value' => $today,
					'compare' => '>=',
				),
			),
			'meta_key' => 'event_start_date',
			'orderby' => 'meta_value_num',
			'order' => 'asc'
		);

		$events = get_posts( $args );

		return $events;
	}

	/**
	 * Get page details for listing page
	 * @return array
	 */
	public static function get_page_details()
	{
		$data = array();
		$data['title'] = apply_filters( 'the_title', get_the_title());
		$data['content'] = apply_filters( 'the_content', get_the_content());
		$data['featured_image'] = get_the_post_thumbnail_url(get_the_ID());
		$data['terms'] = get_terms( array(
			'taxonomy' => 'event_type',
			'hide_empty' => false
		) );
		
		return $data;
	}

	/**
	 * This is returned from the API call for events
	 * 
	 * @param  array $params
	 * @return JSON response
	 */
	public static function get_latest_events($params)
	{
		$page = absint($params['page']);
		$toload = absint($params['toload']);
		$perpage = get_option( 'posts_per_page' );
		$date = $params['date'] ? $params['date'] : null;
		$term = $params['category'] ? $params['category'] : null;

		$data = array();
		$data['page'] = $page + 1;
		$data['type'] = 'events';

		$query = self::get_posts_data($page, $toload, $date, $term);

		global $post;

		foreach( $query['posts'] as $post ) {
			setup_postdata( $post );

			$location = get_field( 'location' );

			$event = array();
			$event['title'] = apply_filters( 'the_title', get_the_title());
			$event['image'] = get_the_post_thumbnail_url( null , 'full' );
			$event['desc'] = strip_tags( apply_filters( 'the_excerpt', get_the_excerpt() ) );
			$event['link'] = get_the_permalink();

			$data['lists'][] = $event;
		}
        
		wp_reset_postdata();

		$total_no_of_posts = wp_count_posts( 'site-event' );
        
		if($toload * $page >= $total_no_of_posts->publish) {
			$data['last'] = 1;
		}

		return $data;
	}

	public static function get_posts_data($page = 1, $perpage = -1, $date = null, $term = null)
	{
		if($date == null) {
			$date = date( 'Ymd' );
		}
		
		// Use Carbon for date
		$query_date = Carbon::parse($date);

		// Query with custom field sort
		$args = array(
			'post_type' => SITE_EVENT_SLUG,
			'numberposts' => $perpage,
			'paged' => $page,
			'post_status' => 'publish',
			'meta_query'  => array(
				array(
					'key' => 'event_end_date',
					'value' => $query_date->format('Ymd'),
					'compare' => '>=',
				),
			),
			'meta_key' => 'event_start_date',
			'orderby' => 'meta_value_num',
			'order' => 'asc'
		);

		// Add taxonomy on query
		if($term != 'all') {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'event_type',
					'field' => 'slug',
					'terms' => $term
				)
			);
		}

		$posts = get_posts( $args );

		$data = array();
		$data['posts'] = $posts;

		return $data;
	}

}