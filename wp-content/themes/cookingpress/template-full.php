<?php
/**
 * Template Name: Full loop Page
 *
 * A custom page template without sidebar.
 *
 * The "Template Name:" bit above allows this to be selectable
 * from a dropdown menu on the edit page screen.
 *
 * @package WordPress
 * @subpackage purepress
 * @since purepress 1.0
 */

get_header();
query_posts( array( 'post_type' => 'post') );
?>

<section id="content" class="fulllay" role="main" >



<?php /* Display navigation to next/previous pages when applicable */ ?>

<section id="articles">
    <?php /* If there are no posts to display, such as an empty archive page */ ?>
    <?php if (!have_posts()) : ?>
    <article id="post-0" class="post error404 not-found">
        <h1 class="entry-title"><?php _e('Not Found', 'purepress'); ?></h1>
        <div class="entry-content">
            <p><?php _e('Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'purepress'); ?></p>
                <?php get_search_form(); ?>
        </div><!-- .entry-content -->
    </article><!-- #post-0 -->
    <?php endif; ?>

    <?php while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


        <div class="entry-wrapper">
        <?php printf( '<a href="%1$s" class="published-time" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',get_permalink(),esc_attr( get_the_time() ),get_the_date()); ?>
         <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'purepress'), the_title_attribute('echo=0')); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
             <div class="entry-content">
                        <?php if (post_password_required()) : ?>
                            <?php echo limit_words(get_the_excerpt('Read more &raquo;'), '18'); echo "..."; ?>
                        <?php else : ?>
                            <?php the_content(); endif; ?>
             </div><!-- .entry-content -->
        </div>
             <footer class="entry-utility">
                    <?php purepress_single_postmeta(); ?>
                    <?php if(function_exists('the_ratings')) {
            the_ratings();
                    } ?>

        <?php edit_post_link(__(' Edit', 'purepress'), '<span class="edit-link">', '</span>'); ?>
        </footer><!-- .entry-utility -->
    </article><!-- #post-## -->
            <?php  endwhile; // End the loop. Whew.
?>

<?php /* Display navigation to next/previous pages when applicable */ ?>

</section>

</section>

<div id="primary">
<?php echo get_sidebar(); ?></div>
</div>

<?php get_footer(); ?>