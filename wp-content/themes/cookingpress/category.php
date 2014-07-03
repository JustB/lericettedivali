<?php
/**
 * The template for displaying Category Archive pages.
 * @package WordPress
 */
get_header();

?>

<h2 class="template-subtitle">
    <span>
        <?php printf( __( 'Category Archives: %s', 'purepress' ), '' . single_cat_title( '', false ) . '' ); ?>
    </span>
</h2>
<?php
//$category_description = category_description();
//if ( ! empty( $category_description ) )
//    echo '' . $category_description . '';

get_template_part( 'loop' );?>
<div id="primary">
    <?php echo get_sidebar(); ?></div>
</div>

<?php get_footer(); ?>