<?php



add_action( 'widgets_init', 'purepress_load_widgets' );

function purepress_load_widgets() {
    register_widget( 'pp_social_widget' );

    register_widget('purepress_featured');
    register_widget('purepress_logged_user');
    register_widget('purepress_author');
    register_widget('purepress_popular');
    
}


$pp_social_widgets_services = array(
        'aim' => 'Aim URL',
        'apple' => 'Apple URL',
        'behance' => 'Behance URL',
        'blogger' => 'Blogger URL',
        'coroflot' => 'Coroflot URL',
        'designmoo' => 'Designmoo',
        'deviantart' => 'DeviantArt',
        'dribbble' => 'Dribbble',
        'ember' => 'Ember',
        'evernote' => 'Evernote',
        'facebook' => 'Facebook',
        'forrst' => 'Forrst',
        'goowalla' => 'Gowalla',
        'grooveshark' => 'Grooveshark',
        'icq' => 'icq',
        'lastfm' => 'LastFM',
        'paypal' => 'PayPal',
        'skype' => 'Skype',
        'tumblr' => 'Tumblr',
        'vimeo' => 'Vimeo',
        'twitter' => 'Twitter',
        'rss' => 'RSS'
);

//  Social Widget

class pp_social_widget extends WP_Widget {
    function pp_social_widget() {
        $widget_ops = array('classname' => 'social', 'description' => 'Links to social sites ' );
        $control_ops = array( 'width' => 300, 'height' => 350 );

        $this->WP_Widget('pp_social_widget', 'CookingPress Social Widget', $widget_ops, $control_ops);
    }

    function widget($args, $instance) {
        extract($args, EXTR_SKIP);

        echo $before_widget;
        $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
       
        if ( !empty( $title ) ) {
            echo $before_title . $title . $after_title;
        };
        $text = $instance['text'];
        echo '<p>'.$text.'</p>';

        global $pp_social_widgets_services;
        echo '<ul id="socials">';
        foreach ((array)$pp_social_widgets_services as $service_id => $service_title) {
            if ( !empty($instance['widget_social_'.$service_id]))
                echo '<li id="'. $service_id.'"><a href="'.$instance['widget_social_'.$service_id].'">'.$service_title.'</a></li>';
        }
        echo '</ul>';

        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        global $pp_social_widgets_services;
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
       
        $instance['text'] = $new_instance['text'];

        foreach ($pp_social_widgets_services as $service_id => $service_title) {
            $instance['widget_social_'.$service_id] = strip_tags($new_instance['widget_social_'.$service_id]);
        }
        return $instance;
    }

    function form($instance) {
        global $pp_social_widgets_services;
        $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'size' => '24' ) );
        $title = strip_tags($instance['title']);
       
        $text = $instance['text'];

        foreach ($pp_social_widgets_services as $service_id => $service_title):

            ${widget_social_.$service_id} = strip_tags($instance['widget_social_'.$service_id]);

        endforeach;?>

<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title','cloudfw'); ?>:
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>

<p><label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text','cloudfw'); ?>:
        <textarea class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"  ><?php echo esc_attr($text); ?></textarea></label></p>

        <?php 	foreach ($pp_social_widgets_services as $service_id => $service_title):?>
<p><label for="<?php echo $this->get_field_id('widget_social_'.$service_id); ?>"><?php echo $service_title; ?>:
        <input class="widefat" id="<?php echo $this->get_field_id('widget_social_'.$service_id); ?>" name="<?php echo $this->get_field_name('widget_social_'.$service_id); ?>" type="text" value="<?php echo esc_attr(${widget_social_.$service_id}); ?>" /></label></p>
        <?php 	endforeach; ?>

        <?php
    }
}


// Search Widget

class purepress_search extends WP_Widget {
    function purepress_search() {
        $widget_ops = array('classname' => 'search', 'description' => 'Search form designed for CookingPress theme' );
        $this->WP_Widget('purepress_search', 'CookingPress Search Widget', $widget_ops);
    }

    function widget($args, $instance) {
        extract($args, EXTR_SKIP);

        echo $before_widget;
        $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);

        if ( !empty( $title ) ) {
            echo $before_title . $title . $after_title;
        };

        echo '<form action="'.get_bloginfo("url").'" id="searchform" method="get">
                    <input type="text" name="s" id="search" value="'.get_search_query().'"/>
                    <input type="submit"  value="Search" id="s"/>
               </form>';

        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

    function form($instance) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
        $title = strip_tags($instance['title']);

        ?>

<p><label for="<?php echo $this->get_field_id('title'); ?>">Title:
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>

        <?php
    }
}


// Contact and pricing Widget

class purepress_author extends WP_Widget {
    function purepress_author() {
        $widget_ops = array('classname' => 'author', 'description' => 'Author post' );
        $control_ops = array( 'width' => 300, 'height' => 350 );
        $this->WP_Widget('purepress_author', 'CookingPress Author Widget', $widget_ops,$control_ops );
    }

    function widget($args, $instance) {
        extract($args, EXTR_SKIP);
   
        if(is_single()){
        echo $before_widget;
        $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
        global $post;
        $showposts = $instance['showposts'];


        if ( !empty( $title ) ) {

            echo $before_title . $title . $after_title;

        };
  

        $authorid = $post->post_author;
             $output = "<div class=\"author-bio-box\">".get_avatar( get_the_author_meta("user_email",$authorid), "64" )."
                        <h4><a href=".get_author_posts_url($authorid)." class=\"author-name\">".get_the_author_meta("display_name",$authorid)."</a></h4>
                        <p>".get_the_author_meta("description",$authorid)."</p>";
                        if($showposts=="yes") {
                                   
                       
                        $posts_query = new WP_Query(
                            array(
                                'author' => $authorid,
                                'post_status' => 'publish',
                                'posts_per_page' => '5',
                                'orderby' => 'rand')
                            );
                                if ($posts_query->have_posts()):
                                $output .= "More posts by ".get_the_author_meta("display_name",$authorid).":<ul>";
                                    while ($posts_query->have_posts()) : $posts_query->the_post();
                                       $output .= "<li> <a class=\"link\" href=".get_permalink().">".get_the_title()."</a></li>";
                                    endwhile;
                                $output .= "</ul>";
                                endif;
                        }
                  
                        $output .= "<a href=".get_author_posts_url($authorid)." class=\"read-more\">View all posts by ".get_the_author_meta("display_name",$authorid)." &rarr;</a>
			</div>";
        echo $output;wp_reset_query();
        echo $after_widget;
        }
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['showposts'] = strip_tags($new_instance['showposts']);
        return $instance;
    }

    function form($instance) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
        $title = strip_tags($instance['title']);
        $showposts = strip_tags($instance['showposts']);

        ?>

        <p><label for="<?php echo $this->get_field_id('title'); ?>">Title:
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
        <p><label for="<?php echo $this->get_field_id('showposts'); ?>">Show more posts:
                <select  id="<?php echo $this->get_field_id('showposts'); ?>" name="<?php echo $this->get_field_name('showposts'); ?>">
                    <option <?php if ($showposts=='yes')  echo 'selected="selected"'; ?> value="yes">Yes</option>
                    <option <?php if ($showposts=='no')  echo 'selected="selected"'; ?> value="no">No</option>
                </select> </label></p>
        <?php
    }
}

class purepress_logged_user extends WP_Widget {
    function purepress_logged_user() {
        $widget_ops = array('classname' => 'logged', 'description' => 'Logged user' );
        $control_ops = array( 'width' => 300, 'height' => 350 );
        $this->WP_Widget('purepress_logged_user', 'CookingPress Logged User Widget', $widget_ops,$control_ops );
    }

    function widget($args, $instance) {
        extract($args, EXTR_SKIP);
   
       
        echo $before_widget;
        $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
        global $post;
if ( is_user_logged_in() ) {
        if ( !empty( $title ) ) {
            echo $before_title . $title . $after_title;
        };
  

        global $current_user;
	       get_currentuserinfo();

             $output = "<div class=\"author-bio-box\">".get_avatar( $current_user->ID, 64 )."
                        You're logged as <a href=".get_author_posts_url($current_user->ID)." class=\"author-name\">".$current_user->display_name."</a>";
             $output .= ' <a href="'.wp_logout_url().'" title="Logout">Logout</a>';
                
                       
                        $posts_query = new WP_Query(
                            array(
                                'author' => $current_user->ID,
                                'post_status' => array('publish', 'pending', 'draft', 'future' ),
                                'posts_per_page' => '5'
                                )
                            );
                                if ($posts_query->have_posts()):
                                $output .= "<br/>Your latests posts:<ul>";
                                    while ($posts_query->have_posts()) : $posts_query->the_post();
                                       $output .= "<li> <a class=\"link\" href=".get_permalink().">".get_the_title()." <span>(".get_post_status().")<span></a></li>";
                                    endwhile;
                                $output .= "</ul>";
                                endif;
                        
                  
                        $output .= "</div>";
        echo $output;
        echo $after_widget;
}
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
       
        return $instance;
    }

    function form($instance) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
        $title = strip_tags($instance['title']);
        $showposts = strip_tags($instance['showposts']);

        ?>

        <p><label for="<?php echo $this->get_field_id('title'); ?>">Title:
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
       
        <?php
    }
}

// Featured post slider

class purepress_featured extends WP_Widget {
    function purepress_featured() {
        $widget_ops = array('classname' => 'cookingpress-recent', 'description' => 'Widget for recent posts' );
        $control_ops = array( 'width' => 300 );
        $this->WP_Widget('purepress_featured', 'CookingPress Recent Posts', $widget_ops,$control_ops );
    }

    function widget($args, $instance) {
        extract($args, EXTR_SKIP);
        echo $before_widget;
        $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
        $count = $instance['count'];
        $category = $instance['category'];
        $orderby = $instance['orderby'];
        if ( !empty( $title ) ) {
            echo $before_title . $title . $after_title;
        };

        if($category=='all'){
         
            $posts = new WP_Query(
                array(
                    'showposts' => $count,
                    'nopaging' => 0,
                    'post_status' => 'publish',
                    'orderby' => $orderby)
                );
        }
        else {
        $posts = new WP_Query(
                array(
                    'cat' => $category,
                    'showposts' => $count,
                    'nopaging' => 0,
                    'post_status' => 'publish',
                    'orderby' => $orderby)
                );
        }
        echo '<ul>';
        if ($posts->have_posts()) :while ($posts->have_posts()) : $posts->the_post();
	$post_title = get_the_title(); global $post;?>
        
        <li>
            <?php
              $first_img = wp_get_attachment_image_src ( get_post_thumbnail_id ( $post->ID ));
                $image = vt_resize( '', $first_img[0], 50, 50, true );
                if($first_img)
                echo '<a href="'.get_permalink().'"><img src="'.$image[url].'" width="'.$image[width].'" height="'.$image[height].'"/></a>';
            ?>
            <a class="link" href="<?php the_permalink() ?>"><?php the_title(); ?></a>
            <span><?php the_time(get_option('date_format')); if($first_img)  comments_number(
                __(' No Comments.','purepress'),
                __(' 1 Comment ','purepress'),
                __(' Comments (%)','purepress'));
        ?>
        </span>
        </li>
                <?php 
		endwhile;
                endif;
         wp_reset_query();
        echo '</ul>';
        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['count'] = $new_instance['count'];
        $instance['category'] = $new_instance['category'];
        $instance['orderby'] = $new_instance['orderby'];
        return $instance;
    }

    function form($instance) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
        $title = strip_tags($instance['title']);
        $count = $instance['count'];
        $category = $instance['category'];
        $orderby = $instance['orderby'];
        ?>


<p><label for="<?php echo $this->get_field_id('title'); ?>">Title:
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
<p><label for="<?php echo $this->get_field_id('count'); ?>">How many posts? (type only number):
        <input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo esc_attr($count); ?>" /></label></p>
<p><label for="<?php echo $this->get_field_id('orderby'); ?>">Order posts by:
        <select id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>">
            <option <?php if($orderby == 'date') echo 'selected="selected"'; ?> value="date">Date</option>
            <option <?php if($orderby == 'rand') echo 'selected="selected"'; ?> value="rand">Random</option>
            <option <?php if($orderby == 'title') echo 'selected="selected"'; ?> value="title">Title</option>
        </select>
   </label>
<p>
    <label for="<?php echo $this->get_field_id('category'); ?>">Choose category:
         <select id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>">
            
            <?php   $categories = get_categories();
                    $cats = get_cats($categories);
                    foreach ($cats as $cat=>$catnr){ ?>
                        <option <?php if ($category == $cat)  echo 'selected="selected"';  ?> value="<?php echo $cat; ?>"><?php echo $catnr; ?></option>
                    <?php } ?>
                        <option <?php if ($category == 'all')  echo ' selected="selected"';  ?> value="all">All categories</option>
        </select>
    </label>
</p>
        <?php
    }
}


class purepress_popular extends WP_Widget {
    function purepress_popular() {
        $widget_ops = array('classname' => 'cookingpress-popular', 'description' => 'Widget for popular posts' );
        $control_ops = array( 'width' => 300 );
        $this->WP_Widget('purepress_popular', 'CookingPress Popular Posts', $widget_ops,$control_ops );
    }

    function widget($args, $instance) {
        extract($args, EXTR_SKIP);
        echo $before_widget;
        $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
        $count = $instance['count'];
        $category = $instance['category'];
     
        if ( !empty( $title ) ) {
            echo $before_title . $title . $after_title;
        };

        if($category=='all'){

            $posts = new WP_Query(
                array(
                    'showposts' => $count,
                    'r_sortby' => 'most_rated',
                    'r_orderby' => 'DESC',
                    'nopaging' => 0,
                    'post_status' => 'publish')
                );
        }
        else {
        $posts = new WP_Query(
                array(
                    'cat' => $category,
                    'showposts' => $count,
                    'r_sortby' => 'most_rated',
                    'r_orderby' => 'DESC',
                    'nopaging' => 0,
                    'post_status' => 'publish',
                   )
                );
        }
        echo '<ul>';
        if ($posts->have_posts()) :while ($posts->have_posts()) : $posts->the_post();
	$post_title = get_the_title(); global $post;?>

        <li>
            <?php
              $first_img = wp_get_attachment_image_src ( get_post_thumbnail_id ( $post->ID ));
                $image = vt_resize( '', $first_img[0], 50, 50, true );
                if($first_img)
                echo '<a href="'.get_permalink().'"><img src="'.$image[url].'" width="'.$image[width].'" height="'.$image[height].'"/></a>';
            ?>
            <a class="link" href="<?php the_permalink() ?>"><?php the_title(); ?></a>
            <span>
            
            <?php the_time(get_option('date_format')); if($first_img)  comments_number(
                __(' No Comments.','purepress'),
                __(' 1 Comment ','purepress'),
                __(' Comments (%)','purepress'));
        ?>
        </span>
        </li>
                <?php
		endwhile;
                endif;
         wp_reset_query();
        echo '</ul>';
        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['count'] = $new_instance['count'];
        $instance['category'] = $new_instance['category'];
 
        return $instance;
    }

    function form($instance) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
        $title = strip_tags($instance['title']);
        $count = $instance['count'];
        $category = $instance['category'];
        $orderby = $instance['orderby'];
        ?>


<p><label for="<?php echo $this->get_field_id('title'); ?>">Title:
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
<p><label for="<?php echo $this->get_field_id('count'); ?>">How many posts? (type only number):
        <input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo esc_attr($count); ?>" /></label></p>

<p>
    <label for="<?php echo $this->get_field_id('category'); ?>">Choose category:
         <select id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>">

            <?php   $categories = get_categories();
                    $cats = get_cats($categories);
                    foreach ($cats as $cat=>$catnr){ ?>
                        <option <?php if ($category == $cat)  echo 'selected="selected"';  ?> value="<?php echo $cat; ?>"><?php echo $catnr; ?></option>
                    <?php } ?>
                        <option <?php if ($category == 'all')  echo ' selected="selected"';  ?> value="all">All categories</option>
        </select>
    </label>
</p>
        <?php
    }
}

?>