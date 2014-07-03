<?php
/*
 * PurePress panel
 * @version 1.2
 * http://purethemes.net
 * author rzepak
 *
 */

// admin scripts
wp_register_script('purepress-scripts', get_template_directory_uri() . '/backend/js/script.js');
wp_register_style('photopassion-css', get_template_directory_uri() . '/backend/css/photopassion.admin.css');
wp_register_style('jquery-ui-custom', get_template_directory_uri() . '/backend/css/jquery-ui-custom.css');
wp_register_script('purecolorpicker', get_template_directory_uri() . '/backend/js/colorpicker.js');
wp_register_style('purecolorpicker', get_template_directory_uri() . '/backend/css/colorpicker.css');

function load_my_script() {
    global $pagenow;
    if (is_admin() && $pagenow == 'post-new.php' OR $pagenow == 'post.php') {
        wp_enqueue_script('justurl');
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-tabs');
        wp_enqueue_script('jquery-ui-widget');
        wp_enqueue_script('jquery-ui-draggable');
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script('jquery-ui-droppable');
        wp_enqueue_script('autocomplete', get_template_directory_uri() . '/backend/js/jquery.ui.autocomplete.js', array('jquery', 'jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-position'));
        wp_enqueue_script('thickbox');
        wp_enqueue_style('thickbox');
        wp_enqueue_style('photopassion-css');
        wp_enqueue_script('purecolorpicker');
        wp_enqueue_style('purecolorpicker');
        wp_enqueue_style('jquery-ui-custom');
        wp_enqueue_script('media-upload');
        wp_enqueue_script('purepress-scripts');
        wp_enqueue_script('ppfarbtastic');
        wp_enqueue_script('jquery-appendo', get_template_directory_uri() . '/backend/js/jquery.appendo.js', false, '1.0', false);
    }

    if (is_admin() && $pagenow == 'admin.php') {
       
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-tabs');
        wp_enqueue_script('jquery-ui-widget');
        wp_enqueue_script('purecolorpicker');
        wp_enqueue_style('purecolorpicker');
        wp_enqueue_script('thickbox');
        wp_enqueue_style('thickbox');
        wp_enqueue_script('media-upload');
    }
}

add_action('admin_init', 'load_my_script');

function add_googleplusone() {
    echo '<script type="text/javascript" src="http://apis.google.com/js/plusone.js"></script>';
}
add_action('wp_footer', 'add_googleplusone');


function purepress_admin_menu() {
    global $themename, $shortname, $options;
    if (isset($_GET['page']) && $_GET['page'] == 'purepress-core.php') {
        $page = $_GET['page'];

        if ('save' == isset($_REQUEST['action'])) {

            foreach ($options as $value) {
                if (isset($_REQUEST[$value['id']])) {
                    if ($value['type'] == 'textarea')
                        $_REQUEST[$value['id']] = stripslashes($_REQUEST[$value['id']]); {
                        update_option($value['id'], $_REQUEST[$value['id']]);
                    }
                } else {
                    delete_option($value['id']);
                }

                if ($value['type'] == 'checkbox_multiple' && is_array($value['std']) && get_option($value['id'] . '_status') !== 'saved')
                    update_option($value['id'] . '_status', 'saved');
                if($value['type'] == 'ntfacts') {
                     $data = array();
                     foreach ($_REQUEST[$value['id'] . '_name'] as $k => $v) {
                        $data[] = array(
                            'name' => $v,
                            'unit' => $_REQUEST[$value['id'] . '_unit'][$k],
                        );
                    }
                    update_option($value['id'], $data);
                }

                if ($value['type'] == 'colorpicker')
                    update_option($value['id'] . '_enabler', $_REQUEST[$value['id'] . '_enabler']);
            }
            header("Location: admin.php?page=" . $page . "&saved=true");
            die;
        } else if ('reset' == isset($_REQUEST['action'])) {

            foreach ($options as $value) {
                delete_option($value['id']);
                $$value['id'] = $value['std'];
                if ($value['type'] == 'checkbox_multiple' && is_array($value['std'])) {
                    update_option($value['id'] . '_status', 'unsaved');
                    update_option($value['id'], $value['std']);
                }
                if (($value['type'] == 'text' || $value['type'] == 'exclude' || $value['type'] == 'colorpicker' || $value['type'] == 'upload') && $value['std'] !== '')
                    update_option($value['id'], $value['std']);
            }

            header("Location: admin.php?page=" . $page . "&saved=true");
            die;
        }
    }
}

function purepress_admin() {
    global $themename, $shortname, $options;

    if (isset($_REQUEST['saved']))
        echo '<div id="message" class="updated fade"><p><strong>' . $themename . ' settings saved.</strong></p></div>';
    if (isset($_REQUEST['reset']))
        echo '<div id="message" class="updated fade"><p><strong>' . $themename . ' settings reset.</strong></p></div>';
    ?>
    <?php require_once(TEMPLATEPATH . '/backend/js/js.php'); ?>
    <?php require_once(TEMPLATEPATH . '/backend/css/css.php'); ?>

    <form method="post" action="" id="optionspanel" enctype="multipart/form-data">
        <div id="panel-wrapper">
            <div id="top" class="ui-corner-all">
                <h1>
    <?php echo $themename; ?>
                    <span><?php _e( 'Options Panel', 'purepress' ); ?></span>
                </h1>
 <input name="save" type="submit" class="button-primary" value="<?php _e('Save changes', 'purepress'); ?>"  style="margin-top:30px;"/>
            </div>
            <div id="tabs">
    <?php ppoptionstabsCreator($options); ?>
    <?php ppoptionsCreator($options); ?>
            </div>

        </div><!-- end panel-wrapper -->
        <div id="savebar">

            <input name="save" type="submit" class="button-primary" value="<?php _e('Save changes', 'purepress'); ?>"  />
            <input type="hidden" name="action" value="save" />
        </div>
    </form>
    <form method="post" action="admin.php?page=purepress-core.php" class="reset">
        <p><?php _e("You can reset ALL settings and delete theme related options, by pressing button below:", 'purepress'); ?></p>
        <p class="submit">

            <input name="reset" type="submit" value="Reset" style="border:1px solid red"/>
            <input type="hidden" name="action" value="reset" />
        </p>
    </form>
<?php }

function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

?>
