<?php
/**
 * SHORTCODES
 */


function dropcap($atts, $content = null) {
    extract(shortcode_atts(array(
            "type" => ''
            ), $atts));
    return '<span class="dropcap '.$type.'">'.$content.'</span>';
}
add_shortcode('dropcap', 'dropcap');


function highlight($atts, $content = null) {
    extract(shortcode_atts(array(
            "type" => ''
            ), $atts));
    return '<span class="highlight'.$type.'">'.$content.'</span>';
}
add_shortcode('highlight', 'highlight');



function etdc_tab_group( $atts, $content ) {
    $GLOBALS['tab_count'] = 0;
    do_shortcode( $content );

    if( is_array( $GLOBALS['tabs'] ) ) {
        foreach( $GLOBALS['tabs'] as $tab ) {
            $tabs[] = '<li><a href="#">'.$tab['title'].'</a></li>';
            $panes[] = '<div class="tab">'.$tab['content'].'</div>';
        }
        $return = "\n".'<ul class="tabs">'.implode( "\n", $tabs ).'</ul>'."\n".'<div class="tabs-content">'.implode( "\n", $panes ).'</div>'."\n";
    }
    return $return;
}


function etdc_tab( $atts, $content ) {
    extract(shortcode_atts(array(
            'title' => 'Tab %d'
            ), $atts));

    $x = $GLOBALS['tab_count'];
    $GLOBALS['tabs'][$x] = array( 'title' => sprintf( $title, $GLOBALS['tab_count'] ), 'content' =>  do_shortcode( $content ) );
    $GLOBALS['tab_count']++;
}
add_shortcode( 'tabgroup', 'etdc_tab_group' );
add_shortcode( 'tab', 'etdc_tab' );


function accorgroup($atts,$content) {

    return '<div class="accordion">'.do_shortcode( $content ).'</div>';
}


function accordion( $atts, $content ) {
    extract(shortcode_atts(array(
            'title' => 'Tab %d'
            ), $atts));
    return '<h4><a href="#">'.$title.'</a></h4><div>'.do_shortcode( $content ).'</div>';
}
add_shortcode( 'accorgroup', 'accorgroup' );
add_shortcode( 'accordion', 'accordion' );


function purelist($atts, $content = null) {
    extract(shortcode_atts(array(
            "type" => ''
            ), $atts));
    return '<div class="purelist '.$type.'">'.$content.'</div>';
}
add_shortcode('list', 'purelist');


function box($atts, $content = null) {
    extract(shortcode_atts(array(
            "type" => ''
            ), $atts));
    return '<div class="box-'.$type.'-outer">
                            <div class="box-'.$type.'">
                               <p> '.do_shortcode( $content ).'</p>
                            </div>
                        </div>';
}
add_shortcode('box', 'box');


function half($atts, $content = null) {
    return '
        <div class="half">'.do_shortcode( $content ).'</div>';
}

function halflast($atts, $content = null) {
    return '
        <div class="half-last">'.do_shortcode( $content ).'</div>
        <br style="clear: both;" />';
}

add_shortcode('half', 'half');
add_shortcode('halflast', 'halflast');


function onethree($atts, $content = null) {
    return '
        <div class="one-three">'.do_shortcode( $content ).'</div>';
}

function onethreelast($atts, $content = null) {
    return '
        <div class="one-three-last">'.do_shortcode( $content ).'</div>
        <br style="clear: both;" />';
}

add_shortcode('onethree', 'onethree');
add_shortcode('onethreelast', 'onethreelast');


function onefourth($atts, $content = null) {
    return '<div class="one-fourth">'.do_shortcode( $content ).'</div>';
}

function onefourthlast($atts, $content = null) {
    return '
        <div class="one-fourth-last">'.do_shortcode( $content ).'</div>
        <br style="clear: both;" />';
}

add_shortcode('onefourth', 'onefourth');
add_shortcode('onefourthlast', 'onefourthlast');


function onefifth($atts, $content = null) {
    return '
        <div class="one-fifth">'.do_shortcode( $content ).'</div>';
}

function onefifthlast($atts, $content = null) {
    return '
        <div class="one-fifth-last">'.do_shortcode( $content ).'</div>
        <br style="clear: both;" />';
}

add_shortcode('onefifth', 'onefifth');
add_shortcode('onefifthlast', 'onefifthlast');


function threefourth($atts, $content = null) {
    return '<div class="three-fourth">'.do_shortcode( $content ).'</div> <br style="clear: both;" />';
}

add_shortcode('threefourth', 'threefourth');


function threethree($atts, $content = null) {
    return '<div class="three-three">'.do_shortcode( $content ).'</div>
               <br style="clear: both;" />';
}
add_shortcode('threethree', 'threethree');


function twofifth($atts, $content = null) {
    return '<div class="two-fifth">'.do_shortcode( $content ).'</div>';
}

add_shortcode('twofifth', 'twofifth');


function threefifth($atts, $content = null) {
    return '
        <div class="three-fifth">'.do_shortcode( $content ).'</div>
           ';
}

add_shortcode('threefifth', 'threefifth');


function slider($atts, $content = null) {
    do_shortcode( $content );
    extract(shortcode_atts(array(
            "title" => ''
            ), $atts));
    return '<h4 class="toggle-trigger">'.$title.'</h4>
              <div class="toggle-container">
              <div class="block">'.do_shortcode( $content ).'</div></div>';
}
add_shortcode('slider', 'slider');


function quote_left($atts, $content = null) {
    return '
        <blockquote class="q-left">'.do_shortcode( $content ).'</blockquote>';
}
function quote_right($atts, $content = null) {
    return '
        <blockquote class="q-right">'.do_shortcode( $content ).'</blockquote>';
}
add_shortcode('quoteleft', 'quote_left');
add_shortcode('quoteright', 'quote_right');


function button($atts, $content = null) {
    extract(shortcode_atts(array(
            "url" => '',
            "color" => '',
            ), $atts));
    return '<a class="button '.$color.'" href="'.$url.'"><span>'.$content.'</span></a>';
}
add_shortcode('button', 'button');


function separator($atts) {
    extract(shortcode_atts(array(), $atts));
    return '<div class="hr"><span>'.__("Top", 'purepress').'</span></div>';
}
add_shortcode('separator', 'separator');



function convert_minutes($minutes) {
    if($minutes > 1440) {
        $d = floor ($minutes / 1440);
        $h = floor (($minutes - $d * 1440) / 60);
        $m = $minutes - ($d * 1440) - ($h * 60);
        return $d.'day '.$h.' h '.$m.' min';
    } else if($minutes > 60) {
        return sprintf("%02dh %02dmin", floor($minutes/60), $minutes%60);
    } else {
        return $minutes.''.__(" minutes", 'purepress');
    }
}
function convert_minutes_to_pt($minutes) {
    if($minutes > 1440) {
        $d = floor ($minutes / 1440);
        $h = floor (($minutes - $d * 1440) / 60);
        $m = $minutes - ($d * 1440) - ($h * 60);
        return 'PT'.$d.'D'.$h.'H'.$m.'M';
    } else if($minutes > 60) {
        return sprintf("PT%02dH%02dM", floor($minutes/60), $minutes%60);
    } else {
        return 'PT'.$minutes.'M';
    }
}


function purerecipe_schema($atts) {
    extract(shortcode_atts(array(), $atts));
    global $post;
    global $shortname;
    $title = get_post_meta($post->ID, $shortname.'title', true);
    if(empty($title)) $title = get_the_title($post->ID);

    $desc = get_post_meta($post->ID, $shortname.'summary', true);

    $recipeoptions = get_post_meta($post->ID, $shortname.'recipeoptions', true);
    $nutrtion_facts = get_post_meta($post->ID, $shortname.'ntfacts', true);
    if(is_array($nutrtion_facts)) $nf_test = implode($nutrtion_facts);
    $recipetheme = get_post_meta($post->ID, $shortname.'recipetheme', true);
    if(empty($recipetheme)) $recipetheme = 'teared';
    $photo = get_post_meta($post->ID, $shortname.'photo', true);

    if(empty($photo)) {
        $image_src = wp_get_attachment_image_src ( get_post_thumbnail_id ( $post->ID ), "recipe-thumb");
        $image_src_full = wp_get_attachment_image_src ( get_post_thumbnail_id ( $post->ID ), "large");
    }
    $ingridients = get_post_meta($post->ID, $shortname.'ingridients', true);
    $instructions = get_post_meta($post->ID, $shortname.'instructions', true);
    $rating = get_post_meta($post->ID, 'ratings_average', true);
    $rating_nr = get_post_meta($post->ID, 'ratings_users', true);

    if($photo) {
        $imgmeta = wp_get_attachment_metadata( $photo );
        $image_src = wp_get_attachment_image_src($photo, 'recipe-thumb');
        $image_full_src = wp_get_attachment_image_src($photo, 'large');
    }

    //Array ( preprtime[0] => 23 cooktime[1] => 5 yield[2] => 2 calories[3] => 234 fat[4] => 123 )
    $allergens =  get_the_term_list( $post->ID, 'allergen', ' ', ', ', ' ' );
    $preptime = $recipeoptions[0];
    $cooktime = $recipeoptions[1];
    $yield = $recipeoptions[2];


    $author = get_the_author();
    $output = '';
    if($image_src[0]) $addClass ="photo";
    $output .= '
     <div id="purerecipe-wrapper" class="'.$recipetheme.' '.$addClass.'"><section class="purerecipe '.$recipetheme.'" itemscope itemtype="http://schema.org/Recipe">
         <header>
            <h3 itemprop="name">'.$title.'</h3>
            <p id="author-data">'.__("By", 'purepress').' <a class="recipe-author" href="'. get_author_posts_url(get_the_author_meta('ID')).'" itemprop="author">'.$author.'</a>,
                <span class="recipe-data"><meta itemprop="datePublished" content="'.get_the_date('Y-m-d').'">'.get_the_date().'</span>
            </p>';

    if($image_src[0]) $output .= '<a href="'.$image_src_full[0].'" ><img itemprop="image" src="'.$image_src[0].'" class="recipe-image" width="'.$image_src[1].'" height="'.$image_src[2].'" alt="'.$title.'" /></a>';
    $output .= '</header>';


    if($image_src[0]) {
        $output .= '<div id="recipe-content" class="hasImage">';
    }
    else {
        $output .= '<div id="recipe-content">';
    }

    $output .= '<p id="recipe-desc" itemprop="description">'.wpautop($desc,1).'</p>';
    if($preptime || $cooktime || $yield || !empty($nf_test) ) {
        $output .= '<div id="recipe-add-data">';
    }
    if($preptime || $cooktime || $yield ) {

        $output .= '<ul class="recipe-metadata">';
        if($preptime)  $output .= '<li> <em>'.__("Prep Time:", 'purepress').'</em> <meta itemprop="prepTime" content="'. convert_minutes_to_pt($preptime) .'">'. convert_minutes($preptime).'</li>';
        if($cooktime)  $output .= '<li> <em>'.__("Cook time:", 'purepress').'</em> <meta itemprop="cookTime" content="'. convert_minutes_to_pt($cooktime) .'">'. convert_minutes($cooktime).'</li>';
        if($yield)  $output .= '<li> <em>'.__("Yield:", 'purepress').'</em> <span itemprop="recipeYield">'.$yield.'</span></li>';
        if(function_exists('the_ratings'))
            $output .= '<li itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
                            <em>'.__("Rating:", 'purepress').'</em> <span itemprop="ratingValue">'.$rating.'</span>'.__(" stars - based on ", 'purepress').'<span itemprop="reviewCount">'.$rating_nr.'</span> '.__(" reviews", 'purepress').'
                        </li>';
        if($allergens) $output .= '<li>'.__("Allergens:", 'purepress').$allergens.'</li>';
        $output .= '</ul>';
    }

    if(!empty($nf_test)) {
        $output .= '<div itemprop="nutrition" itemscope itemtype="http://schema.org/NutritionInformation">';
        $output .= '<em id="nutrition">'.__("Nutrition facts:", 'purepress').'</em> ';
        $nfacts_lists = get_option('cookingpress_nutrition_facts');
        $i=0;
        foreach ($nfacts_lists as $k => $v) {
            $name = preg_replace( '/\s+/', ' ', $v['name'] );
            if(!empty($nutrtion_facts[$i])) $output .=  '<span itemprop="'.strtolower($name).__("Content", 'purepress').'">'.$v['name'].':  '.$nutrtion_facts[$i].' '. $v['unit'].'</span>; ';
            $i++;
        }

        $output .= '</div>';
    }


    if($preptime || $cooktime || $yield || $fat || $calories ) {
        $output .= "</div>";
    }
    if($ingridients) {
        $output .= '<h4>'.__("Ingredients:", 'purepress').'</h4><ul class="ingredients">';
        foreach ($ingridients as $key => $value ) {
    
            if($value['note']=='separator') {
                $output .= '<li class="separator">'.$value['name'].'</li>' ;
            } else {
                $tag_id = get_tag_id_by_name($value['name']);
                if($recipe_tooltip == 'yes') { $tagdesc = tag_description($tag_id); }
                $output .= '<li class="ingredient ingridients-cont'; if($tagdesc) $output .= ' hasdesc ';
                $output .= '"itemprop="ingredients"><a href="'.get_tag_link($tag_id).'">'.$value['name'].'</a> - <span>'.$value['note'].'</span>';
                if($tagdesc) $output .= '<div class="tooltip">'.get_term_photo_by_id($tag_id).$tagdesc.'</div>';
                  $output .='</li>';
            }
        }
        $output .= "</ul>";


    }

    if($instructions) {
        $output .= '<h4>'.__("Instructions:", 'purepress').'</h4>
            <div itemprop="recipeInstructions" class="instructions">'.wpautop($instructions,1).'</div>';
    }

    if(function_exists('pf_show_link')) {
        $output .= pf_show_link();
    }

    $output .= '</div></section></div>';

    return $output;

}

// Purerecipe hRecipe compatible
function purerecipe_h($atts) {
    extract(shortcode_atts(array(), $atts));
    global $post;
    global $shortname;


    $title = get_post_meta($post->ID, $shortname.'title', true);
    if(empty($title)) $title = get_the_title($post->ID);
    $desc = get_post_meta($post->ID, $shortname.'summary', true);
    $allergens =  get_the_term_list( $post->ID, 'allergen', ' ', ', ', ' ' );
    $recipeoptions = get_post_meta($post->ID, $shortname.'recipeoptions', true);
    $nutrtion_facts = get_post_meta($post->ID, $shortname.'ntfacts', true);
    if(is_array($nutrtion_facts)) $nf_test = implode($nutrtion_facts);
    $recipetheme = get_post_meta($post->ID, $shortname.'recipetheme', true);
    if(empty($recipetheme)) $recipetheme = 'teared';
    $photo = get_post_meta($post->ID, $shortname.'photo', true);

    if(empty($photo)) {
        $image_src = wp_get_attachment_image_src ( get_post_thumbnail_id ( $post->ID ), "recipe-thumb");
        $image_src_full = wp_get_attachment_image_src ( get_post_thumbnail_id ( $post->ID ), "large");
    }
    $recipe_format = get_option(PPTNAME . '_recipe_format');
    $recipe_tooltip = get_option(PPTNAME . '_recipe_tooltip');

    $ingridients = get_post_meta($post->ID, $shortname.'ingridients', true);
    $instructions = get_post_meta($post->ID, $shortname.'instructions', true);

    $rating = get_post_meta($post->ID, 'ratings_average', true);
    $rating_nr = get_post_meta($post->ID, 'ratings_users', true);
    if($photo) {
        $imgmeta = wp_get_attachment_metadata( $photo );
        $image_src = wp_get_attachment_image_src($photo, 'recipe-thumb');
        $image_full_src = wp_get_attachment_image_src($photo, 'large');
    }
    //Array ( preprtime[0] => 23 cooktime[1] => 5 yield[2] => 2 calories[3] => 234 fat[4] => 123 )

    $preptime = $recipeoptions[0];
    $cooktime = $recipeoptions[1];
    $yield = $recipeoptions[2];


    $author = get_the_author();
    $output = '';
    if($image_src) $addClass ="photo";
    $output .= '
     <div id="purerecipe-wrapper" class="hrecipe '.$recipetheme.' '.$addClass.'"><section class="purerecipe '.$recipetheme.'" >
         <header>
            <h3 class="fn">'.$title.'</h3>
            <p id="author-data">'.__(" By ", 'purepress').'<a class="author recipe-author" href="'. get_author_posts_url(get_the_author_meta('ID')).'" >'.$author.'</a>,
                <span class="published recipe-data">'.get_the_date().'</span>
            </p>';

    if($image_src[0]) $output .= '<a href="'.$image_src_full[0].'" ><img itemprop="image" src="'.$image_src[0].'" class="photo recipe-image" width="'.$image_src[1].'" height="'.$image_src[2].'" alt="'.$title.'" /></a>';
    $output .= '</header>';


    if($image_src[0]) {
        $output .= '<div id="recipe-content" class="hasImage">';
    }
    else {
        $output .= '<div id="recipe-content">';
    }

    $output .= '<p id="recipe-desc" class="summary">'.wpautop($desc,1 ).'</p>';
    if($preptime || $cooktime || $yield || !empty($nf_test)  ) {
        $output .= '<div id="recipe-add-data">';
    }
    if($preptime || $cooktime || $yield ) {

        $output .= '<ul class="recipe-metadata">';
        $output .= '<li style="display:none" class="duration"> <em >'.__("Total Time:", 'purepress').'</em> <span class="value-title" title="'. convert_minutes_to_pt($preptime+$cooktime) .'">'. convert_minutes($preptime+$cooktime).'</span></li>';
        if($preptime)  $output .= '<li class="duration"> <em >'.__("Prep Time:", 'purepress').'</em> <span class="value-title" title="'. convert_minutes_to_pt($preptime) .'">'. convert_minutes($preptime).'</span></li>';
        if($cooktime)  $output .= '<li class="duration"> <em >'.__("Cook time:", 'purepress').'</em> <span class="value-title" title="'. convert_minutes_to_pt($cooktime) .'">'. convert_minutes($cooktime).'</span></li>';
        if($yield)  $output .= '<li > <em>'.__("Yield:", 'purepress').'</em> <span class="yield">'.$yield.'</span></li>';
        if(function_exists('the_ratings')) $output .= '<li class="review hreview-aggregate"><em>'.__("Rating:", 'purepress').'</em>  <span class="rating"><span class="average">'.$rating.'</span> '.__("stars - based on", 'purepress').'<span class="count"> '.$rating_nr.'</span> '.__("review(s)", 'purepress').'</span></li>';
        if($allergens) $output .= '<li>'.__("Allergens:", 'purepress').$allergens.'</li>';
        $output .= '</ul>';
    }

    if(!empty($nf_test)) {
        $output .= '<div class="nutrition">';
        $output .= '<em id="nutrition">'.__("Nutrition facts:", 'purepress').'</em>';
        $nfacts_lists = get_option('cookingpress_nutrition_facts');
        $i=0;
        foreach ($nfacts_lists as $k => $v) {
            if(!empty($nutrtion_facts[$i])) $output .=  ' <span class="type">'.$v['name'].'</span>: <span class="value"> '.$nutrtion_facts[$i].' '. $v['unit'].'</span>; ';
            $i++;
        }

        $output .= '</div>';
    }

    if($preptime || $cooktime || $yield || $fat || $calories ) {
        $output .= "</div>";
    }
    if($ingridients) {
        $output .= '<h4>'.__("Ingredients:", 'purepress').'</h4><ul class="ingredients">';
        foreach ($ingridients as $key => $value ) {
     
            if($value['note'] == 'separator') {
                $output .= '<li class="separator">'.$value['name'].'</li>' ;
            } else {
                $tag_id = get_tag_id_by_name($value['name']);
                if($recipe_tooltip == 'yes') { $tagdesc = tag_description($tag_id); }
                $output .= '<li class="ingredient ingridients-cont'; if($tagdesc) $output .= ' hasdesc ';
                $output .='"><a href="'.get_tag_link($tag_id).'">'.$value['name'].'</a> - <span>'.$value['note'].'</span>';
                if($tagdesc) $output .= '<div class="tooltip">'.get_term_photo_by_id($tag_id).$tagdesc.'</div>';
                $output .='</li>';
            }
        }
        $output .= "</ul>";
    }

    if($instructions) {
        $output .= '<h4>'.__("Instructions:", 'purepress').'</h4>
            <div class="instructions">'.wpautop($instructions,1).'</div>';
    }

    if(function_exists('pf_show_link')) {
        $output .= pf_show_link();
    }

    $output .= '</div></section></div>';
    return $output;

}
$recipe_format = get_option(PPTNAME . '_recipe_format');
if ($recipe_format == 'schema') {
    add_shortcode('purerecipe', 'purerecipe_schema');
} else {
    add_shortcode('purerecipe', 'purerecipe_h');
}




add_shortcode('puregallery', 'puregallery_flex');


$flex_count = 1;
function puregallery_flex($attr) {
    global $post;
    static $instance = 0;
    $instance++;
    global $flex_count;
    // Allow plugins/themes to override the default gallery template.
    if ( $output != '' )
        return $output;

    // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
        if ( !$attr['orderby'] )
            unset( $attr['orderby'] );
    }

    extract(shortcode_atts(array(
            'order'      => 'ASC',
            'orderby'    => 'menu_order ID',
            'id'         => $post->ID,
            'include'    => '',
            'exclude'    => ''
            ), $attr));

    $id = intval($id);
    if ( 'RAND' == $order )
        $orderby = 'none';

    if ( !empty($include) ) {
        $include = preg_replace( '/[^0-9,]+/', '', $include );
        $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif ( !empty($exclude) ) {
        $exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
        $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    } else {
        $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    }

    if ( empty($attachments) )
        return '';

    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment )
            $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
        return $output;
    }

    $i = 0;
    $output .= '
     <script type="text/javascript">
            (function($){
    $(document).ready(function(){
                $("#flexslider'.$flex_count.'").flexslider({
                    manualControls: "ul#flex-nav li",
                    after: function(slider) {
                       var curr = $("div#es-carousel'.$flex_count.' li.active").index();
                       $("div#es-carousel'.$flex_count.'").elastislide("setCurrent", curr );
                
                      
                    }
                });
                $("div#es-carousel'.$flex_count.'").elastislide({
                    imageW  : 119,
                    onClick  :  function( $item ) {
                        $("div#es-carousel'.$flex_count.' li").removeClass("current");
                   
                        $item.addClass("current");
                        current	= $item.index();
                        $("div#es-carousel'.$flex_count.'").elastislide("setCurrent", current );
                    }
                })
                 
                });
        })(this.jQuery);
        </script>
    <div id="flexslider'.$flex_count.'" class="flexslider"> <ul class="slides">';
    foreach ($attachments as $attach => $attachment) {
        $link_big = wp_get_attachment_image_src($attach, 'slider-big', false);

        $metadata = wp_get_attachment_metadata($attach);
        $alt = $attachment->post_excerpt;
        $desc = $attachment->post_content;
        $output .= '<li>';
        $output .= '<img src="' . $link_big[0] . '" width="' . $link_big[1] . '" height="' . $link_big[2] . '" alt="' . $alt . '" />';
        if (!empty($desc)) {
            $output .= '<p class="flex-caption">'.$desc.'</p>';
        }
        $output .= '</li>';
    }

    $output .= '</ul><div class="rg-thumbs"><div class="es-carousel-wrapper" id="es-carousel'.$flex_count.'"><div class="es-carousel"><ul id="flex-nav">';
    foreach ($attachments as $attach => $attachment) {
        $thumb = wp_get_attachment_image_src($attach, 'recipe-thumb', false);
        $output .= '<li><a href="#"><img src="' . $thumb[0] . '" width="119" height="70" /></a></li>';
    }
    $output .= '</ul></div></div></div></div>';
    $flex_count++;
    return $output;
}

?>