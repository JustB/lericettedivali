<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage purepress
 * @since purepress 1.0
 */

get_header();

?>

<h2 class="template-subtitle">
    <span><?php printf( __( 'Search Results for: %s', 'purepress' ), '' . get_search_query() . '' ); ?>
    </span>
</h2>


<?php
get_template_part( 'loop', 'search' );?>


<div id="primary">
    <?php echo get_sidebar(); ?></div>
</div>

<?php get_footer(); ?>

