<?php




add_action('admin_init', 'purepress_manager_init');

global $slides;

if(get_option('slides')) {
    $slides = get_option('slides');
} else {
    $slides = false;
}

// admin menu
function purepress_manager_admin_menu() {



    if(isset($_GET['page']) && $_GET['page'] == 'slidermanager') {
//
//        if(isset($_POST['action']) && $_POST['action'] == 'save') {
        // if ( 'save' == $_REQUEST['action'] ) {

        if ( isset($_POST['action']) ) {

            if ( 'save' == $_REQUEST['action'] ) {
                $slides = array();

                foreach($_POST['src'] as $k => $v) {
                    $slides[] = array(
                            'src' => $v,
                            'link' => $_POST['link'][$k],
                            'title' => $_POST['title'][$k],
                            'subtitle' => $_POST['subtitle'][$k]
                    );
                }


                update_option(PPTNAME.'_categories', $_POST['purephoto_categories'] );
                update_option(PPTNAME.'_number_slides', $_POST['purephoto_number_slides'] );
                update_option(PPTNAME.'_slider_type', $_POST['purephoto_slider_type']);
                update_option(PPTNAME.'_slider_height', $_POST['purephoto_slider_height']);
                update_option(PPTNAME.'_slider_rating', $_POST['purephoto_slider_rating']);
                update_option(PPTNAME.'_slider_script', $_POST['purephoto_slider_script']);
                update_option(PPTNAME.'_autoslide_status', $_POST['purephoto_autoslide_status']);
                update_option(PPTNAME.'_slider_interval', $_POST['purephoto_slider_interval']);
                update_option('slides', $slides);
                header("Location: admin.php?page=slidermanager&saved=true");
            }

        }

    }
}


// slider manager wrapper
function manager_wrap() {
    global $slides;


    ?>

<div class="wrap" id="manager_wrap">

    <form action="" id="manager_form" method="post">
        <div id="icon-options-general" class="icon32"></div>
        <h2><?php _e( 'Front page slider manager', 'purepress' ); ?></h2>
        <p><?php _e( 'Here\'s special option panel for setting up your slider.', 'purepress' ); ?></p>


        <h2><?php _e( 'Choose type of slider:', 'purepress' ); ?></h2>
        <table>
            <tr>
                <td>
                    <input type="radio" <?php if ( get_option( PPTNAME.'_slider_type' ) == 'automatic') {
                            echo ' checked="checked"';
                               } ?> name="purephoto_slider_type" value="automatic" id="automatic"/>
                </td>
                <td>
                    <label for="automatic"><strong><?php _e( 'Automating slider', 'purepress' ); ?></strong> <br/><span><?php _e( 'Slider\'s elements are created from your posts', 'purepress' ); ?></span></label>
                </td>
            </tr>
            <tr>
                <td><input type="radio" <?php if ( get_option( PPTNAME.'_slider_type' ) == 'manual') {
                            echo ' checked="checked"';
                               } ?>  name="purephoto_slider_type" value="manual" id="manual"/>
                </td>
                <td>
                    <label for="manual"><strong><?php _e( 'Manual slider', 'purepress' ); ?></strong> <br/><span><?php _e( 'Slider\'s elements need to be created by you, but it gives more control', 'purepress' ); ?></span></label>
                </td>
            </tr>
            <tr>
                <td><input type="radio" <?php if ( get_option( PPTNAME.'_slider_type' ) == 'none') {
                            echo ' checked="checked"';
                               } ?>  name="purephoto_slider_type" value="none" id="none"/>
                </td>
                <td>
                    <label for="none"><strong><?php _e( 'Disable slider', 'purepress' ); ?></strong> <br/><span><?php _e( 'Slider\'s won\'t be shown on homepage', 'purepress' ); ?></span></label>
                </td>
            </tr>
        </table>
        <h2><?php _e( 'Slider script settings:', 'purepress' ); ?></h2>
        <table>
          <tr>
                
                <td>
                    <label for="none"><strong><?php _e( 'Slider script', 'purepress' ); ?></strong> <br/></label>
                </td>
                <td>
                    <select name="purephoto_slider_script">
                        <option value="coda" <?php if ( get_option( PPTNAME.'_slider_script' ) == 'coda') { echo ' selected="selected"'; } ?>  >Coda Slider</option>
                        <option value="flex" <?php if ( get_option( PPTNAME.'_slider_script' ) == 'flex') { echo ' selected="selected"'; } ?> >Flex Slider</option>
                    </select>

                </td>
            </tr>
          <tr>

                <td>
                    <label for="none"><strong><?php _e( 'Show rating stars in slider (only automatic)?', 'purepress' ); ?></strong> <br/></label>
                </td>
                <td>
                    <select name="purephoto_slider_rating">
                        <option value="no" <?php if ( get_option( PPTNAME.'_slider_rating' ) == 'no') { echo ' selected="selected"'; } ?> >No, hide it</option>
                        <option value="yes" <?php if ( get_option( PPTNAME.'_slider_rating' ) == 'yes') { echo ' selected="selected"'; } ?>  >Yes, show it</option>
                    </select>

                </td>
 </tr>
          <tr>
                <td>
                    <label for="none"><strong><?php _e( 'Coda Slider autoslide status ?', 'purepress' ); ?></strong> <br/></label>
                </td>
                <td>
                    <select name="purephoto_autoslide_status">
                        <option value="enable" <?php if ( get_option( PPTNAME.'_autoslide_status' ) == 'enable') { echo ' selected="selected"'; } ?> >Enable</option>
                        <option value="disable" <?php if ( get_option( PPTNAME.'_autoslide_status' ) == 'disable') { echo ' selected="selected"'; } ?>  >Disable</option>
                    </select>
                </td>
                 </tr>
          <tr>
                <td>
                    <label for="none"><strong><?php _e( 'Coda Slider autoslide interval?', 'purepress' ); ?></strong> <br/></label>
                </td>
                <td>
                    <input type="text" value="<?php $height = get_option(PPTNAME.'_slider_interval' ); if($height) { echo $height; } else { echo '4000'; } ?>" name="purephoto_slider_interval" id="purephoto_slider_height" />
                </td>
            </tr>
        </table>
        <h2><?php _e( 'Choose slider size:', 'purepress' ); ?></h2>
        <table>
            <tr>
                <td>
                    <input type="text" value="<?php $height = get_option(PPTNAME.'_slider_height' ); if($height) { echo $height; } else { echo '460'; } ?>" name="purephoto_slider_height" id="purephoto_slider_height" />
                </td>
                <td>
                    <label for="automatic"><strong><?php _e( "Slider's height", 'purepress' ); ?> </strong> <br/>
                                <?php _e( " <span>Slider cannot have dynamic height, so you need to decide on one size. Default height is <strong>460px</strong>, width is always <strong>770px</strong></span> for standard view", 'purepress' ); ?></label>
                </td>
            </tr>

        </table>
      

        <div id="automatic-container">
            <h2><?php _e( "Automatic slider", 'purepress' ); ?></h2>
            <table >
                <tr>
                    <td>
                        <label for="purephoto_categories"><strong><?php _e( "Portfolio category", 'purepress' ); ?></strong><br/>
                                <?php _e( "Choose category you want to use as portfolio", 'purepress' ); ?>
                        </label>
                    </td>
                    <td>
                            <?php

                            $categories = get_categories();
                            $cats = get_cats($categories);
                            ?>
                        <select id="purephoto_categories" name="purephoto_categories">
                                <?php foreach ($cats as $key => $option) { ?>
                            <option <?php if ( get_option( PPTNAME.'_categories' ) == $key) {
                                        echo ' selected="selected"';
                                        } ?> value="<?php echo $key; ?>"><?php echo $option; ?>
                            </option>
                                    <?php } ?>
                        </select>
                    </td>

                </tr>

                <tr>
                    <td>
                        <label for="purephoto_number_slides"><strong><?php _e( "How many slides you want to show?", 'purepress' ); ?></strong><br/>
                                <?php _e( "(Type only number from 2-30)", 'purepress' ); ?>
                        </label>
                    </td>
                    <td>

                        <input type="text" value="<?php echo get_option(PPTNAME.'_number_slides' ); ?>" name="purephoto_number_slides" id="purephoto_number_slides" />
                    </td>

                </tr>
            </table>
        </div>



        <div id="manual-container">
            <h2><?php _e( "Manual slider", 'purepress' ); ?></h2>

            <ul id="manager_form_wrap">

                    <?php if(get_option('slides')) : ?>

                        <?php foreach($slides as $k => $slide) : ?>


                <li class="slide">
                    <div class="widgets-holder-wrap ">
                        <div class="sidebar-name">
                            <div class="sidebar-name-arrow"><br></div>
                            <h3>Slide: <span><?php echo $slide['title'] ?></span></h3>
                        </div>
                        <div class="slide-inside" >
                            <div style="overflow: hidden">

                                <p>
                                    <label id="<?php echo get_option_page_ID( 'purepress-data' ); ?>"><?php _e( "Source of image", 'purepress' ); ?><span><?php _e( "(required)", 'purepress' ); ?></span></label>
                                    <input type="text" style="width:40%" name="src[]" class="slide_src" value="<?php echo $slide['src'] ?>">
                                    <input type="button" value="Upload Image" class="button-primary upload_image_button">
                                </p>
                                <p>
                                    <label class="164"><?php _e( "Slide link (where user will go after clicking slide)", 'purepress' ); ?></label>
                                    <input type="text" style="width:100%" name="link[]" id="slide_link" value="<?php echo $slide['link'] ?>" />
                                </p>
                                <p>
                                    <label><?php _e( "Slide title", 'purepress' ); ?></label>
                                    <input type="text" name="title[]" style="width:100%" value="<?php echo $slide['title'] ?>" class="slide_title" />
                                </p>
                                <p>
                                    <label><?php _e( "Slide subtitle", 'purepress' ); ?></label>
                                    <input type="text" name="subtitle[]" style="width:100%" value="<?php echo $slide['subtitle'] ?>" class="slide_subtitle" />
                                </p>
                            </div>
                            <button class="remove_slide button-secondary"><?php _e( "Remove This Slide", 'purepress' ); ?></button>
                        </div>
                    </div>
                </li>
                        <?php endforeach; ?>
                    <?php else : ?>
                <li class="slide">
                    <div class="widgets-holder-wrap ">
                        <div class="sidebar-name">
                            <div class="sidebar-name-arrow"><br></div>
                            <h3>Slide <span>1</span></h3>
                        </div>
                        <div class="slide-inside" >
                            <div style="overflow: hidden">
                                <p>
                                    <label id="<?php  echo get_option_page_ID( 'purepress-data' ); ?>"><?php _e( "Source of image", 'purepress' ); ?> <span><?php _e( "(required)", 'purepress' ); ?></span></label>
                                    <input type="text" style="width:40%"  id="upload_image" name="src[]" class="slide_src">
                                    <input type="button" value="Upload Image" class="button-primary upload_image_button">
                                </p>
                                <p>
                                    <label class="164"><?php _e( "Slide link (where user will go after clicking slide)", 'purepress' ); ?></label>
                                    <input type="text" style="width:100%"  name="link[]" id="slide_link">
                                </p>
                                <p>
                                    <label><?php _e( "Slide title", 'purepress' ); ?></label>
                                    <input type="text"  name="title[]" style="width:100%"   class="slide_title"/>
                                </p>
                                <p>
                                    <label><?php _e( "Slide subtitle", 'purepress' ); ?></label>
                                    <input type="text" name="subtitle[]" style="width:100%"  class="slide_subtitle"/>
                                </p>
                            </div>
                            <button class="remove_slide button-secondary"><?php _e( "Remove This Slide", 'purepress' ); ?></button>
                        </div>
                    </div>
                </li>
                    <?php endif; ?>
            </ul>
        </div>
        <input type="submit" value="<?php _e( "Save Changes", 'purepress' ); ?>" id="manager_submit" class="button-primary">
        <input type="hidden" name="action" value="save">

    </form>

</div>

    <?php

}


// slider manager init
function purepress_manager_init() {

    if(isset($_GET['page']) && $_GET['page'] == 'slidermanager') {

        // scripts
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-sortable');


        wp_enqueue_script('jquery-appendo', MANAGER_URI . '/js/jquery.appendo.js', false, '1.0', false);
        wp_enqueue_script('slider-manager', MANAGER_URI . '/js/manager.js', false, '1.0', false);


        // styles
        wp_enqueue_style('slider-manager', MANAGER_URI . '/css/manager.css', false, '1.0', 'all');

    }

}
?>