<?php
    get_header();
?>

<?php if (have_posts()) the_post(); ?>


<h2 class="template-subtitle">
    <span>
<?php printf(__('Author Archives: %s', 'purepress'), "<a class='url fn n' href='" . get_author_posts_url(get_the_author_meta('ID')) . "' title='" . esc_attr(get_the_author()) . "' rel='me'>" . get_the_author() . "</a>"); ?>
    </span>
</h2>
    <?php if (get_the_author_meta('description')) : ?>
        <aside id="author-info">
            <div id="author-data">
                <?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('purepress_author_bio_avatar_size', 85)); ?>
                <h4><?php printf(__('About %s', 'purepress'), get_the_author()); ?></h4>
                <a href="<?php the_author_meta('user_url'); ?>"><?php the_author_meta('user_url'); ?></a>
            </div>
            <div id="author-desc"><?php the_author_meta('description'); ?></div>
        </aside>
    <?php endif; ?>

<?php
rewind_posts();

get_template_part('loop', 'index');
?>

<div id="primary">
<?php echo get_sidebar(); ?></div>
</div>

<?php get_footer(); ?>