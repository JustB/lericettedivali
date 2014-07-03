<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage purepress
 * @since purepress 1.0
 */
get_header();

?>

<section id="content">
    <?php if (have_posts())
        while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
                <?php printf('<a href="%1$s" class="published-time" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>', get_permalink(), esc_attr(get_the_time()), get_the_date()); ?>
                <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'purepress'), the_title_attribute('echo=0')); ?>" rel="bookmark"><?php the_title(); ?></a></h2>


                <div class="entry-content">
                    <?php the_content(); ?>
                    <?php wp_link_pages(array('before' => '' . __('Pages:', 'purepress'), 'after' => '')); ?>
                </div><!-- .entry-content -->
               <?php if (get_the_author_meta('description') && get_option(PPTNAME . '_author_info') == 'yes') :  // If a user has filled out their description, show a bio on their entries  ?>
                    <footer id="entry-author-info">
                        <?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('purepress_author_bio_avatar_size', 60)); ?>
                        <h4><?php printf(esc_attr__('About %s', 'purepress'), get_the_author()); ?></h4>
                        <?php the_author_meta('description'); ?>
                        <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
                            <?php printf(__('View all posts by %s &rarr;', 'purepress'), get_the_author()); ?>
                        </a>
                    </footer><!-- #entry-author-info -->
                <?php endif; ?>
                <footer class="entry-utility">
                    <?php //purepress_posted_in(); ?>
                    <?php edit_post_link(__('Edit', 'purepress'), '<span class="edit-link">', '</span>'); ?>
                </footer><!-- .entry-utility -->
            </article><!-- #post-## -->
       

        <?php endwhile; // end of the loop. ?>

</section>
<div id="primary">
<?php echo get_sidebar(); ?></div>
</div>
</div>
   <?php comments_template('', true); ?>

<?php get_footer(); ?>
