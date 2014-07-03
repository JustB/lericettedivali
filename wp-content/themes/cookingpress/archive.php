<?php
/**
 * The template for displaying Category Archive pages.
 * @package WordPress
 */
get_header();

?>

<h2 class="template-subtitle">
    <span>
        <?php
        if ( is_day() ) :
            printf( __( 'Daily Archives: %s', 'purepress' ), get_the_date() );
        elseif ( is_month() ) :
            printf( __( 'Monthly Archives: %s', 'purepress' ), get_the_date('F Y') );
        elseif ( is_year() ) :
            printf( __( 'Yearly Archives: %s', 'purepress' ), get_the_date('Y') );
        else :
            _e( 'Blog Archives', 'purepress' );
        endif;
        ?>
    </span>
</h2>
<?php


get_template_part( 'loop' );?>
<div id="primary">
    <?php echo get_sidebar(); ?></div>
</div>

<?php get_footer(); ?>
