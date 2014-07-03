 <section id="featured" class="coda-slider-wrapper">
        <!--
        <div id="coda-nav-left-1" class="coda-nav-left"><a href="#" title="Slide left">&#171;</a></div>
        <div id="coda-nav-right-1" class="coda-nav-right"><a href="#" title="Slide right">&#187;</a></div>
        -->
        <div class="coda-slider preload" id="coda-slider-1">
            <?php
            $my_query = new WP_Query('showposts=8');
            while ($my_query->have_posts()) : $my_query->the_post();
                $first_img = get_first_image_url($id, $order, $exclude);
                $image = vt_resize('', $first_img, 750, 450, true);
                ?>
            <div class="panel">
                <div class="panel-wrapper">
                    <h2><?php the_title()?></h2>
                    <p> <?php printf(__('<span>In</span> %2$s', 'purepress'), 'entry-utility-prep entry-utility-prep-cat-links', get_the_category_list(', ')); ?></p>
                    <img class="attachment-post-thumbnail wp-post-image" src="<?php echo $image[url] ?>" />
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <div id="coda-nav-1" class="coda-nav">
            <ul>
                <?php
                $i = 1;
                while ($my_query->have_posts()) : $my_query->the_post(); ?>
                <li class="tab<?php echo $i; ?>">
                    <a href="#<?php echo $i; ?>">
                        <?php   $first_img = get_first_image_url($id, $order, $exclude);
                        $image = vt_resize('', $first_img, 80, 80, true);
                        echo '<img class="attachment-post-thumbnail wp-post-image" src="' . $image[url] . '" width="' . $image[width] . '" height="' . $image[height] . '"/>';
                        the_title();
                        ?>
                    </a>
                </li>

                <?php $i++; endwhile; ?>
            </ul>
        </div>

</section>
<div id="featured-shadow">

        </div>