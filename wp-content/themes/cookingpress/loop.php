<?php
/**
 * The loop that displays posts.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop.php or
 * loop-template.php, where 'template' is the loop context
 * requested by a template. For example, loop-index.php would
 * be used if it exists and we ask for the loop with:
 * <code>get_template_part( 'loop', 'index' );</code>
 *
 * @package WordPress
 * @subpackage purepress
 * @since purepress 1.0
 */
?>  
<section id="content" role="main" >
    <section id="articles">
        <?php /* If there are no posts to display, such as an empty archive page */ ?>
        <?php if (!have_posts()) : ?>
        <article id="post-0" class="post error404 not-found">
            <h2 class="entry-title"><?php _e('Not Found', 'purepress'); ?></h2>
            <div class="entry-content">
                <p><?php _e('Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'purepress'); ?></p>
              
            </div><!-- .entry-content -->
        </article><!-- #post-0 -->
        <?php endif; ?>
        <?php 


        ?>
        <?php while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php if (has_post_thumbnail()) { ?>
            <a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'purepress'), the_title_attribute('echo=0')); ?>" rel="bookmark">
                        <?php the_post_thumbnail(); ?>
            </a>
                    <?php } ?>

                <?php printf( '<a href="%1$s" class="published-time" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',get_permalink(),esc_attr( get_the_time() ),get_the_date()); ?>
            <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'purepress'), the_title_attribute('echo=0')); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

                <?php if (has_post_thumbnail() == FALSE ) { ?>

            <div class="entry-content">
                        <?php if (post_password_required()) : ?>
                            <?php echo get_the_excerpt('Read more &raquo;'); ?><a class='read-more' href="<?php get_permalink(); ?>">&hellip;</a>
                        <?php else : ?>
                            <?php echo get_the_excerpt('Read more &raquo;');
                            echo "<a class='read-more' href=".get_permalink().">"; _e(' read more', 'purepress'); echo " &rarr;</a>";
                        endif; ?>
            </div><!-- .entry-content -->
                    <?php } ?>
            <footer>
                    <?php purepress_postmeta() ?>
            </footer>
        </article><!-- #post-## -->
        <?php endwhile; // End the loop. Whew.?>
    </section>
    <?php /* Display navigation to next/previous pages when applicable */ ?>

<?php if(function_exists('wp_pagenavi')) : 
         wp_pagenavi(); 
    else:
         if ($wp_query->max_num_pages > 1) : ?>
            <nav id="nav-below" class="navigation">
                <div class="nav-previous"><?php next_posts_link(__('&larr; Older posts', 'purepress')); ?></div>
                <div class="nav-next"><?php previous_posts_link(__('Newer posts &rarr;', 'purepress')); ?></div>
            </nav><!-- #nav-below -->
         <?php endif;
    endif; ?>
</section>