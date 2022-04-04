<?php
/**
 * The template for displaying single event template
 */

use SiteEvents\Api\Api;

get_header(); ?>
<div class="scroll-wrap">
<?php
while( have_posts() ) {
  
	the_post();

	$template = 'content-event-details.php';

	$data = Api::get_event_details();

	Api::render($template, $data);
    
}

get_footer();
