<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Boilerplate
 * @since Boilerplate 1.0
 */
get_header();

?>

<section id="content">
    <article id="post-0" class="post error404 not-found">
        <h2 class="entry-title"><?php _e('Not Found', 'purepress'); ?></h2>
        <div class="entry-content">
            <p>
                <?php _e('Apologies, but no results were found for the requested archive. Perhaps you\'d like to go to home page?', 'purepress'); ?>
                 <a href="<?php echo home_url('/'); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">&rarr;</a>
            </p>

        </div><!-- .entry-content -->
    </article><!-- #post-0 -->
</section>
<div id="primary">
    <?php echo get_sidebar(); ?></div>
</div>
</div>


<?php get_footer(); ?>
