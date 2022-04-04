<?php

/**
 * The template for displaying the footer
 *
 * @package WordPress
 * @subpackage Site
 * @since 0.1.0
 */
?>
<?php
        $footer_data = SiteThemeComponents\Shared\Footer::get_data();
        site_theme_render( 'templates/content', 'footer', $footer_data );
        wp_footer(); 
?>
</body>
</html>