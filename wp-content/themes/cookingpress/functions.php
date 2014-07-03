<?php
/**
 * Functions
 *
 * @package WordPress
 * @subpackage CookingPress
 * @since CookingPress 1.0
 */
//error_reporting(E_ALL);
//ini_set('display_errors', '1');


$themename = "CookingPress";
$shortname = "cookingpress";
define('PPTNAME', $shortname);
$templateurl = get_template_directory_uri() ;


add_action( 'init', 'build_taxonomies', 0 );
/** 
 * include backend files, better don't touch this ;)
 **/
require_once ('backend/purepress-functions.php'); // Custom functions and plugins
require_once ('backend/purepress-core.php'); // Admin Interface!
require_once ('backend/purepress-options.php'); // Options!
require_once ('backend/purepress-sidebars.php'); // Sidebars
require_once ('backend/purepress-widgets.php'); // Widgets
require_once ('backend/purepress-shortcodes.php'); // Widgets
require_once ('backend/purepress-metaboxes.php'); // Post metaboxes
require_once ('backend/purepress-dynjs.php'); // AJAX functions
require_once ('backend/sidebars.php'); // Unlimited sidebars generator
require_once ('backend/slider.php'); // Unlimited sidebars generator
require_once ('backend/tinymce.php'); // TinyMce support for shortcodes



function anonpost_media_upload_tabs( $tabs ) {
        if(current_user_can('author')){ 

            unset( $tabs['gallery'] );
            unset( $tabs['library'] );
        }
        return $tabs;
}
add_filter('media_upload_tabs','anonpost_media_upload_tabs');

// allow for empty search word
add_filter( 'request', 'my_request_filter' );
function my_request_filter( $query_vars ) {
    if( isset( $_GET['s'] ) && empty( $_GET['s'] ) ) {
        $query_vars['s'] = " ";
    }
    return $query_vars;
}


/**
 *
 * @global <type> $GLOBALS['allowedposttags']
 * @name $allowedposttags
 */
$allowedposttags["span"] = array(
        "itemscope" => array(),
        "itemprop" => array(),
        "content" => array(),
        "itemtype" => array()
);

$allowedposttags["div"] = array(
        "itemscope" => array(),
        "itemprop" => array(),
        "content" => array(),
        "itemtype" => array()
);

/**
 * Add to extended_valid_elements for TinyMCE
 *
 * @param $init assoc. array of TinyMCE options
 * @return $init the changed assoc. array
 */
function change_mce_options( $init ) {
    //code that adds additional attributes to the pre tag
    $ext = 'div[itemscope|itemprop|content|itemtype],span[itemscope|itemprop|content|itemtype],meta[itemscope|itemprop|content|itemtype]';

    //if extended_valid_elements alreay exists, add to it
    //otherwise, set the extended_valid_elements to $ext
    if ( isset( $init['extended_valid_elements'] ) ) {
        $init['extended_valid_elements'] .= ',' . $ext;
    } else {
        $init['extended_valid_elements'] = $ext;
    }

    //important: return $init!
    return $init;
}
//add_filter('tiny_mce_before_init', 'change_mce_options');



add_action( 'after_setup_theme', 'purepress_setup' );
if ( ! function_exists( 'purepress_setup' ) ):
    function purepress_setup() {

        // This theme styles the visual editor with editor-style.css to match the theme style.
        add_editor_style();

        // Add default posts and comments RSS feed links to head
        add_theme_support( 'automatic-feed-links' );

        // Make theme available for translation
        // Translations can be filed in the /languages/ directory
        load_theme_textdomain( 'purepress', TEMPLATEPATH . '/languages' );

        $locale = get_locale();
        $locale_file = TEMPLATEPATH . "/languages/$locale.php";
        if ( is_readable( $locale_file ) )
            require_once( $locale_file );

        // This theme uses wp_nav_menu() in one location.
        add_theme_support('menus');
        register_nav_menus( array(
                'topmenu' =>'Top Menu',
                'mobilemenu' =>'Mobile Menu'
                )
        );

        // This theme allows users to set a custom background
        add_custom_background();
}
endif;

/*
 * Add custom menu to WordPress panel
*/
if ( !function_exists( 'purepress_menus' ) ) {
    function purepress_menus() {
        // Add a new top-level menu
        add_menu_page(__('CookingPress','purepress'), __('CookingPress','purepress'), 'manage_options', 'purepress-core.php', 'purepress_admin', get_template_directory_uri().'/backend/images/icon.png' );
        add_submenu_page('purepress-core.php', 'Slider manager', 'Slider manager', 'manage_options', 'slidermanager', 'manager_wrap');
        add_submenu_page('purepress-core.php', 'Sidebars manager', 'Sidebars manager', 'manage_options', 'sidebarmanager', 'sbmanager_wrap');
    }
    add_action('admin_menu', 'purepress_menus');
}

// register your script location, dependencies and version



// responsive design & html5
wp_register_script('modernizr', get_template_directory_uri() . '/js/modernizr.js');
wp_register_script('respond', get_template_directory_uri() . '/js/respond.js');

wp_register_script('chosen', get_template_directory_uri() . '/js/chosen.jquery.min.js');

// slider scripts
wp_register_script('coda', get_template_directory_uri() . '/js/jquery.coda-slider-2.0.js');
wp_register_script('easing', get_template_directory_uri() . '/js/jquery.easing.1.3.js');

wp_register_script('flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js');
wp_register_script('prettyPhoto', get_template_directory_uri() . '/js/jquery.prettyPhoto.js');

wp_register_script('custom', get_template_directory_uri() . '/js/custom.js');
wp_register_script('single', get_template_directory_uri() . '/js/single-loader.js');


if ( !function_exists( 'pp_scripts' ) ) {
    function pp_scripts() {
        // enqueue js scripts for frontside
        wp_enqueue_script('easing');
        wp_enqueue_script('modernizr');
        wp_enqueue_script('respond');
        wp_enqueue_script('chosen');
        wp_enqueue_script('coda');
        wp_enqueue_script('flexslider');
        wp_enqueue_script('custom');
        wp_enqueue_script('customphp');
        wp_enqueue_script('prettyPhoto');
    }
    add_action( 'wp_enqueue_scripts', 'pp_scripts' );
}






if ( ! isset( $content_width ) ) $content_width = 1030;

$height = get_option(PPTNAME.'_slider_height' );
if($height=='460px' || empty($height)) {
    add_image_size('slider-big',770,460,true);
} else {
    add_image_size('slider-big',770,$height,true);
}
add_image_size('recipe-thumb',210,150, true);

/**
 * Post thumbnails setup
 */
add_theme_support('post-thumbnails');

set_post_thumbnail_size(340, 215, true); //size of thumbs


add_action('admin_menu', 'purepress_admin_menu'); //add menu

remove_action('wp_head', 'wp_generator'); //remove wp version info for security
add_filter('widget_text', 'do_shortcode'); // Make Widget Support Shortcode

add_custom_background(); 



/*
 * Fallback navigation for old versions of WordPress
*/
function pure_nav() {
    if ( function_exists( 'wp_nav_menu' ) )
        wp_nav_menu('menu_id=dropmenu&fallback_cb=pure_nav_fallback' );
    else
        pure_nav_fallback();
}

function pure_nav_fallback() {
    echo '<ul class="menu" id="dropmenu">';
    if (get_option('purephoto_menu_type') == 'Pages')
        wp_list_pages('title_li=');
    else
        wp_list_categories('title_li=');
    echo '</ul>';
}



//cooking press stuff

function build_taxonomies() {

    $labels = array(
            'name' => __( 'Time needed', 'purepress' ),
            'singular_name' => __( 'Time needed', 'purepress' ),
            'search_items' => __( 'Search Time needed', 'purepress' ),
            'popular_items' => __( 'Popular Time needed', 'purepress' ),
            'all_items' => __( 'All Time needed', 'purepress' ),
            'parent_item' => __( 'Parent Time needed', 'purepress' ),
            'parent_item_colon' => __( 'Parent Time needed:', 'purepress' ),
            'edit_item' => __( 'Edit Time needed', 'purepress' ),
            'update_item' => __( 'Update Time needed', 'purepress' ),
            'add_new_item' => __( 'Add New Time needed', 'purepress' ),
            'new_item_name' => __( 'New Time needed Name', 'purepress' ),
            'separate_items_with_commas' => __( 'Separate time needed with commas', 'purepress' ),
            'add_or_remove_items' => __( 'Add or remove time needed', 'purepress' ),
            'choose_from_most_used' => __( 'Choose from the most used time needed', 'purepress' ),
            'menu_name' => __( 'Time needed', 'time needed' ),
    );

    $args = array(
            'labels' => $labels,
            'public' => true,
            'show_in_nav_menus' => true,
            'show_ui' => true,
            'show_tagcloud' => true,
            'hierarchical' => true,
            'rewrite' => true,
            'query_var' => true
    );

    register_taxonomy( 'timeneeded', array('post'), $args );



    if (!taxonomy_exists('level')) {
        $labels = array(
                'name' => __( 'Levels', 'purepress' ),
                'singular_name' => __( 'Level', 'purepress' ),
                'search_items' => __( 'Search Levels', 'purepress' ),
                'popular_items' => __( 'Popular Levels', 'purepress' ),
                'all_items' => __( 'All Levels', 'purepress' ),
                'parent_item' => __( 'Parent Level', 'purepress' ),
                'parent_item_colon' => __( 'Parent Level:', 'purepress' ),
                'edit_item' => __( 'Edit Level', 'purepress' ),
                'update_item' => __( 'Update Level', 'purepress' ),
                'add_new_item' => __( 'Add New Level', 'purepress' ),
                'new_item_name' => __( 'New Level Name', 'purepress' ),
                'separate_items_with_commas' => __( 'Separate levels with commas', 'purepress' ),
                'add_or_remove_items' => __( 'Add or remove levels', 'purepress' ),
                'choose_from_most_used' => __( 'Choose from the most used levels', 'purepress' ),
                'menu_name' => __( 'Levels', 'level' ),
        );

        $args = array(
                'labels' => $labels,
                'public' => true,
                'show_in_nav_menus' => true,
                'show_ui' => true,
                'show_tagcloud' => true,
                'hierarchical' => false,

                'rewrite' => true,
                'query_var' => true
        );

        register_taxonomy( 'level', array('post'), $args );


    }

    $labels = array(
            'name' => __( 'Servings', 'purepress' ),
            'singular_name' => __( 'Serving', 'purepress' ),
            'search_items' => __( 'Search Servings', 'purepress' ),
            'popular_items' => __( 'Popular Servings', 'purepress' ),
            'all_items' => __( 'All Servings', 'purepress' ),
            'parent_item' => __( 'Parent Serving', 'purepress' ),
            'parent_item_colon' => __( 'Parent Serving:', 'purepress' ),
            'edit_item' => __( 'Edit Serving', 'purepress' ),
            'update_item' => __( 'Update Serving', 'purepress' ),
            'add_new_item' => __( 'Add New Serving', 'purepress' ),
            'new_item_name' => __( 'New Serving Name', 'purepress' ),
            'separate_items_with_commas' => __( 'Separate servings with commas', 'purepress' ),
            'add_or_remove_items' => __( 'Add or remove servings', 'purepress' ),
            'choose_from_most_used' => __( 'Choose from the most used servings', 'purepress' ),
            'menu_name' => __( 'Servings', 'purepress' ),
    );

    $args = array(
            'labels' => $labels,
            'public' => true,
            'show_in_nav_menus' => true,
            'show_ui' => true,
            'show_tagcloud' => true,
            'hierarchical' => false,
            'rewrite' => true,
            'query_var' => true
    );

    register_taxonomy( 'serving', array('post'), $args );



    $labels = array(
            'name' => __( 'Food Allergens', 'purepress' ),
            'singular_name' => __( 'Allergen', 'purepress' ),
            'search_items' => __( 'Search Allergens', 'purepress' ),
            'popular_items' => __( 'Popular Allergens', 'purepress' ),
            'all_items' => __( 'All Allergens', 'purepress' ),
            'parent_item' => __( 'Parent Allergen', 'purepress' ),
            'parent_item_colon' => __( 'Parent Allergen:', 'purepress' ),
            'edit_item' => __( 'Edit Allergen', 'purepress' ),
            'update_item' => __( 'Update Allergens', 'purepress' ),
            'add_new_item' => __( 'Add New Allergens', 'purepress' ),
            'new_item_name' => __( 'New Allergens Name', 'purepress' ),
            'separate_items_with_commas' => __( 'Separate allergens with commas', 'purepress' ),
            'add_or_remove_items' => __( 'Add or remove allergens', 'purepress' ),
            'choose_from_most_used' => __( 'Choose from the most used allergens', 'purepress' ),
            'menu_name' => __( 'Food Allergens', 'purepress' ),
    );

    $args = array(
             'labels' => $labels,
            'public' => true,
            'show_in_nav_menus' => true,
            'show_ui' => true,
            'show_tagcloud' => true,
            'hierarchical' => true,
            'rewrite' => true,
            'query_var' => true
    );

    register_taxonomy( 'allergen', array('post'), $args );


}

//add_action( 'init', 'unregister_taxonomy');
//function unregister_taxonomy() {
//    global $wp_taxonomies;
//    $taxonomy = 'timeneeded';
//    if ( taxonomy_exists( $taxonomy))
//        unset( $wp_taxonomies[$taxonomy]);
//}
?>