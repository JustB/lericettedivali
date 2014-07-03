<?php
/**
 * The Sidebar containing the primary and secondary widget areas.
 *
 * @package WordPress
 * @subpackage purepress
 * @since purepress 1.0
 */
?>
<section id="sidebar" class="">
    <?php
     $sidebar = false;
    if(is_single()) {
        global $shortname;
        $sidebar = get_post_meta($post->ID, $shortname."whichpostsidebar_value", $single = true);

        if ($sidebar) {
            if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($sidebar)) :
                ?>

            <?php
            endif;
        }
    }
    ?>

    <?php
    if (!$sidebar) {
        if (!dynamic_sidebar('sidebar')) :
            ?>
    <div class="widget">
        <h3><span><?php _e('Archives', 'purepress'); ?></span></h3>
        <ul>
                    <?php wp_get_archives('type=monthly'); ?>
        </ul>
    </div>
    <div class="widget">

        <h3><span><?php _e('Meta', 'purepress'); ?></span></h3>
        <ul>
                    <?php wp_register(); ?>
            <li><?php wp_loginout(); ?></li>
                    <?php wp_meta(); ?>
        </ul>
    </div>

        <?php endif;
    } // end primary widget area   ?>

    <?php if (get_option(PPTNAME . '_social_widget') == 'Yes') { ?>
    <div class="widget socialize">
        <h3><span><?php echo get_option(PPTNAME . '_social_widget_title') ?></span></h3>
            <?php $socialsites = get_option(PPTNAME . '_social_widget_element');
            if (!empty($socialsites)) { ?>
        <ul>
                    <?php if (in_array("googleplus", $socialsites)) { ?>
            <li>
            <g:plusone size="tall" href="<?php if (is_single()) {
                            the_permalink();
                        } else {
                            echo home_url();
                                   } ?>"></g:plusone>
            </li>
                        <?php } if
        (in_array("twitter", $socialsites)) { ?>
            <li>
                <a href="http://twitter.com/share" class="twitter-share-button" data-url="<?php
                            if (is_single()) {
                                the_permalink();
                            } else {
                                echo home_url();
                               }
            ?>" data-count="vertical" data-via="<?php bloginfo('name') ?>">Tweet</a>
                <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
            </li>

            <?php }                     if
        (in_array("pinterest", $socialsites)) { ?>
            <li>
                <a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink() ?>&media=<?php $thumbnail = wp_get_attachment_image_src ( get_post_thumbnail_id ( $post->ID ), "large");
                        echo $thumbnail[0]; ?>&description=<?php the_title(); ?> on <?php bloginfo('url'); ?>" class="pin-it-button" count-layout="vertical"><img border="0" src="http://assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>
            </li>
            <?php }
        if (in_array("facebook", $socialsites)) { ?>
            <li>
                <div id="fb-root"></div>
                <script>(function(d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id)) return;
                    js = d.createElement(s); js.id = id;
                    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=<?php echo get_option(PPTNAME . '_social_widget_fbid') ?>";
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));</script>
                <div class="fb-like" data-send="false" data-layout="box_count" data-width="40" data-show-faces="false"></div>
            </li>
            <?php }

        if (in_array("shortlink", $socialsites)) { ?>
            <li>
            <?php if (function_exists('wp_get_shortlink')) { ?>
                <div>
                    <span class="post-shortlink"><?php _e( 'Shortlink:', 'purepress' ); ?>
                        <input type='text' value='<?php echo wp_get_shortlink(get_the_ID()); ?>' onclick='this.focus(); this.select();' />
                    </span>
                </div>
                <?php } ?>
            </li>
            <?php } ?>
        </ul>
        <?php } //end if  ?>
    </div>
    <?php } ?>

</section>