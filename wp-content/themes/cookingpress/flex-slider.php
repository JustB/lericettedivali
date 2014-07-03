<?php $slider_type = get_option(PPTNAME . '_slider_type'); ?>

    <section id="featured" class="flex-slider-wrapper">
        
        <?php
        if ($slider_type == 'manual') {
            global $slides;
            $height = get_option(PPTNAME . '_slider_height');
            ?>
               <div class="flexmain-container">
                    <div class="flexslider main">
                        <ul class="slides">
            <?php foreach ($slides as $num => $slide) : ?>
                            <li>
                                <?php $first_img = $slide['src'];
                                $image = vt_resize('', $first_img, 770, $height, true); ?>
                                <img class="attachment-post-thumbnail wp-post-image" src="<?php echo $image[url] ?>" width="<?php echo $image[width] ?>" heigth="<?php echo $image[height] ?>"/>
                                <p class="flex-caption"> <?php if($slide['link']) { ?> <a href="<?php echo $slide['link']; ?>" > <?php } ?>
                        
                      <?php echo $slide['title']; ?> <?php echo $slide['subtitle']; ?><?php if($slide['link']) { ?> </a> <?php } ?></p>
                            </li>
                    <?php endforeach; ?>
                   </ul>
               </div>
            </div>
             <div id="flexmain-thumbs">
                  <ul>
                            <?php $i = 1;
                            foreach ($slides as $num => $slide) : ?>
                        <li class="tab<?php echo $i; ?>">
                            <a href="#<?php echo $i; ?>">
                                <?php
                                $first_img = $slide['src'];
                                $image = vt_resize('', $first_img, 80, 80, true);
                                echo '<img class="attachment-post-thumbnail wp-post-image" src="' . $image[url] . '" width="' . $image[width] . '" height="' . $image[height] . '"/>';
                                
                                ?>
                            </a>
                        </li>
            <?php $i++;
        endforeach; ?>
                </ul>
            </div>
                <?php } else if ($slider_type == 'automatic') { ?>

                <div class="flexmain-container">
                    <div class="flexslider main">
                        <ul class="slides">
                            <?php
                            $cat = get_option(PPTNAME . '_categories');
                            $height = get_option(PPTNAME . '_slider_height');
                            $slide_number = get_option(PPTNAME . '_number_slides');

                            if (get_option(PPTNAME . '_number_slides') != "") {
                                $slide_number = get_option(PPTNAME . '_number_slides');
                            } else {
                                $slide_number = '5';
                            }
                            $args= array(
                                'category__in' => $cat,
                                'posts_per_page' => $slide_number,
                                'meta_key'    => '_thumbnail_id',
                                'post__not_in' => get_option( 'sticky_posts' )
                            );

                            $my_query = new WP_Query($args);
                            while ($my_query->have_posts()) : $my_query->the_post();

                                    ?>
                                    <li>
                                          <?php
                            $height = get_option(PPTNAME.'_slider_height' );
                            if($height=='460px' || empty($height)) {
                                echo get_the_post_thumbnail($post->ID, 'slider-big'); 
                            } else if($height< 460 ){
                                $thumb = wp_get_attachment_image_src ( get_post_thumbnail_id ( $post->ID), 'slider-big' );
                                $image = vt_resize('', $thumb[0], 770, $height, true);
                                echo '<img class="attachment-post-thumbnail wp-post-image" src="' . $image[url] . '" width="' . $image[width] . '" height="' . $image[height] . '"/>';
                            } else {
                                $thumb = wp_get_attachment_image_src ( get_post_thumbnail_id ( $post->ID), 'full' );
                                $image = vt_resize('', $thumb[0], 770, $height, true);
                                echo '<img class="attachment-post-thumbnail wp-post-image" src="' . $image[url] . '" width="' . $image[width] . '" height="' . $image[height] . '"/>';
                            }
                         ?>
                                        <p class="flex-caption"><a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'boilerplate'), the_title_attribute('echo=0')); ?>" rel="bookmark"><?php the_title() ?></a></p>
                                    </li>
                            <?php endwhile; ?>
                        </ul>
                    </div>

                 </div>
        <div id="flexmain-thumbs">
                  <ul>
                    <?php $i = 1;
                      while ($my_query->have_posts()) : $my_query->the_post(); ?>
                          <li >
                              <a href="#">
                                  <?php
                                   $first_img = wp_get_attachment_image_src ( get_post_thumbnail_id ( $post->ID ));
                            $image = vt_resize('', $first_img[0], 80, 80, true);
                            echo '<img class="attachment-post-thumbnail wp-post-image" src="' . $image[url] . '" width="' . $image[width] . '" height="' . $image[height] . '"/>';
//                                  the_title();
                                  ?>
                              </a>
                          </li>
                          <?php $i++;
                      endwhile; ?>
                  </ul> 
            </div>
    <?php } ?>
    </section>
    <div id="featured-shadow">

    </div>
