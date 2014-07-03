<?php

/**
 * General purepress framework functions
 *
 * @package WordPress
 * @subpackage CookingPress
 * @since CookingPress 1.0
 */
function get_option_page_ID($page_title = '') {
    global $wpdb;
    return $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_title = '{$page_title}' AND post_type = 'purepress-data' AND post_status != 'trash'");
}

/**
 * Register custom post type & create two posts for storing
 * theme ralated data, like images for logo etc.
 * Solution from option tree plugin
 */
function create_option_post() {
    register_post_type('purepress-data', array(
            'labels' => array('name' => __('Options', 'purepress')),
            'public' => true,
            'show_ui' => false,
            'capability_type' => 'post',
            'exclude_from_search' => true,
            'hierarchical' => false,
            'rewrite' => false,
            'supports' => array('title', 'editor'),
            'can_export' => true,
            'show_in_nav_menus' => false,
    ));
    // look for custom page
    $page_id = get_option_page_ID('purepress-data');
    // no page? create it
    if (!$page_id) {
        // create post object
        $_p = array();
        $_p['post_title'] = 'purepress-data';
        $_p['post_status'] = 'private';
        $_p['post_type'] = 'purepress-data';
        $_p['comment_status'] = 'closed';
        $_p['ping_status'] = 'closed';

        // insert the post into the database
        $page_id = wp_insert_post($_p);
    }
}

add_action('admin_init', 'create_option_post', 5);


/*
 * checking page to avoid functions conflict on save
*/
if (isset($_GET['page'])) {
    if ($_GET['page'] == 'slidermanager') {
        add_action('admin_menu', 'purepress_manager_admin_menu');
    }
    if ($_GET['page'] == 'sidebarmanager') {
        add_action('admin_menu', 'sbmanager_admin_menu');
    }
    if ($_GET['page'] == 'purepress-core.php') {
        add_action('admin_menu', 'purepress_admin_menu');
    }
}



function get_tag_id_by_name($tag_name) {
    global $wpdb;
    $tag_ID = $wpdb->get_var("SELECT * FROM ".$wpdb->terms." WHERE `name` = '".$tag_name."'");

    return $tag_ID;
}
/*
 * Fallback for wp_menu
*/

function purepress_nav_fallback() {
    wp_page_menu('menu_class=menu');
}

function add_menuclass($ulclass) {
    return preg_replace('/<ul>/', '<ul class="menu">', $ulclass, 1);
}

add_filter('wp_page_menu', 'add_menuclass');

function showRating($id, $css_class = 'post-ratings') {
    global $wpdb;
    $path = plugins_url('wp-postratings/images/'.get_option('postratings_image'));
    $rating = $wpdb->get_var("SELECT AVG(rating_rating) AS rating FROM $wpdb->ratings WHERE rating_postid = $id");
    $i = 0;
    $html = '
		<span class="'.$css_class.'">';
    if (!empty($rating)) {
        while ($i < floor($rating)) {
            $html .= '
			<img src="'.$path.'/rating_on.gif" alt="" />';
            $i++;
        }
        if (round($rating, 1) == ($i+0.5)) {
            $html .= '
			<img src="'.$path.'/rating_half.gif" alt="" />';
            $i++;
        }
    }
    while ($i < 5) {
        $html .= '
		<img src="'.$path.'/rating_off.gif" alt="" />';
        $i++;
    }
    $html .= '
		</span>';
    return $html;
}

/*
 * Add searchbox to menu
*/

function add_search_box($items, $args) {
    ob_start();
    get_search_form();
    $searchform = ob_get_contents();
    ob_end_clean();
    if ($args->topmenu == 'Top Menu')
        $items .= '<li>' . $searchform . '</li>';

    return $items;
}
//add_filter('wp_nav_menu_items', 'add_search_box', 10, 2);

/*
 * Add prettyphoto support for [gallery] shortcode
*/


add_filter('the_content', 'addlightboxrel_replace', 12);
add_filter('get_comment_text', 'addlightboxrel_replace');

function addlightboxrel_replace($content) {
    global $post;
    $pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
    $replacement = '<a$1href=$2$3.$4$5 rel="prettyPhoto[slides]"$6>$7</a>';
    $content = preg_replace($pattern, $replacement, $content);
    return $content;
}


function has_thumb_class($classes) {
    global $post;
    if( has_post_thumbnail($post->ID) ) {
        $classes[] = 'has-thumb';
    } else {
        $classes[] = 'no-thumb';
    }
    return $classes;
}
add_filter('post_class', 'has_thumb_class');


function alltags_select($id,$def) {
    
    $tags = get_terms( 'post_tag',  array( 'orderby' => 'count', 'order' => 'DESC' ) ); // Always query top tags
    $html = '<select data-placeholder="Choose ingredients..." id="'.$id.'" name="'.$id.'[]" class="multiselect" multiple="true"  style="width:400px">';

    foreach ($tags as $tag) {
        $tag_link = get_tag_link($tag->term_id);
        $html .= '<option value="'.$tag->slug.'"';
        if($def) {
            if (in_array($tag->slug, $def)) {
            $html .= ' selected="selected" ';
            }
        }

        $html .= ">{$tag->name}</option>";
    }
    
    $html .= '</select>';
    return $html;


}

class Walker_Nav_Menu_Dropdown extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth) {
        $indent = str_repeat("\t", $depth); // don't output children opening tag (`<ul>`)
    }

    function end_lvl(&$output, $depth) {
        $indent = str_repeat("\t", $depth); // don't output children closing tag
    }

    function start_el(&$output, $item, $depth, $args) {
        // add spacing to the title based on the depth
        $item->title = str_repeat("&nbsp;", $depth * 4).$item->title;

        parent::start_el(&$output, $item, $depth, $args);

        // no point redefining this method too, we just replace the li tag...
        $output = str_replace('<li', '<option value="' . $item->url . '"', $output);
    }

    function end_el(&$output, $item, $depth) {
        $output .= "</option>\n"; // replace closing </li> with the option tag
    }
}


/*
 * Load CSS with selected colour scheme
*/

function colour_theme() {
    $scheme = get_option(PPTNAME . '_color_scheme');
    $scheme = strtolower($scheme);
    echo '<link rel="stylesheet"  id="change" href="';
    echo get_template_directory_uri();
    echo '/css/style-' . $scheme . '.css?v=2"/>';
}

/*
 * Get category ID from current page
*/

function getCurrentCatID() {
    if (is_category() || is_single()) {
        $category = end(get_the_category());
        $current = $category->cat_ID;
        $current_name = $category->cat_name;
    }
    return $current;
}

function get_next_post_id() {
    $adjacent_post = get_adjacent_post(false, '', false);
    return $adjacent_post->ID;
}

function get_previous_post_id() {
    $adjacent_post = get_adjacent_post(false, '', true);
    return $adjacent_post->ID;
}



/*
 * Generate post meta data based on user selection
*/

function purepress_postmeta() {
    $metadata = get_option(PPTNAME . '_postmeta');
    $level = get_the_term_list( $post->ID, 'level', ' ', ', ', '  ' );
    $time = get_the_term_list( $post->ID, 'timeneeded', ' ', ', ', '  ' );
    $serving =  get_the_term_list( $post->ID, 'serving', ' ', ', ', ' ' );
    $allergens =  get_the_term_list( $post->ID, 'allergen', ' ', ', ', ' ' );
    if (!empty($metadata)) {
        echo '<ul class="post-meta">';
        $id = get_the_ID();

        if (in_array("Ratings", $metadata)) {
            if(function_exists('the_ratings')) {
                echo "<li>";
                echo showRating($id);
                echo "</li>";
            }
        }
        if (in_array("Comments", $metadata)) {
            echo '<li class="comments">';
            comments_popup_link(
                    __('<span>0</span> ', 'purepress'), __('<span>1</span> ', 'purepress'), __('<span>%</span> ', 'purepress'));
            echo "</li>";
        }
        if (in_array("Author", $metadata)) {
            echo '<li class="author">';
            the_author_posts_link();
            echo "</li>";
        }


        if(!empty($time)) {
            if (in_array("Time", $metadata)) {
                echo '<li class="recipe-time">';
                echo $time;
                echo "</li>";
            }
        }
        if(!empty($serving)) {
            if (in_array("Servings", $metadata)) {
                echo '<li class="recipe-servings">';
                echo $serving;
                echo "</li>";
            }
        }
        if(!empty($level)) {
            if (in_array("Level", $metadata)) {
                echo '<li class="recipe-level">';
                echo '<em>Level:</em> '.$level;
                echo "</li>";
            }
        }
        if(!empty($allergens)) {
            if (in_array("Allergens", $metadata)) {
                echo '<li class="recipe-allergens">';
                echo '<em>Food Allergens:</em> '.$allergens;
                echo "</li>";
            }
        }
        if (in_array("Categories", $metadata)) {
            echo '<li class="cats"><span>In:</span> ';
            the_category(', ');
            echo "</li>";
        }
        echo '</ul>';
    }
}

function purepress_single_postmeta() {
    $metadata = get_option(PPTNAME . '_single_postmeta');
    if (!empty($metadata)) {
        echo '<ul class="post-meta">';

        if (in_array("Date", $metadata)) {

            printf(__('<li class="date"><span>On:</span> <a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a></li>', 'purepress'), esc_url(get_permalink()), esc_attr(get_the_time()), esc_attr(get_the_date('c')), esc_html(get_the_date()));
        }
        if (in_array("Author", $metadata)) {
            echo '<li class="author"><span>By:</span> ';
            the_author_posts_link();
            echo "</li>";
        }

        if (in_array("Categories", $metadata)) {
            echo '<li class="cats"><span>In:</span> ';
            the_category(', ');
            echo "</li>";
        }
        if (in_array("Tags", $metadata)) {
            if (has_tag()) {
                echo "<li class=\"tags\"><span>Tags:</span> ";
                the_tags(' Tagged with:  ', ',  ', ' ');
                echo "</li>";
            }
        }

        if (in_array("Comments", $metadata)) {
            echo '<li class="comments">';
            comments_popup_link(
                    __('<span>No Comments.</span> ', 'purepress'), __('<span>1 Comment</span> ', 'purepress'), __('<span>Comments (%)</span> ', 'purepress'));
            echo "</li>";
        }

        echo '</ul>';
    }
}
function recipe_meta_info() {
    $level = get_the_term_list( $post->ID, 'level', ' ', ', ', '  ' );
    $time = get_the_term_list( $post->ID, 'timeneeded', ' ', ', ', '  ' );
    $serving =  get_the_term_list( $post->ID, 'serving', ' ', ', ', ' ' );
    if(!empty($level) && !empty($time) && !empty($serving))
        $output = '<ul class="recipe-meta">';
    if(!empty($level)) $output .= '<li id="recipe-level"><em>'.__("Level", 'purepress').':</em> '.$level.'</li>';
    if(!empty($time)) $output .= '<li id="recipe-time"> '.$time.'</li>';
    if(!empty($serving)) $output .= '<li  id="recipe-servings">'.$serving.'</li>';
    $output .= '</ul>';

    return $output;
}
/*
 * Generate post meta on blog page data based on user selection
*/



/**
 * dodaje do body klase o nazwie adresu strony, lub strony nadrzednej jesli wyswietlamy podrzedną
 * */
function body_sidebar_class($classes) {
    $layout = get_option(PPTNAME . '_sidebar_position');
    $classes[] = $layout;
    return $classes;
}

add_filter('body_class', 'body_sidebar_class');


/*
 * Resize images dynamically using wp built in functions
 * Victor Teixeira
 *
 * php 5.2+
 *
 * Exemplo de uso:
 *
 * <?php
 * $thumb = get_post_thumbnail_id();
 * $image = vt_resize( $thumb, '', 140, 110, true );
 * ?>
 * <img src="<?php echo $image[url]; ?>" width="<?php echo $image[width]; ?>" height="<?php echo $image[height]; ?>" />
 *
 * @param int $attach_id
 * @param string $img_url
 * @param int $width
 * @param int $height
 * @param bool $crop
 * @return array
*/

function vt_resize($attach_id = null, $img_url = null, $width, $height, $crop = false) {

    // this is an attachment, so we have the ID
    if ($attach_id) {

        $image_src = wp_get_attachment_image_src($attach_id, 'full');
        $file_path = get_attached_file($attach_id);

        // this is not an attachment, let's use the image url
    } else if ($img_url) {

        $file_path = parse_url($img_url);
        $file_path = $_SERVER['DOCUMENT_ROOT'] . $file_path['path'];

        //$file_path = ltrim( $file_path['path'], '/' );
        //$file_path = rtrim( ABSPATH, '/' ).$file_path['path'];

        $orig_size = getimagesize($file_path);

        $image_src[0] = $img_url;
        $image_src[1] = $orig_size[0];
        $image_src[2] = $orig_size[1];
    }

    $file_info = pathinfo($file_path);
    $extension = '.' . $file_info['extension'];

    // the image path without the extension
    $no_ext_path = $file_info['dirname'] . '/' . $file_info['filename'];

    $cropped_img_path = $no_ext_path . '-' . $width . 'x' . $height . $extension;

    // checking if the file size is larger than the target size
    // if it is smaller or the same size, stop right here and return
    if ($image_src[1] > $width || $image_src[2] > $height) {

        // the file is larger, check if the resized version already exists (for $crop = true but will also work for $crop = false if the sizes match)
        if (file_exists($cropped_img_path)) {

            $cropped_img_url = str_replace(basename($image_src[0]), basename($cropped_img_path), $image_src[0]);

            $vt_image = array(
                    'url' => $cropped_img_url,
                    'width' => $width,
                    'height' => $height
            );
            return $vt_image;
        }

        // $crop = false
        if ($crop == false) {

            // calculate the size proportionaly
            $proportional_size = wp_constrain_dimensions($image_src[1], $image_src[2], $width, $height);
            $resized_img_path = $no_ext_path . '-' . $proportional_size[0] . 'x' . $proportional_size[1] . $extension;

            // checking if the file already exists
            if (file_exists($resized_img_path)) {

                $resized_img_url = str_replace(basename($image_src[0]), basename($resized_img_path), $image_src[0]);

                $vt_image = array(
                        'url' => $resized_img_url,
                        'width' => $proportional_size[0],
                        'height' => $proportional_size[1]
                );

                return $vt_image;
            }
        }

        // no cache files - let's finally resize it
        $new_img_path = image_resize($file_path, $width, $height, $crop);
        $new_img_size = getimagesize($new_img_path);
        $new_img = str_replace(basename($image_src[0]), basename($new_img_path), $image_src[0]);

        // resized output
        $vt_image = array(
                'url' => $new_img,
                'width' => $new_img_size[0],
                'height' => $new_img_size[1]
        );


        return $vt_image;
    }

    // default output - without resizing
    $vt_image = array(
            'url' => $image_src[0],
            'width' => $image_src[1],
            'height' => $image_src[2]
    );

    return $vt_image;
}






/*
 * Count number of active photos added to post
*/

function gallery_count($id, $exclude) {
    global $post, $wp_locale;
    static $instance = 0;
    $instance++;
    $id = intval($id);
    $order = '';
    $orderby = '';
    if (!empty($exclude)) {
        $exclude = preg_replace('/[^0-9,]+/', '', $exclude);
        $attachments = get_children(array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
    } else {
        $attachments = get_children(array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
    }

    if (empty($attachments))
        return '';
    return sizeof($attachments);
}

/*
 * Get first photo from attachments
*/

function get_first_image($id, $order, $exclude) {
    $args = array(
            'post_type' => 'attachment',
            'order' => 'ASC',
            'post_mime_type' => 'image',
            'numberposts' => 1,
            'post_status' => null,
            'post_parent' => $id,
            'exclude' => $exclude
    );
    $attachments = get_posts($args);

    if ($attachments) {
        foreach ($attachments as $attachment) {
            $img_url = wp_get_attachment_url($attachment->ID, 'slider-big');
            echo '<img src="' . $img_url . '" style="position:static; display:block; margin:0px auto"/>';
        }
    }
}

/*
 * Get URL of first photo from attachments
*/

function get_first_image_url($id, $order, $exclude) {
    $args = array(
            'post_type' => 'attachment',
            'order' => 'ASC',
            'post_mime_type' => 'image',
            'numberposts' => 1,
            'post_status' => null,
            'post_parent' => $id,
            'exclude' => $exclude
    );
    $attachments = get_posts($args);

    if ($attachments) {
        foreach ($attachments as $attachment) {
            $img_url = wp_get_attachment_url($attachment->ID, 'slider-big');
            return $img_url;
        }
    }
}

function get_prev_image_url($prev = true, $size = 'thumbnail') {
    global $post;
    $post = get_post($post);
    $attachments = array_values(get_children(array('post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID')));

    foreach ($attachments as $k => $attachment)
        if ($attachment->ID == $post->ID)
            break;

    $k = $prev ? $k - 1 : $k + 1;

    if (isset($attachments[$k]))
        return wp_get_attachment_url($attachments[$k]->ID, 'thumbnail');
}

/*
 * Get all icons
*/


/*
 * Get sidebars list for post metaboxes
*/

function get_sidebars() {
    $result = array();
    $result["Sidebar Area"] = "Sidebar Area";

    $pp_sidebars = get_option('pp_sidebars');
    if ($pp_sidebars) {
        foreach ($pp_sidebars as $k => $pp_sidebar) {
            $result[$pp_sidebar["name"]] = $pp_sidebar["name"];
        }
    }
    return $result;
}

$customsidebars = get_sidebars();

function my_wp_nav_menu_args($args = '') {
    $args['container'] = false;
    return $args;
}

// function
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args');





/*
 * Exif data
*/

function insert_exif($imgid) {
    $imgmeta = wp_get_attachment_metadata($imgid);
    if (!empty($imgmeta['image_meta']['camera'])) {


        echo "<div class='exif-data'><ul class='exif'>";
        if (!empty($imgmeta['image_meta']['aperture']))
            echo "<li><span>Aperture:</span> f/" . $imgmeta['image_meta']['aperture'] . "</li>";
        if (!empty($imgmeta['image_meta']['iso']))
            echo "<li><span>ISO:</span> " . $imgmeta['image_meta']['iso'] . "</li>";

        if (!empty($imgmeta['image_meta']['shutter_speed'])) {
            echo "<li><span>Shutter Speed:</span> ";
            if ((1 / $imgmeta['image_meta']['shutter_speed']) > 1) {
                echo "1/";
                if ((number_format((1 / $imgmeta['image_meta']['shutter_speed']), 1)) == 1.3
                        or number_format((1 / $imgmeta['image_meta']['shutter_speed']), 1) == 1.5
                        or number_format((1 / $imgmeta['image_meta']['shutter_speed']), 1) == 1.6
                        or number_format((1 / $imgmeta['image_meta']['shutter_speed']), 1) == 2.5) {
                    echo number_format((1 / $imgmeta['image_meta']['shutter_speed']), 1, '.', '') . " s</li>";
                } else {
                    echo number_format((1 / $imgmeta['image_meta']['shutter_speed']), 0, '.', '') . " s</li>";
                }
            } else {
                echo $imgmeta['image_meta']['shutter_speed'] . " s</li>";
            }
        }
        if (!empty($imgmeta['image_meta']['focal_length']))
            echo "<li><span>Focal Length:</span> " . $imgmeta['image_meta']['focal_length'] . "mm</li>";
        if (!empty($imgmeta['image_meta']['camera']))
            echo "<li><span>Camera:</span> " . $imgmeta['image_meta']['camera'] . "</li>";
        echo "</ul> </div>";
    }
}






/*
 * Custom comments 
*/

function purepress_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    switch ($comment->comment_type) :
        case '' :
            ?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
<article id="comment-<?php comment_ID(); ?>">
    <div class="comment-body">
                    <?php if ($comment->comment_approved == '0') : ?>
        <em><?php _e('Your comment is awaiting moderation.', 'boilerplate'); ?></em>
                    <?php endif; ?>
                    <?php comment_text(); ?>
                    <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
    </div>
    <div class="comment-author vcard">
                    <?php echo get_avatar($comment, 60); ?>
                    <?php printf(__('%s <span class="says">says:</span>', 'boilerplate'), sprintf('<cite class="fn">%s</cite>', get_comment_author_link())); ?>
        <a class="comment-date" href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
                        <?php
                        /* translators: 1: date, 2: time */
                        printf(__('%1$s at %2$s', 'boilerplate'), get_comment_date(), get_comment_time());
                        ?></a><?php edit_comment_link(__('(Edit)', 'boilerplate'), ' ');
                    ?>
    </div><!-- .comment-author .vcard -->
</article><!-- #comment-##  -->
            <?php
            break;
        case 'pingback' :
        case 'trackback' :
            ?>
<li class="post pingback">
    <p><?php _e('Pingback:', 'boilerplate'); ?> <?php comment_author_link(); ?><?php edit_comment_link(__('(Edit)', 'boilerplate'), ' '); ?></p>
                <?php
                break;
            endswitch;
    }

    /*
 * Design functions
    */

    function purepress_home_posted_on() {
        printf('<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a> / ', get_permalink(), esc_attr(get_the_time()), get_the_date()
        );
        printf(' <span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span> / ', get_author_posts_url(get_the_author_meta('ID')), sprintf(esc_attr__('View all posts by %s', 'boilerplate'), get_the_author()), get_the_author()
        );
    }

    /**
     * Limits words of excerpt
     * */
    function limit_words($string, $word_limit) {
        $words = explode(' ', $string);
        return implode(' ', array_slice($words, 0, $word_limit));
    }

    /**
     * Change [...] of excerpt
     * */
    function new_excerpt_more($more) {
        return '...';
    }

    add_filter('excerpt_more', 'new_excerpt_more');


    /*
 * Custom form for protected posts
    */

    function custom_password_form() {
        global $post;
        $label = 'pwbox-' . ( empty($post->ID) ? rand() : $post->ID );
        $o = '<form class="protected-post-form" action="' . get_option('siteurl') . '/wp-pass.php" method="post">' . __("This post is password protected. To view it please enter your password below:", 'purethemes') . '<br/><br/><input name="post_password" id="' . $label . '" class="pwbox" type="password" size="20" /><input id="submit-btn" type="submit" name="Submit" value="' . esc_attr__("Submit") . '" />
    </form>
    ';
        return $o;
    }

    add_filter('the_password_form', 'custom_password_form');


    function upload_image_tag($term) { ?>
<tr class="form-field">
    <th scope="row" valign="top"><label for="category_theme"><?php _e('Image') ?></label></th>
    <td> <?php  $tag_photo = get_option('cookingpress_tags_meta'); ?>
        <a href="javascript:void(0);" class="upload-image button-secondary" >Upload</a> <a href="#" class="remove-image">Remove image</a>
            <?php // if ($tag_photo[$term->term_id]['photopath']) {?>
        <img id="tag-image" src="<?php echo $tag_photo[$term->term_id]['photopath']; ?>" style="max-width: 800px; height: auto; display: block; padding: 10px; border: 1px solid rgb(221, 221, 221); margin: 10px 0px;" >
            <?php // } ?>
        <input name='tag_image' id='tag_image' value="<?php echo $tag_photo[$term->term_id]['photopath']; ?>" type="hidden"/>
    </td>
</tr>
    <?php
}
add_action ( 'edit_tag_form_fields', 'upload_image_tag');


function get_term_photo() {
        $term = get_queried_object();
        $term = $term->term_id;
        $tag_photo = get_option('cookingpress_tags_meta');
//      echo '<pre>';print_r($tag_photo[166]['photopath']);echo '</pre>';
        if($tag_photo[$term]['photopath']) {
            $image = '<img src='.$tag_photo[$term]['photopath'].' class="tag-image"/>';
            return $image;
        } else {
            return false;
        }
}
function get_term_photo_by_id($id) {
        $tag_photo = get_option('cookingpress_tags_meta');
        if($tag_photo[$id]['photopath']) {
            $image = '<img src='.$tag_photo[$id]['photopath'].' class="tag-image"/>';
            return $image;
        } else {
            return false;
        }
}

function save_tag_photo($term_id) {
    if (!$term_id) return;
    $tag_photo = get_option('cookingpress_tags_meta');
    if (isset($_POST['tag_image'])) {
        $tag_photo[$term_id]['photopath'] = $_POST['tag_image'];

        update_option('cookingpress_tags_meta', $tag_photo);
    }
}
add_action( 'edit_term', 'save_tag_photo', 10, 3 );

if (is_admin() && $pagenow == 'edit-tags.php') {
    wp_enqueue_script(
            'tag-upload',
            get_template_directory_uri() . '/backend/js/tag_upload.js',
            array('jquery', 'thickbox', 'media-upload'),
            time(),
            true
    );
    wp_enqueue_style('thickbox');
}

/*
 * Puregallery ajax
*/
add_action('wp_ajax_nopriv_get_photos', 'get_photos_callback');
add_action('wp_ajax_get_photos', 'get_photos_callback');

function get_photos_callback() {
    global $wpdb; // this is how you get access to the database
    $postID = $_POST['whatever'];
    $postID = trim($postID, 'post-');
    $orderby = get_post_meta($postID, $shortname."galleryorder_value", $single = true);
    $order = get_post_meta($postID, $shortname."galleryorderby_value", $single = true);
    $id = $postID;
    $include = '';
    $exclude = get_post_meta($postID, $shortname."galleryexlude_value", $single = true);

    echo puregallery_ajax($orderby, $order, $id, $include, $exclude);


    die(); // this is required to return a proper result
}

/*
 * loadphoto ajax
*/
add_action('wp_ajax_nopriv_get_feat_photo', 'get_feat_photo_callback');
add_action('wp_ajax_get_feat_photo', 'get_feat_photo_callback');

function get_feat_photo_callback($id) {

    $id = $_POST['id'];
    echo wp_get_attachment_image($id,'recipe-thumb');

    die(); // this is required to return a proper result
}




// drop down menu for search
function dropdown_search($taxonomy, $args, $def ) {
	$defaults = array('taxonomy' => $taxonomy, // <- write taxonomy name
		'smallest' => 8, 'largest' => 22, 'unit' => 'pt', 'number' => 45,
		'format' => 'flat', 'orderby' => 'name', 'order' => 'ASC',
		'exclude' => '', 'include' => ''
	);
	$args = wp_parse_args( $args, $defaults );

	$terms = get_terms($taxonomy, array_merge($args, array('orderby' => 'count', 'order' => 'DESC')) ); // Always query top tags

	if ( empty($terms) )
		return;

	$return = generate_dropdown_search( $terms, $taxonomy, $args, $def ); // Here's where those top tags get sorted according to $args
	if ( is_wp_error( $return ) )
		return false;
	else
		echo apply_filters( 'dropdown_search', $return, $args );
}

function generate_dropdown_search( $terms, $taxonomy, $args, $def ) {
	global $wp_rewrite;
	$defaults = array(
		 'orderby' => 'name', 'order' => 'ASC'
	);
	$args = wp_parse_args( $args, $defaults );
	extract($args);

	if ( !$terms )
		return;
	$counts = $term_links = $term_slugs = array();
	foreach ( (array) $terms as $term ) {
		$counts[$term->name] = $term->count;
		$term_links[$term->name] = get_term_link( $term->name, $taxonomy );
		$term_slugs[$term->name] = $term->slug;
		if ( is_wp_error( $term_links[$term->name] ) )
			return $term_links[$term->name];
		$term_ids[$term->name] = $term->term_id;
	}

	$min_count = min($counts);
	$spread = max($counts) - $min_count;
	if ( $spread <= 0 )
		$spread = 1;
	$font_spread = $largest - $smallest;
	if ( $font_spread <= 0 )
		$font_spread = 1;
	$font_step = $font_spread / $spread;

	// SQL cannot save you; this is a second (potentially different) sort on a subset of data.
	if ( 'name' == $orderby )
		uksort($counts, 'strnatcasecmp');
	else
		asort($counts);

	if ( 'DESC' == $order )
		$counts = array_reverse( $counts, true );

	$a = array();

	$rel = ( is_object($wp_rewrite) && $wp_rewrite->using_permalinks() ) ? ' rel="term"' : '';

	foreach ( $counts as $term => $count ) {
		$term_id = $term_ids[$term];
		$term_link = clean_url($term_links[$term]);
		$term_slug = $term_slugs[$term];
		$term = str_replace(' ', '&nbsp;', wp_specialchars( $term ));

                
                if(is_array($def) && in_array( $term_slug, $def)) {  
                    $a[] = "\t<option selected=\"selected\" value='$term_slug'>$term ($count)</option>";
                    }
                else if($def == $term_slug) {
                    $a[] = "\t<option selected=\"selected\" value='$term_slug'>$term ($count)</option>";
                } else {
                    $a[] = "\t<option value='$term_slug'>$term ($count)</option>";
                }
	}

	switch ( $format ) :
	case 'array' :
		$return =& $a;
		break;
	case 'list' :
		$return = "<ul class='wp-tag-cloud'>\n\t<li>";
		$return .= join("</li>\n\t<li>", $a);
		$return .= "</li>\n</ul>\n";
		break;
	default :
		$return = join("\n", $a);
		break;
	endswitch;

	return apply_filters( 'generate_dropdown_search', $return, $term, $args );
}




?>