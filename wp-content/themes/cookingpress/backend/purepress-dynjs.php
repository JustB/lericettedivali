<?php
/**
 * AJAX functions for WordPress
 *
 * @package WordPress
 * @subpackage CookingPress
 * @since CookingPress 1.0
 */
$slider_type = get_option(PPTNAME . '_slider_type');
$slider_script = get_option(PPTNAME . '_slider_script');
if ($slider_type == 'none' || empty($slider_type)) {

} else {
    if ($slider_script == 'coda')
        add_action('wp_footer', 'coda_slider_init');
    if ($slider_script == 'flex')
        add_action('wp_footer', 'flexslider_init');
}

function coda_slider_init() {

    if (is_single() == FALSE) {
        $slider_type = get_option(PPTNAME . '_slider_type');
        $slide_number;
        if ($slider_type == 'automatic') {
            $slide_number = get_option(PPTNAME . '_number_slides');
            if (get_option(PPTNAME . '_number_slides') != "") {
                $slide_number = get_option(PPTNAME . '_number_slides');
            } else {
                $slide_number = '5';
            }
        }
        if ($slider_type == 'manual') {
            global $slides;
            $slide_number = count($slides);
        }

        $autoslide_status = get_option(PPTNAME . '_autoslide_status');
        $autoslide_interval = get_option(PPTNAME . '_slider_interval');
        
        ?>

<script type="text/javascript" >
    (function($){
        $(window).load(function() {

            $("body").removeClass("coda-slider-no-js");

            $(".coda-slider").children('.panel').hide().end();

            $('#coda-slider-1').codaSlider({
                dynamicArrows: false,
                dynamicTabs: false
                <?php if( $autoslide_status == 'enable') { ?>,autoSlide: true,
                autoSlideInterval: <?php echo $autoslide_interval; ?>,
                autoSlideStopWhenClicked: true <?php } ?>
            });

            function codaresize(size) {
                $('.coda-slider, .coda-slider .panel').width(size).css('height','auto');
                var panelCount =  <?php echo $slide_number; ?>;
                var newheight = $('.coda-slider, .coda-slider .panel:first').height();
                var panelContainerWidth = size*panelCount;
                $('.coda-slider .panel-container').css({
                    width: panelContainerWidth
                });
                $('#coda-nav-1').height(newheight);
                var api = $('.coda-nav').jScrollPane().data('jsp');
                api.reinitialise({
                    contentWidth : 8,
                    verticalGutter : 0
                });

            }

            function codafit() {
                var codafit = $('.container').width();

                if(codafit == '950') {
                    codaresize(690);
                }
                if(codafit == '1030') {
                    codaresize(770);

                }
                if(codafit == '712') {
                    codaresize(502);
                }


            }
            codafit();

            $(window).resize(function () {
                codafit();

            });
            $('.coda-nav').jScrollPane({
                //    showArrows :true,
                contentWidth : 8,
                verticalGutter : 0
            });

        });





    })(this.jQuery);
</script>
        <?php
    }
}

function flexslider_init() {

    if (is_single() == FALSE) {
        $slider_type = get_option(PPTNAME . '_slider_type');
        $slide_number;
        if ($slider_type == 'automatic') {
            $slide_number = get_option(PPTNAME . '_number_slides');
            if (get_option(PPTNAME . '_number_slides') != "") {
                $slide_number = get_option(PPTNAME . '_number_slides');
            } else {
                $slide_number = '5';
            }
        }
        if ($slider_type == 'manual') {
            global $slides;
            $slide_number = count($slides);
        }
        ?>

<script type="text/javascript" >
    (function($){
        $(window).load(function() {
            $('.flexslider.main').flexslider({
                controlsContainer: "#flexmain-thumbs",

                manualControls: " ul li"

            });


        });

    })(this.jQuery);
</script>
        <?php
    }
}

if (get_option(PPTNAME . '_social_widget') == 'Yes') {
    add_action('wp_footer', 'social_widget_init');
}

function social_widget_init() {
    ?>

<script type="text/javascript" >
    (function($){
        $(window).load(function() {

            var elem = $(".socialize");
            var top = elem.offset().top;
            if ($('body').hasClass('single')) {
                var maxTop = $(".navigation").offset().top - elem.height()-50;
            } else {
                var maxTop = $(".contentinfo").offset().top - elem.height()-150;
            }
            var scrollHandler = function() {
                var scrollTop = $(window).scrollTop(),
                winwidth = $(window).width();
                if(winwidth > '991'){
                    if (scrollTop<top ) {
                        elem.css({
                            position:"relative",
                            top:""
                        })//should be "static" I think
                    } else if (scrollTop>maxTop) {
                        elem.css({
                            position:"absolute",
                            top:(maxTop+"px")
                        })
                    } else {
                        elem.css({
                            position:"fixed",
                            top:"0px"
                        })
                    }
                } else {
                    elem.css({
                        position:"static",
                        top:""
                    })
                }
            }

            $(window).scroll(scrollHandler);
            $(window).resize(scrollHandler);
            scrollHandler()


        });





    })(this.jQuery);
</script>
    <?php
}




function add_post_js_template() {
        wp_enqueue_style('jquery-ui-custom');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-widget');

        wp_enqueue_script('autocomplete', get_template_directory_uri() . '/backend/js/jquery.ui.autocomplete.js', array('jquery', 'jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-position'));
?>

<script type="text/javascript" >
    (function($){
        $(window).load(function() {
           <?php
                $tags = get_tags(array('hide_empty' => false));
                $tags_arr = array();
                foreach ($tags as $tag) {
                    array_push($tags_arr, $tag->name);
                }
            ?>
                            var availableTags = <?php echo json_encode($tags_arr); ?>;

                            $('#ingridients-sort input.ingridient').live('keyup.autocomplete', function(){
                                $(this).autocomplete({
                                    source: availableTags
                                });
                            });
                            $('.add_ingridient').click(function(e){
                                e.preventDefault();
                                    var newElem = $('tr.ingridients-cont.ing:first').clone();
                                newElem.find('input').val('');
                                newElem.appendTo('table#ingridients-sort');
                            })
                            $('.add_separator').click(function(e){
                                e.preventDefault();
                                var newElem = $('<tr class="ingridients-cont separator"><td><input name="cookingpressingridients_name[]" type="text" class="ingridient"  value="" /></td><td><input name="cookingpressingridients_note[]" type="text" class="notes"  value="separator" /></td><td class="action"><a  title="Delete separator" href="#" class="delete" style="background-image:url(\'<?php echo get_admin_url(); ?>/images/no.png\');"><?php _e("Delete", 'purepress'); ?></a></td></tr>');
                                newElem.appendTo('table#ingridients-sort');
                            })

                            $('#ingridients-sort .delete').live('click',function(e){
                                e.preventDefault();
                                $(this).parent().parent().remove();
                            });
                      


                            $('form#new_post').submit(function(){
                                $('.box-error-outer').slideUp();
                                $('fieldset').removeClass('error');
                                var error = 0;
                                var title = $('input#title');
                                var ingridient = $('input.ingridient:first');
                              
                                
                                var data = {
                                    action: 'add_post',
                                    form: $('form#new_post').serialize()
                                };
                               
                                if(title.val().length == 0) {
                                    title.addClass('error');
                                    $('fieldset.title .box-error-outer').slideDown();
                                    error++;
                                } 
                                if(ingridient.val().length == 0) {
                                    $('fieldset.ingridients').addClass('error');
                                    $('fieldset.ingridients .box-error-outer').slideDown();
                                    error++;
                                }
                                if($("textarea#cookingpressinstructions").val().length < 2){
                                    $('fieldset.instructions').addClass('error');
                                    $('fieldset.instructions .box-error-outer').slideDown();
                                    error++;
                                }
                                // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
                                console.log(error);
                                if(error==0) {
                                    $('fieldset.submit span').css('display','block');
                                    $.post(ajaxurl, data, function(response) {
                                        $('html, body').animate({
                                            scrollTop:0
                                        }, 'slow');
                                        $('form#new_post').slideUp();
                                        $('.box-ok-outer').slideDown();
                                        $('fieldset.submit span').hide();
                                    });
                                } else {
                                    $('fieldset.submit span').hide();
                                }
                               

                              return false;
                            })
                            
                    });
                })(this.jQuery);
</script>
    <?php
}
add_action( 'wp_ajax_nopriv_add_post', 'add_post_callback' );
add_action('wp_ajax_add_post', 'add_post_callback');

function add_post_callback() {
    global $wpdb; // this is how you get access to the database

    $form =  $_POST['form'];
    parse_str($form, $output);

   
    $title =  wp_strip_all_tags($output['title']);
   
    $description = mysql_real_escape_string($output['description']);
    $summary = mysql_real_escape_string($output['cookingpresssummary']);

    $tags = $output['cookingpressingridients_name'];

    $ingredients = array();
    foreach ($output['cookingpressingridients_name'] as $k => $v) {
        $ingredients[] = array(
                'name' => $v,
                'note' => mysql_real_escape_string($output['cookingpressingridients_note'][$k]),
        );
    }

    $instructions = $output['cookingpressinstructions'];

    $recipeoptions = array(
            mysql_real_escape_string($output['cookingpressrecipeoptions_preptime']),
            mysql_real_escape_string($output['cookingpressrecipeoptions_cooktime']),
            mysql_real_escape_string($output['cookingpressrecipeoptions_yield']),
    );

    $ntfacts = mysql_real_escape_string($output['cookingpressntfacts']);
    $serving = mysql_real_escape_string($output['serving']);
    $level = mysql_real_escape_string($output['level']);

    // ADD THE FORM INPUT TO $new_post ARRAY
    $new_post = array(
            'post_title'	=>	$title,
            'post_content'	=>	$description,
            'post_category'	=>	array($output['cat']),  // Usable for custom taxonomies too
            'post_status'	=>	'draft',           // Choose: publish, preview, future, draft, etc.
            'post_type'	=>	'post'  //'post',page' or use a custom post type if you want to
    );

    //SAVE THE POST
    $pid = wp_insert_post($new_post);

    //SAVE THE POST META
    add_post_meta($pid, 'cookingpressingridients', $ingredients, true);
    add_post_meta($pid, 'cookingpressinstructions', $instructions, true);
    add_post_meta($pid, 'cookingpressrecipeoptions', $recipeoptions, true);
    add_post_meta($pid, 'cookingpressntfacts', $ntfacts, true);
    add_post_meta($pid, 'cookingpresssummary', $summary, true);

    //SET OUR TAGS UP PROPERLY
    wp_set_post_tags($pid, $tags);

    //SET CUSTOM TAXONOMIES
    wp_set_object_terms($pid, $level, 'level');
    wp_set_object_terms($pid, $serving, 'serving');

    die(); // this is required to return a proper result
}



















add_action( 'wp_footer', 'custom_stylesheet_content' );
function custom_stylesheet_content() { ?>
<style type="text/css">
    <?php $logo = get_option(PPTNAME.'_logo_url');

    if (!empty($logo)) {
        $logo_w = get_option(PPTNAME.'_logo_width');
        $logo_h = get_option(PPTNAME.'_logo_height');

        if ($logo_w && $logo_h) {
            ?>
    header h1 a{
        background: url(<?php echo $logo; ?>) no-repeat;
        width:<?php echo $logo_w?>px;
        height:<?php echo $logo_h?>px;
        text-indent:-9999px;
        display:block;
    }
    #nav {
        margin-top: <?php echo $logo_h/2?>px;
    }
            <?php  } else {
            list($width, $height) = getimagesize($logo);
            ?>
    header h1 a {
        background: url(<?php echo $logo ?>) no-repeat;
        width:<?php echo $width?>px;
        height:<?php echo $height?>px;
        text-indent:-9999px;
        display:block;
    }
    #nav {
        margin-top: <?php echo $height/2?>px;
    }
            <?php
        }

    }


    if (get_option(PPTNAME.'_custom_colours')== "Yes") {
        if ( get_option(PPTNAME.'_footer_bgcolor_enabler') == true ) {?>
    body #pattern-container {
        background-color: #<?php echo get_option(PPTNAME.'_footer_bgcolor'); ?>;
        border-top:none;
        background-image: none
    }
            <?php }
        if ( get_option(PPTNAME.'_bgcolor_enabler') == true ) {?>
    body{
        background: #<?php echo get_option(PPTNAME.'_bgcolor'); ?>;
        border-top:none;
    }
    h3#comments-title span,
    .page .published-time span, .single .published-time span,
    #sidebar h3 span {
        background: #<?php echo get_option(PPTNAME.'_bgcolor'); ?>;
    }
            <?php }
        if ( get_option(PPTNAME.'_bgcolorsbwhite_enabler') == true ) {?>
    body{
        background: url("<?php bloginfo(template_url) ?>/images/bg/content-bg.png") repeat scroll center center #<?php echo get_option(PPTNAME.'_bgcolorsbwhite'); ?>;
        border-top:none;
    }
    h3#comments-title span,
    .page .published-time span, .single .published-time span {
        background: #<?php echo get_option(PPTNAME.'_bgcolorsbwhite'); ?>;
    }
            <?php }

        if ( get_option(PPTNAME.'_menu_bgcolor_enabler') == true ) {?>
    #nav ul.menu ul,
    #nav ul {
        background-color: #<?php echo get_option(PPTNAME.'_menu_bgcolor'); ?>;
        border-radius: 5px;
    }
            <?php }
        if ( get_option(PPTNAME.'_menu_color_enabler') == true ) {?>
    #nav ul.menu li a{
        color: #<?php echo get_option(PPTNAME.'_menu_color'); ?>;
    }
            <?php }
        if ( get_option(PPTNAME.'_menu_hover_bgcolor_enabler') == true ) {?>
    .current-menu-ancestor, .current-menu-item,
    #nav ul.menu li.active > a,
    #nav ul.menu > li ul li a:hover,
    #nav ul.menu li:hover{
        background-color: #<?php echo get_option(PPTNAME.'_menu_hover_bgcolor'); ?>;
    }
            <?php }

        ?>


        <?php }

    if (get_option(PPTNAME.'_custom_font') == 'arial') { ?>
    body,
    h1, h2, h3, h4, h5, h6,
    article.page h2.entry-title, article.post h2.entry-title,
    #nav ul,
    #sidebar h3 {
        font-family: 'Helvetica','Arial', sans-serif;
    }
        <?php }
    if (get_option(PPTNAME.'_custom_font') == 'ptsans') { ?>

    h1, h2, h3, h4, h5, h6,
    article.page h2.entry-title, article.post h2.entry-title,
    #nav ul,
    #sidebar h3 {
        font-family: 'PT Sans', sans-serif;
    }
        <?php }

    $font = get_option(PPTNAME . '_recipe_font');
    if(empty($font)) $font = 'Satisfy';
    $font = str_replace('::latin','',$font);
    $font = str_replace('+',' ',$font);

    ?>
    .purerecipe.tearedh h4, .purerecipe.tearedh h3 {
        font-family: "<?php echo $font; ?>", "Georgia", serif;
    }

    <?php $footer_bg = get_option(PPTNAME . '_footer_bg');
    if(empty($footer_bg)) $footer_bg = 'pattern.jpg'; ?>
    #pattern-container {
        box-shadow:0 -1px 6px rgba(0, 0, 0, .3);
        border:0px;
        background: url("<?php echo get_stylesheet_directory_uri() ;?>/images/bg/<?php echo $footer_bg; ?>");
    }


    <?php
    $height = get_option(PPTNAME.'_slider_height' );
    $heightp = round($height-24-($height*0.13));
    $heighth = $heightp - 64;
    if($height=='460px' || empty($height)) { ?>
    .panel-wrapper h2 {
        top:<?php echo $heighth; ?>px;
    }
    .panel-wrapper p {
        top:<?php echo $heightp; ?>px;
    }
        <?php } else { ?>
    #featured {
        max-height: <?php echo $height; ?>px;
        overflow: hidden;
    }
    .panel-wrapper h2 {
        top:<?php echo $heighth; ?>px;
    }
    .panel-wrapper p {
        top:<?php echo $heightp; ?>px;
    }
        <?php }
    ?>

    <?php echo get_option(PPTNAME.'_custom_css'); ?>
</style>
    <?php


}