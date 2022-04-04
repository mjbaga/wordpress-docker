<!DOCTYPE html><!--[if lt IE 9]>
<html class='lt-ie9 no-js' lang='en'>
<![endif]-->
<!--[if gte IE 9]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width,initial-scale=1"/>

  <!-- favicons -->
  <link rel="shortcut icon" href="/favicon.ico"/>
  <link rel="icon" href="/favicon.ico" type="image/x-icon"/>
  <link rel="apple-touch-icon-precomposed" href="/apple-touch-icon-precomposed.png"/>

  <?php wp_head(); ?>
</head>

<body>
    <a href="#main" id="top" class="visuallyhidden">Skip Navigation</a>
    <?php
        $header_data = SiteThemeComponents\Shared\Header::get_data();
        site_theme_render( 'templates/content', 'header', $header_data );
