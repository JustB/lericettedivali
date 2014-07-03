<!DOCTYPE html>
<!--[if lt IE 7 ]><html <?php language_attributes(); ?> class="no-js ie ie6 lte7 lte8 lte9"><![endif]-->
<!--[if IE 7 ]><html <?php language_attributes(); ?> class="no-js ie ie7 lte7 lte8 lte9"><![endif]-->
<!--[if IE 8 ]><html <?php language_attributes(); ?> class="no-js ie ie8 lte8 lte9"><![endif]-->
<!--[if IE 9 ]><html <?php language_attributes(); ?> class="no-js ie ie9 lte9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->
    <head>

        <meta charset="<?php bloginfo('charset'); ?>" />
        <title>
        <?php 
            if ( is_search() ) { 
                bloginfo('name');  echo " - Search recipes "; echo the_search_query();
            } else {
                bloginfo('name'); ?> - <?php is_home() ? bloginfo('description') : wp_title('');
            } ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=Edge;chrome=1" >
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
        <!-- fonts -->
        
         <script type="text/javascript">
             var ie7 = (document.all && !window.opera && window.XMLHttpRequest) ? true : false;
           if(!ie7){
             <?php $font = get_option(PPTNAME . '_recipe_font'); if(empty($font)) $font= 'Satisfy'?>
              WebFontConfig = {
                google: { families: [ 'Droid Serif', 'Droid Sans', '<?php echo $font; ?>', 'PT Sans' ] }
              };
              (function() {
                var wf = document.createElement('script');
                wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
                    '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
                wf.type = 'text/javascript';
                wf.async = 'true';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(wf, s);
              })();
              }
        </script>
    <style type="text/css">
      .wf-loading  { font-family: serif } .wf-inactive {font-family: serif } .wf-loading { font-family: serif; font-size: 16px }
     </style>
<!--[if IE 8]>
            <style type="text/css">
                img.size-large, img.size-full{ width:auto;}
            </style>
        <![endif]-->
        <!-- style.css -->
        <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
        <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/css/reset.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/css/less.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/css/prettyPhoto.css" type="text/css" media="screen" />

        <link rel="stylesheet" media="screen, print" href="<?php bloginfo('stylesheet_url'); ?>" />

        <?php colour_theme() ?>
        

  <!--[if lt IE 9]><link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/css/ie7.css" type="text/css" media="screen" /><![endif]-->
        
        <?php if (is_singular())
            wp_enqueue_script('comment-reply'); ?>
        <?php wp_enqueue_script('jquery'); ?>
        <?php wp_head(); ?>

        <?php if (get_option(PPTNAME . '_custom_font') == 'cufon') { ?>
            <script src="<?php echo get_template_directory_uri() ?>/js/cufon-yui.js" type="text/javascript"></script>
            <script src="<?php echo get_template_directory_uri() ?>/js/fonts/geo-sans-light.cufonfonts.js" type="text/javascript"></script>
            <script type="text/javascript">
                Cufon.replace('h1,h2,h3,h4,.read-more,#nav', { fontFamily: 'GeosansLight', hover: true });
            </script>
        <?php } ?>

    </head>


    <body <?php body_class(); ?>>
        <div class="container clearfix">
            <header role="main" class="main clearfix">
                <h1>
                    <a href="<?php echo home_url('/'); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"><?php bloginfo('name'); ?></a>
                    <?php if (get_option(PPTNAME . '_blogdesc_remove ') == "Yes") { ?>
                    <span id="desc"><?php bloginfo('description'); ?></span>
                        <?php } ?>
                </h1>
                <?php get_template_part('nav'); ?>

            </header>
        </div>
        <?php
        $slider_type = get_option(PPTNAME.'_slider_type');
        if (is_home() && $slider_type != 'none') { ?>


        <div id="featured-container">
            <div class="container clearfix">
                <?php get_template_part( get_option(PPTNAME . '_slider_script').'-slider' );?>
            </div>
        </div>
        <?php } ?>

        <?php
        if ( is_page_template('template-codaslider.php')) {
            remove_action('wp_footer', 'flexslider_init');
            add_action('wp_footer', 'coda_slider_init');
                echo '<div id="featured-container"><div class="container clearfix">';
                    get_template_part( 'coda-slider' );
                echo '</div></div>';
        }

        if ( is_page_template('template-flexslider.php')) {
             remove_action('wp_footer', 'coda_slider_init');
            add_action('wp_footer', 'flexslider_init');
                echo '<div id="featured-container"><div class="container clearfix">';
                    get_template_part( 'flex-slider' );
                echo '</div></div>';
        }

        ?>
        <div class="container bottom clearfix">
         


