<?php

require_once dirname( __FILE__ ) . '/includes/theme-config.php';
require_once dirname( __FILE__ ) . '/vendor/autoload.php';

/** Returns Theme Directory Path */
function site_theme_path () {
    return get_template_directory(__FILE__);
}

/**
 * Autoloader for classes
 *
 * @param string $className Name of the class that shall be loaded
 */
function site_theme_autoload ($className) {

    $filepath = site_theme_path() . '/' . str_replace('\\', '/', $className) . '.php';

    if (file_exists($filepath))
        require_once($filepath);
}

spl_autoload_register('site_theme_autoload');

/**
 *
 * @param String $path Path to template
 * @param Array $data Array containing all the data to be rendered. Should not have numeric keys.
 * @param type $echo  To echo the html or to return it as a string
 * @return mixed string containing html if echo is false and will print the content if echo is true.
 * @since 0.1.0
 */
function site_theme_render( $slug, $name = null, $data = array(), $var_name = 'data', $echo = true ) {
    global $wp_query;

    $wp_query->query_vars[ $var_name ] = (object) $data;
    ob_start();
    get_template_part( $slug, $name );

    $out = ob_get_clean();
    if( $echo === true ) {
        echo $out;
    } else {
        return $out;
    }
}

function site_get_assets_url() {
    return THEME_URL . '/assets';
}

/**
 * Enqueue styles and scripts conditionally.
 * @since 0.1.0
 */
if( !function_exists( 'enqueue_site_styles_and_scripts' ) ):

	function enqueue_site_styles_and_scripts() {
	  
	    //header styles and scripts scripts
	    wp_enqueue_style( 'site_main', ASSETS_URL . '/styles/main.css' );
	    wp_enqueue_script( 'site_jquery', ASSETS_URL . '/scripts/vendor/jquery.js', array(), false, false );

	    // //footer scripts
	    wp_enqueue_script( 'site_main', ASSETS_URL . '/scripts/main.js', array(), false, true );
	}

endif;

add_action( 'wp_enqueue_scripts', 'enqueue_site_styles_and_scripts' );

if( !function_exists( 'enqueue_admin_script' ) ):

    function enqueue_admin_script($hook) {
        wp_enqueue_script( 'site_admin', THEME_URL . '/scripts/admin.js', array(), false, false );
    }

endif;

// TO ADD ASSETS
// add_action('admin_enqueue_scripts', 'enqueue_admin_script');

/**
 * Parses the html of given sidebar
 * 
 * @param string $sidebar
 * @return string
 * @since 0.1.0
 */
function site_parse_sidebar( $sidebar ) {

    $html = '';

    if( is_active_sidebar( $sidebar ) ) {
      ob_start();
		  dynamic_sidebar( $sidebar );
		  $html = ob_get_clean();
    }

    return $html;
}

add_filter( 'style_loader_src',  'sdt_remove_ver_css_js', 9999, 2 );
add_filter( 'script_loader_src', 'sdt_remove_ver_css_js', 9999, 2 );

function sdt_remove_ver_css_js( $src, $handle ) 
{
    $handles_with_version = array( 'style' ); // <-- Adjust to your needs!

    if ( strpos( $src, 'ver=' ) && ! in_array( $handle, $handles_with_version, true ) )
        $src = remove_query_arg( 'ver', $src );

    return $src;
}

/* Automatically set the image Title, Alt-Text, Caption & Description upon upload
--------------------------------------------------------------------------------------*/
function my_set_image_meta_upon_image_upload( $post_ID ) {

  // Check if uploaded file is an image, else do nothing

  if ( wp_attachment_is_image( $post_ID ) ) {

    $my_image_title = get_post( $post_ID )->post_title;

    // Sanitize the title:  remove hyphens, underscores & extra spaces:
    $my_image_title = preg_replace( '%\s*[-_\s]+\s*%', ' ',  $my_image_title );

    // Sanitize the title:  capitalize first letter of every word (other letters lower case):
    $my_image_title = ucwords( strtolower( $my_image_title ) );

    // Create an array with the image meta (Title, Caption, Description) to be updated
    // Note:  comment out the Excerpt/Caption or Content/Description lines if not needed
    $my_image_meta = array(
        'ID'        => $post_ID,            // Specify the image (ID) to be updated
        'post_title'    => $my_image_title,     // Set image Title to sanitized title
        'post_excerpt'  => $my_image_title,     // Set image Caption (Excerpt) to sanitized title
        'post_content'  => $my_image_title,     // Set image Description (Content) to sanitized title
    );

    // Set the image Alt-Text
    update_post_meta( $post_ID, '_wp_attachment_image_alt', $my_image_title );

    // Set the image meta (e.g. Title, Excerpt, Content)
    wp_update_post( $my_image_meta );

  } 
}
add_action( 'add_attachment', 'my_set_image_meta_upon_image_upload' );


// Add SVG Mime Type
function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

// To register fields from ACF if needed
// add_action( 'init', array( '\\SiteThemeComponents\\Pages\\Homepage', 'register_fields' ) );
// add_action( 'init', array( '\\SiteThemeComponents\\Pages\\Standard', 'register_fields' ) );
