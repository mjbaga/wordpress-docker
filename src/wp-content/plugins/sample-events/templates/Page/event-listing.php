<?php

/**
 * Template Name: Events Listing Page Template
 */

use SiteEvents\Api\Api;

get_header(); ?>
<div class="scroll-wrap">
<?php
while( have_posts() ):

    the_post();

    $paged = absint( get_query_var( 'paged', 1 ) );
    $perpage = get_option( 'posts_per_page' );

    $template = 'content-event-listing.php';

    $data = Api::get_page_details();

    $post_data = Api::get_posts_data( $paged, $perpage );

    foreach( $post_data['posts'] as $post ) {
        setup_postdata( $post );
        $data['events'][] = Api::get_event_details();
    }
    
    wp_reset_postdata();

    Api::render($template, $data);

endwhile;

get_footer();
