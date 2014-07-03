<?php
// Call WP Load
$wp_include = "../wp-load.php";
$i = 0;
while (!file_exists($wp_include) && $i++ < 10) {
    $wp_include = "../$wp_include";
} require
($wp_include);
if ( !is_user_logged_in() || !current_user_can('edit_posts') )
    wp_die(__("You are not allowed to be here","cloudfw"));

$id = $_GET['id'];

$attachments = get_children(
        array(
        'post_parent' => $id,
        'post_status' => 'inherit',
        'post_type' => 'attachment',
        'post_mime_type' => 'image',
        //'order' => $order,
        //'orderby' => $orderby
        )
);
if ( !empty($attachments) ) {
    echo '<ul id="gallery-exlude">';
     $output = '';
    foreach ( $attachments as $attach => $attachment ) {
        $thumb = wp_get_attachment_image($attach, 'slider-thumb', false);
        $output .= '<li id='.$attach.'>';
        $output .= $thumb;
        $output .= '</li>';
    }

    echo $output;
    echo '</ul>';
}?>