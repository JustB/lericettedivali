<?php
/**
 * The main template file.
 * @package WordPress
 */
get_header(); ?>
<?php $layout_type = get_option(PPTNAME.'_homepost_type'); ?>
<?php get_template_part( 'loop', $layout_type );?>

<div id="primary">
<?php echo get_sidebar(); ?></div>
</div>

<?php get_footer(); ?>