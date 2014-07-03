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

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php printf('<a href="%1$s" class="published-time" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>', get_permalink(), esc_attr(get_the_time()), get_the_date()); ?>
        <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'purepress'), the_title_attribute('echo=0')); ?>" rel="bookmark"><?php the_title(); ?></a></h2>


        <div class="entry-content">
                    <?php the_content();
                    if (get_option(PPTNAME . '_recipe_autoadd') == 'yes') {
                        global $post;
                        $pattern = get_shortcode_regex();
                        preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches );

                        if( is_array( $matches ) && array_key_exists( 2, $matches ) && in_array( 'purerecipe', $matches[2] ) ) {
                            // jest OK
                        } else {
                            $recipe_test = get_post_meta($post->ID, $shortname.'instructions', true);
                            if($recipe_test) echo do_shortcode('[purerecipe]');
                        }
                    }

                    ?>


                    <?php wp_link_pages(array('before' => '' . __('Pages:', 'purepress'), 'after' => '')); ?>
        </div><!-- .entry-content -->
        <footer class="entry-utility">
                    <?php purepress_single_postmeta(); ?>
                    <?php if(function_exists('the_ratings')) {
            the_ratings();
                    } ?>

        <?php edit_post_link(__(' Edit', 'purepress'), '<span class="edit-link">', '</span>'); ?>
        </footer><!-- .entry-utility -->

        <?php if (get_the_author_meta('description') && get_option(PPTNAME . '_author_info') == 'yes') : // If a user has filled out their description, show a bio on their entries  ?>
        <footer id="entry-author-info">
                        <?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('purepress_author_bio_avatar_size', 60)); ?>
            <h4><?php printf(esc_attr__('About %s', 'purepress'), get_the_author()); ?></h4>
                            <?php the_author_meta('description'); ?>
            <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
            <?php printf(__('View all posts by %s &rarr;', 'purepress'), get_the_author()); ?>
            </a>
        </footer><!-- #entry-author-info -->
        <?php endif; ?>

    </article><!-- #post-## -->


    <nav id="nav-below" class="navigation">
        <?php if(get_adjacent_post(false, '', true)) { //if prev post exists
                        $nextid = get_next_post_id();
                        $previd = get_previous_post_id(); ?>
        <div class="nav-previous">
                        <?php $prev_img = get_first_image_url($previd,'','');
                        if($prev_img) {
                $image = vt_resize( '', $prev_img, 64, 64, true );
                echo '<img src="'.$image['url'].'" width="64" height="64" align="left"/>';
            } ?>
            <p <?php if(!$prev_img) {
                echo 'class="no-image"';
                    } ?>>
                <span><?php _e( '&larr; Previous post', 'purepress' ); ?></span>
                <br/><?php previous_post_link( '%link', '%title' ); ?>
            </p>
        </div>
                        <?php } ?>

                    <?php if(get_adjacent_post(false, '', false)) { //if next post exists ?>
        <div class="nav-next">
                        <?php $next_img = get_first_image_url($nextid,'','');
            if($next_img) {
                $image = vt_resize( '', $next_img,64, 64, true );
                echo '<img src="'.$image['url'].'" width="64" height="64" align="right"/>';
            }
            ?>
            <p <?php if(!$next_img) {
                echo 'class="no-image"';
            }?>>
                <span><?php _e( 'Next post &rarr;', 'purepress' ); ?></span>
                <br/><?php next_post_link( '%link', '%title' ); ?>
            </p>
        </div>
            <?php } ?>
    </nav><!-- #nav-below -->


    <?php endwhile; // end of the loop. ?>

</section>
<div id="primary">
<?php echo get_sidebar(); ?></div>
</div>
</div>
<?php comments_template('', true); ?>

<?php get_footer(); ?>
