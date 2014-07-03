<?php
Header("content-type: application/x-javascript");
// Call WP Load
$wp_include = "../wp-load.php";
$i = 0;
while (!file_exists($wp_include) && $i++ < 10) {
    $wp_include = "../$wp_include";
} require
($wp_include);
?>
var purethemeurl = '<?php echo get_template_directory_uri(); ?>';