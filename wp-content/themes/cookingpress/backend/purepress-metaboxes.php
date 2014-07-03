<?php
/**
 * Custom metaboxes
 *
 * @package WordPress
 * @subpackage CookingPress
 * @since CookingPress 1.0
 */
global $shortname;
$purepress_meta_boxes =
        array(

            "whichpostsidebar" => array(
                "name" => $shortname."whichpostsidebar",
                "std" => "Yes",
                "title" => __("Which Post Sidebar?", 'purepress'),
                "type" => "select",
                "options" => $customsidebars,
                "description" => __("Choose which sidebar you want to show", 'purepress')
            ),
            "featuredphotoid" => array(
                "name" => $shortname."featuredphotoid",
                "std" => "",
                "title" => __("Generate shortcode for gallery", 'purepress'),
                "type" => "text"
            ),
);

$recipe_meta_boxes =
        array(
            "title" => array(
                "name" => $shortname."title",
                "std" => "",
                "title" => __("Recipe title", 'purepress'),
                "type" => "text",
                "description" => __("It's neccessery for google rich snippet to put Title of recipe here, if empty - post title will be used", 'purepress')
            ),
            "recipetheme" => array(
                "name" => $shortname."recipetheme",
                "std" => "No",
                "title" => __("Recipe Theme", 'purepress'),
                "type" => "select",
                "options" => array(
                    'tearedh' => 'Torn paper 2',
                    'teared' => 'Torn paper 1',
                    'elegant' => 'Elegant',
                    'minimal' => 'Minimal'
                ),
                "description" => __("Choose if want to show sidebar next to post content", 'purepress')
            ),
            "summary" => array(
                "name" => $shortname."summary",
                "std" => "",
                "title" => __("Short summary of recipe", 'purepress'),
                "type" => "textarea",
                "description" => __("Short summary of recipe", 'purepress')
            ),
            "ingridients" => array(
                "name" => $shortname."ingridients",
                "std" => "",
                "title" => __("Ingredients", 'purepress'),
                "type" => "ingridients"
            ),
            "instructions" => array(
                "name" => $shortname."instructions",
                "std" => "",
                "title" => __("Instructions", 'purepress'),
                "type" => "instructions"
            ),
            "recipeoptions" => array(
                "name" => $shortname."recipeoptions",
                "std" => "",
                "title" => __("Recipe options", 'purepress'),
                "type" => "recipeoptions"
            ),
            "ntfacts" => array(
                "name" => $shortname."ntfacts",
                "std" => "",
                "title" => __("Nutrition facts", 'purepress'),
                "type" => "ntfacts"
            ),
        
            "servings" => array(
                "name" => $shortname."servings",
                "std" => "",
                "title" => __("Servings", 'purepress'),
                "type" => "select",
                "description" => __("How many servings", 'purepress')
            ),
            "level" => array(
                "name" => $shortname."level",
                "std" => "",
                "title" => __("Difficulty level", 'purepress'),
                "type" => "select",
                "description" => __("Select skill level required to use this recipe", 'purepress')
            ),
            "photo" => array(
                "name" => $shortname."photo",
                "std" => "",
                "title" => __("Photo", 'purepress'),
                "type" => "text"
            ),
);


/*
 * Create metaboxes below post
 */

function new_meta_boxes() {
    global $post, $purepress_meta_boxes;

    foreach ($purepress_meta_boxes as $meta_box) {

        $meta_box_value = get_post_meta($post->ID, $meta_box['name'] . '_value', true);
        if ($meta_box_value == "")
            $meta_box_value = $meta_box['std'];

        switch ($meta_box['type']) {

            case 'select':

                echo'<input type="hidden" name="' . $meta_box['name'] . '_noncename" id="' . $meta_box['name'] . '_noncename" value="' . wp_create_nonce(plugin_basename(__FILE__)) . '" />';
                ?>
                <div class="pp_select" id="<?php echo $meta_box['name']; ?>" >
                    <label><?php echo $meta_box['title']; ?></label>

                    <select style="width:240px;" name="<?php echo $meta_box['name'] . "_value"; ?>" id="<?php echo $meta_box['name']; ?>">

                <?php foreach ($meta_box['options'] as $key => $option) { ?>

                            <option <?php
                    if ($meta_box_value == $key) {
                        echo ' selected="selected"';
                    } elseif ($key == $meta_box['std']) {
                        echo ' selected="selected"';
                    }
                    ?> value="<?php echo $key; ?>"><?php echo $option; ?>
                            </option><?php } ?>
                    </select>
                    <span class="desc"> <?php echo $meta_box['description']; ?></span>
                </div>

                <?php
                break;
            case 'text':

                echo'<input type="hidden" name="' . $meta_box['name'] . '_noncename" id="' . $meta_box['name'] . '_noncename" value="' . wp_create_nonce(plugin_basename(__FILE__)) . '" />';
                ?>
                <div class="pp_select" id="<?php echo $meta_box['name']; ?>" >
                    <label><?php echo $meta_box['title']; ?></label>

                    <input style="width:320px" name="<?php echo $meta_box['name']; ?>_value" id="<?php echo $meta_box['name']; ?>" type="text" value="<?php
                if ($meta_box_value != "") {
                    echo $meta_box_value;
                } else {
                    echo "";
                }
                ?>" />
                    <?php
                    if ($meta_box['name'] == 'cookingpressfeaturedphotoid') {
                        $attachments = get_children(
                                array(
                                    'post_parent' => $post->ID,
                                    'post_status' => 'inherit',
                                    'post_type' => 'attachment',
                                    'post_mime_type' => 'image',
                                )
                        );
                        if (!empty($attachments)) {

                            echo '<img src="' . get_template_directory_uri() . '/images/ajaxmap.gif" id="gallloading" style="display:none"/>';
                            echo '';
                            echo '<ul id="gallery-exlude"  style="clear:both;overflow:hidden">';
                            $output = '';
                            foreach ($attachments as $attach => $attachment) {
                                $thumb = wp_get_attachment_image_src($attach, 'recipe-thumb', true);
                                $output .= '<li id=' . $attach . '>'; //105 x 75
                                $output .= '<img src="' . $thumb[0] . '" width="119" height="70" />';
                                $output .= '</li>';
                            }

                            echo $output;
                            echo '</ul>
                                        <p>
                                        <label>'.__("Order", 'purepress').'</lable>
                                        <select name="order" id="flexorder">
                                            <option value="asc">'.__("Ascending", 'purepress').'</option>
                                            <option value="desc">'.__("Descending", 'purepress').'</option>
                                        </select>
                                        </p>
                                        <p>
                                        <label>'.__("Order images by:", 'purepress').'</lable>
                                        <select name="orderby" id="flexorderby">
                                                <option selected="selected" value="menu_order">'.__("Menu order", 'purepress').'</option>
                                                <option value="title">'.__("Title", 'purepress').'</option>
                                                <option value="post_date">'.__("Date/Time", 'purepress').'</option>
                                                <option value="rand">'.__("Random", 'purepress').'</option>
                                        </select>
                                        </p>
                                        <input id="generated-code" value="[puregallery]" type="text" style="width:80%"/></br>
                                        '.__("Copy text from input above and paste it in Post Editor where you want to show gallery.", 'purepress').'
                                       <div class="clear"></div><br/>
                                       <input type="hidden" id="ppgallery-exlude" name="galleryexlude_value" value="' . $meta_box_value . '"/>';
                        }
                    }
                    ?>
                    <span class="desc"> <?php echo $meta_box['description']; ?></span>

                </div>

                           <?php
                           break;
                       case 'galleryexlude':


                           echo '<div class="pp-gallery-exluder">';
                           echo'<input type="hidden" name="' . $meta_box['name'] . '_noncename" id="' . $meta_box['name'] . '_noncename" value="' . wp_create_nonce(plugin_basename(__FILE__)) . '" />';

                           $attachments = get_children(
                                   array(
                                       'post_parent' => $post->ID,
                                       'post_status' => 'inherit',
                                       'post_type' => 'attachment',
                                       'post_mime_type' => 'image',
                                   )
                           );
                           if (!empty($attachments)) {
                               echo '<h4 class="pp_h4">' . __('Select photos you want to exclude from post <span>Excluded photos will have red border around them</span><span>You need to save post as a draft to see attached photos</span>', 'purepress') . '</h4>';
                               echo '<img src="' . get_template_directory_uri() . '/images/ajaxmap.gif" id="gallloading" style="display:none"/>';
                               echo '';
                               echo '<ul id="gallery-exlude" style="clear:both;overflow:hidden">';
                               $output = '';
                               foreach ($attachments as $attach => $attachment) {
                                   $thumb = wp_get_attachment_image($attach, 'slider-thumb', false);
                                   $output .= '<li id=' . $attach . '>';
                                   $output .= $thumb;
                                   $output .= '</li>';
                               }

                               echo $output;
                               echo '</ul>
               
                   <input type="hidden" id="ppgallery-exlude" name="galleryexlude_value" value="' . $meta_box_value . '"/>';
                           }
                           echo '</div><div style="clear:both"></div> ';
                           break;
                       case 'upload':
                           ?>
                <div class="upload pp-upload" >
                    <label id="<?php echo get_option_page_ID('purepress-data'); ?>"><?php echo $meta_box['title']; ?></label>
                    <input id="upload_image" class="upload_field" type="text" size="36" name="<?php echo $meta_box['name'] . '_value'; ?>" value="<?php
                if ($meta_box_value != "") {
                    echo $meta_box_value;
                }
                ?>" />
                    <?php echo'<input type="hidden" name="' . $meta_box['name'] . '_noncename" id="' . $meta_box['name'] . '_noncename" value="' . wp_create_nonce(plugin_basename(__FILE__)) . '" />'; ?>
                    <input id="upload_image_button" type="button" value="Upload Image"  />
                    <p><span class="desc"> <?php echo $meta_box['description']; ?></span></p>

                </div>
                           <?php
                           break;
                   }
               }
           }

           function recipe_meta_boxes() {
               global $post, $recipe_meta_boxes;

               foreach ($recipe_meta_boxes as $meta_box) {

                   $meta_box_value = get_post_meta($post->ID, $meta_box['name'], true);
                   if ($meta_box_value == "")
                       $meta_box_value = $meta_box['std'];

                   switch ($meta_box['type']) {

                       case 'select':
                           echo'<input type="hidden" name="' . $meta_box['name'] . '_noncename" id="' . $meta_box['name'] . '_noncename" value="' . wp_create_nonce(plugin_basename(__FILE__)) . '" />';
                           ?>
                <div class="pp_select" id="<?php echo $meta_box['name']; ?>" >
                    <label><?php echo $meta_box['title']; ?></label>

                <?php
                if ($meta_box['name'] == "cookingpressservings") {
                    $servings = get_terms('serving', 'hide_empty=0');
                    
                    ?>


                        <select style="width:240px;" name="<?php echo $meta_box['name']; ?>" id="<?php echo $meta_box['name']; ?>">

                        <?php
                        $names = wp_get_object_terms($post->ID, 'serving');
                        //print_r($names);
                        ?>
                            <option class='theme-option' value='' 
                            <?php if (!count($names))
                                echo "selected"; ?>><?php _e('None', 'purepress'); ?></option>
                            <?php
                            foreach ($servings as $serving) {
                                if (!is_wp_error($names) && !empty($names) && !strcmp($serving->slug, $names[0]->slug))
                                    echo "<option class='theme-option' value='" . $serving->slug . "' selected>" . $serving->name . "</option>\n";
                                else
                                    echo "<option class='theme-option' value='" . $serving->slug . "'>" . $serving->name . "</option>\n";
                            }
                            ?>

                        </select>
                        <span class="desc"><?php _e(' You can manage Servings options here', 'purepress'); ?></span>
                                <?php } else if ($meta_box['name'] == "cookingpresslevel") {
                                    $levels = get_terms('level', 'hide_empty=0'); ?>
                        <select style="width:240px;" name="<?php echo $meta_box['name']; ?>" id="<?php echo $meta_box['name']; ?>">

                        <?php
                        $names = wp_get_object_terms($post->ID, 'level');
                        //print_r($names);
                        ?>
                            <option class='theme-option' value=''
                            <?php if (!count($names))
                                echo "selected"; ?>><?php _e('None', 'purepress'); ?></option>
                            <?php
                            foreach ($levels as $level) {
                                if (!is_wp_error($names) && !empty($names) && !strcmp($level->slug, $names[0]->slug))
                                    echo "<option class='theme-option' value='" . $level->slug . "' selected>" . $level->name . "</option>\n";
                                else
                                    echo "<option class='theme-option' value='" . $level->slug . "'>" . $level->name . "</option>\n";
                            }
                            ?>

                        </select>

                                <?php } else { ?>

                        <select style="width:240px;" name="<?php echo $meta_box['name']; ?>" id="<?php echo $meta_box['name']; ?>">
                    <?php foreach ($meta_box['options'] as $key => $option) { ?>
                                <option <?php
                        if ($meta_box_value == $key) {
                            echo ' selected="selected"';
                        } elseif ($key == $meta_box['std']) {
                            echo ' selected="selected"';
                        }
                        ?> value="<?php echo $key; ?>"><?php echo $option; ?>
                                </option><?php } ?>
                        </select>
                        <?php } ?>
                    <span class="desc"> <?php echo $meta_box['description']; ?></span>
                </div>

                    <?php
                    break;
                case 'text':

                    echo'<input type="hidden" name="' . $meta_box['name'] . '_noncename" id="' . $meta_box['name'] . '_noncename" value="' . wp_create_nonce(plugin_basename(__FILE__)) . '" />';
                    ?>
                <div class="pp_select" id="<?php echo $meta_box['name']; ?>" >

                    <label <?php if ($meta_box['name'] == 'photo') {
                    echo 'style="display:none;"';
                } ?>><?php echo $meta_box['title']; ?></label>

                    <input  style="width:320px" name="<?php echo $meta_box['name']; ?>" id="<?php echo $meta_box['name']; ?>"
                <?php if ($meta_box['name'] == 'photo') {
                    echo 'type="hidden"';
                } else {
                    echo 'type="text"';
                } ?>  value="<?php
                if ($meta_box_value != "") {
                    echo $meta_box_value;
                } else {
                    echo "";
                }
                ?>" />

                    <?php
                    if ($meta_box['name'] == 'cookingpressphoto') {
                        echo '<h3>' . __('Drag photo from thumbnails to set Recipe photo (if you don\'t do that, Post Thumbnail will be used) ', 'purepress') . '</h3>';
                        echo '<span style="display:block;font-size:11px; margin-top:5px;">'.__("You need to save post as a draft if you can't see attached photos", 'purepress').'</span>';
                        echo '<br/><strong>'.__("Drop photo here", 'purepress').'</strong>  <div id="recipe-drop-area"></div>'; ?>
                        <a href="#" id="remove-recipe-photo"><?php _e('Remove photo', 'purepress'); ?></a> <?php
                    }
                    ?>
                    <span class="desc"> <?php echo $meta_box['description']; ?></span>
                </div>

                <?php
                break;
            case 'recipeoptions':
                echo'<input type="hidden" name="' . $meta_box['name'] . '_noncename" id="' . $meta_box['name'] . '_noncename" value="' . wp_create_nonce(plugin_basename(__FILE__)) . '" />';
                //preptime cooktime yield calories fat  
                ?>
                <div class="pp_select" id="recipeoptions">
                    <h3><?php _e("Recipe informations:", 'purepress'); ?></h3>
                    <span class="desc"> <?php _e("Filling this form is optional, empty fields won't be used in post. Put time in minutes, it will be converted to hours or days if neccessery", 'purepress'); ?></span>
                    <p><?php _e("Preparation time for this recipe is ", 'purepress'); ?><input style="width:50px" name="<?php echo $meta_box['name'] . '_preptime'; ?>" id="preptime" type="text" value="<?php if ($meta_box_value[0] != "") {
                                          echo $meta_box_value[0];
                                      } else {
                                          echo "";
                                      } ?>" /><?php _e("minutes", 'purepress'); ?>,

                       <?php _e(" and cooking time takes", 'purepress'); ?> <input style="width:50px" name="<?php echo $meta_box['name'] . '_cooktime'; ?>" id="cooktime" type="text" value="<?php if ($meta_box_value[0] != "") {
                          echo $meta_box_value[1];
                      } else {
                          echo "";
                      } ?>" /> <?php _e("minutes", 'purepress'); ?>.

                        <?php _e("Yield is", 'purepress'); ?> <input style="width:80px" name="<?php echo $meta_box['name'] . '_yield'; ?>" id="yield" type="text" value="<?php if ($meta_box_value[0] != "") {
                    echo $meta_box_value[2];
                } else {
                    echo "";
                } ?>" />

                </div>
                <?php
                break;
                case 'ntfacts':
                    echo'<input type="hidden" name="' . $meta_box['name'] . '_noncename" id="' . $meta_box['name'] . '_noncename" value="' . wp_create_nonce(plugin_basename(__FILE__)) . '" />';
                    $nfacts_lists = get_option('cookingpress_nutrition_facts');
                  
                ?>
                <h3><?php _e("Recipe facts:", 'purepress'); ?></h3>
                    <ul id="nutritionfacts_list">
                    <?php 
               
                    $i=0;
                    if(!empty($nfacts_lists)) {
                        if(empty($meta_box_value)) {
                        foreach ($nfacts_lists as $k => $v) {
                            echo '<li>'. $v['name'];
                            echo '<input type="text" name="'.$meta_box['name'].'[]" />';
                            echo  $v['unit'].'</li>';
                        }
                        } else {
                            foreach ($nfacts_lists as $k => $v) {
                            echo '<li>'. $v['name'];
                            echo '<input type="text" name="'.$meta_box['name'].'[]" value="'.$meta_box_value[$i].'"/>';
                            echo  $v['unit'].'</li>'; $i++;
                        }
                        }
                    } ?>
                    </ul>
                    <?php
                break;
            case 'textarea':
                echo'<input type="hidden" name="' . $meta_box['name'] . '_noncename" id="' . $meta_box['name'] . '_noncename" value="' . wp_create_nonce(plugin_basename(__FILE__)) . '" />';
                ?>


                <div class="pp_select"> 
                    <h3><?php echo $meta_box['title']; ?></h3>
                    <?php
                    $editor_settings = array(
                        'media_buttons' => false,
                        'textarea_rows' => '5',
                        'teeny' => true
                    );
                    wp_editor($meta_box_value, $meta_box['name'], $editor_settings);
                    ?>
                </div>
                <?php
                break;

            case 'ingridients':
                echo'<input type="hidden" name="' . $meta_box['name'] . '_noncename" id="' . $meta_box['name'] . '_noncename" value="' . wp_create_nonce(plugin_basename(__FILE__)) . '" />';
                ?>
                <div class="pp_select" id="ingridients">
                    <h3><?php echo $meta_box['title']; ?></h3>
                <?php
                $tags = get_tags(array('hide_empty' => false));
                $tags_arr = array();
                foreach ($tags as $tag) {
                    array_push($tags_arr, $tag->name);
                }
                ?>
                    <script type="text/javascript">
                        var availableTags = <?php echo json_encode($tags_arr); ?>;
                    </script>

                    <table id="ingridients-sort" class="widefat">
                        <thead>
                            <tr>
                                <th width="25"></th>
                                <th><?php _e("Name of ingriedient", 'purepress'); ?></th>
                                <th><?php _e("Notes (quantity, additional info)", 'purepress'); ?></th>
                                <th><?php _e("Actions", 'purepress'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($meta_box_value)) { ?>
                                <?php $i=0; while ($i < 8 ) { ?>
                                <tr class="ingridients-cont ing">
                                    <td><a title="Drag and drop rows to sort table" href="#" class="move" style="background:url('<?php echo get_admin_url(); ?>/images/press-this.png');"><?php _e("move", 'purepress'); ?></a></td>
                                    <td><input name="<?php echo $meta_box['name']; ?>_name[]" type="text" class="ingridient" value="" /> </td>
                                    <td><input name="<?php echo $meta_box['name']; ?>_note[]" type="text" class="notes"  value="" /></td>
                                    <td class="action">
                                        <a  title="Delete ingridient" href="#" class="delete" style="background-image:url('<?php echo get_admin_url(); ?>/images/no.png');"><?php _e("Delete", 'purepress'); ?></a>
                                    </td>
                                </tr>
                                <?php $i++; } ?>
                <?php } else { ?>
                    <?php foreach ($meta_box_value as $k => $meta_box_value) { ?>
                                <?php if ($meta_box_value['note']=='separator') {?>
                                    <tr class="ingridients-cont separator">
                                        <td><a title="Drag and drop rows to sort table" href="#" class="move" style="background:url('<?php echo get_admin_url(); ?>/images/press-this.png');">move</a></td>
                                        <td><input name="cookingpressingridients_name[]" type="text" class="ingridient"  value="<?php echo $meta_box_value['name']; ?>" /></td>
                                        <td><input name="cookingpressingridients_note[]" type="text" class="notes"  value="separator" /></td>
                                        <td class="action">
                                            <a  title="Delete Separator" href="#" class="delete" style="background-image:url('<?php echo get_admin_url(); ?>/images/no.png');"><?php _e("Delete", 'purepress'); ?></a>
                                        </td>
                                    </tr>
                                <?php } else { ?>
                                    <tr class="ingridients-cont ing">
                                        <td><a title="Drag and drop rows to sort table" href="#" class="move" style="background:url('<?php echo get_admin_url(); ?>/images/press-this.png');">move</a></td>
                                        <td><input name="<?php echo $meta_box['name']; ?>_name[]" type="text" class="ingridient"  value="<?php echo $meta_box_value['name']; ?>" /></td>
                                        <td><input name="<?php echo $meta_box['name']; ?>_note[]" type="text" class="notes"  value="<?php echo $meta_box_value['note']; ?>" /></td>
                                        <td class="action">
                                            <a  title="Delete ingridient" href="#" class="delete" style="background-image:url('<?php echo get_admin_url(); ?>/images/no.png');"><?php _e("Delete", 'purepress'); ?></a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                        <?php
                    }
                }
                ?>
                            
                        </tbody>
                    </table>


                    <a href="#" class="add_ingridient button button-primary"><?php _e("Add new ingridient", 'purepress'); ?></a>
                    <a href="#" class="add_separator button button-primary"><?php _e("Add separator", 'purepress'); ?></a>
                </div>
                <?php
                break;
            case 'instructions':
                ?>
                <div class="pp_select" id="instructions-wrapper">
                    <h3><?php echo $meta_box['title']; ?></h3>
                <?php
                echo'<input type="hidden" name="' . $meta_box['name'] . '_noncename" id="' . $meta_box['name'] . '_noncename" value="' . wp_create_nonce(plugin_basename(__FILE__)) . '" />';
                 $editor_settings = array(
                        'media_buttons' => true,
                        'textarea_rows' => '5',
                        'teeny' => true
                    );
                wp_editor($meta_box_value, 'cookingpressinstructions',$editor_settings);
                ?>
                </div>
                <?php
                break;
        }
    }
    ?>

    <script type="text/javascript">
        //                     (function($){
        //                         $(document).ready(function(){
        //                             function insertAtCursor(myField, myValue) {
        //                                    //IE support
        //                                    if (document.selection && !window.opera) {
        //                                            myField.focus();
        //                                            sel = window.opener.document.selection.createRange();
        //                                            sel.text = myValue;
        //                                    }
        //                                    //MOZILLA/NETSCAPE/OPERA support
        //                                    else if (myField.selectionStart || myField.selectionStart == '0') {
        //                                            var startPos = myField.selectionStart;
        //                                            var endPos = myField.selectionEnd;
        //                                            myField.value = myField.value.substring(0, startPos)
        //                                            + myValue
        //                                            + myField.value.substring(endPos, myField.value.length);
        //                                    } else {
        //                                            myField.value += myValue;
        //                                    }
        //                            }
        //
        //
        //                             function addRecipe(){
        //                                 var title = $('#recipe-meta-boxes input#title').val(),
        //                                    desc = $('#recipe-meta-boxes textarea#summary').val(),
        //                                    servings = $('#recipe-meta-boxes input#servings').val(),
        //                                    yield = $('#recipe-meta-boxes input#yield').val(),
        //                                    preptime = $('#recipe-meta-boxes input#preptime').val(),
        //                                    cooktime = $('#recipe-meta-boxes input#cooktime').val();
        //                                    var ingridients = [];
        //                                    $("ul#ingridients-sort li").each(function() { ingridients.push($(this).find('input').val()) });
        //                                    var instructions = [];
        //                                    $("ul#instructions-sort li").each(function() { instructions.push($(this).find('input').val()) });
        //
        //                                    var html =
        //                                         '<div itemscope="itemscope" itemtype="http://schema.org/Recipe">\n'+
        //                                         '<span itemprop="name">'+title+'</span>\n'+
        //                                         '<meta itemprop="datePublished" content="2009-05-08">May 8, 2009'+
        ////                                         '<img itemprop="image" src="bananabread.jpg" />'+
        //                                           '<span itemprop="description">'+desc+'</span>\n'+
        //                                         '</div>';
        //                                   if(preptime) {
        //                                        html = html + ' Prep Time: <meta itemprop="prepTime" content="PT15M">'+preptime;
        //                                   }
        //                                   if(cooktime) {
        //                                        html = html + ' Cook time: <meta itemprop="cookTime" content="PT1H">'+cooktime;
        //                                   }
        //                                   if(yield) {
        //                                        html = html + ' Yield: <span itemprop="recipeYield">'+ yield +'</span>';
        //                                   }
        //                                   if(ingridients.length > 0) {
        //                                        html = html + 'Ingredients';
        //                                        $.each(ingridients, function(index, value) {
        //                                            html = html + '<span itemprop="ingredients">'+ value + '</span>';
        //                                        });
        //                                   }
        ////                                    if(instructions) {
        ////                                        html = html + 'Instructions <span itemprop="recipeInstructions">';
        ////
        ////                                        $.each(ingridients, function(index, value) {
        ////                                           html = html + value + '\n' ;
        ////                                        });
        ////                                        html = '</span>';
        ////                                   }
        //
        //
        ////
        ////
        ////$.each([52, 97], function(index, value) {
        ////  alert(index + ': ' + value);
        ////});
        //                                    tinyMCE.execCommand('mceInsertContent',false,html);
        //
        ////                                        if(window.tinyMCE)
        ////                                              tinyMCE.execCommand('mceInsertContent',false,html);
        ////                                        else
        ////                                           insertAtCursor(window.opener.document.post.content, html);
        ////                                        window.close();
        //                             }
        //
        //                             $('#insert-recipe').click(function(e){
        //                                 addRecipe();
        //                                 e.preventDefault();
        //                             })
        //                         });
        //
        //                     })(this.jQuery);
        //
    </script>

    <?php
}

function create_meta_box() {
    global $theme_name;
    if (function_exists('add_meta_box')) {
        //normal points
        add_meta_box('new-meta-boxes', 'Post and Gallery Settings', 'new_meta_boxes', 'page', 'normal', 'high');
        add_meta_box('new-meta-boxes', 'Post and Gallery Settings', 'new_meta_boxes', 'post', 'normal', 'high');
        add_meta_box('recipe-meta-boxes', 'Recipe editor', 'recipe_meta_boxes', 'page', 'normal', 'high');
        add_meta_box('recipe-meta-boxes', 'Recipe editor', 'recipe_meta_boxes', 'post', 'normal', 'high');
    }
}

function save_postdata($post_id) {
    global $post, $purepress_meta_boxes;
    foreach ($purepress_meta_boxes as $meta_box) {
// Verify
        if (!wp_verify_nonce($_POST[$meta_box['name'] . '_noncename'], plugin_basename(__FILE__))) {
            return $post_id;
        }

        if ('page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id))
                return $post_id;
        } else {
            if (!current_user_can('edit_post', $post_id))
                return $post_id;
        }

        if ($meta_box['type'] == "mapdata") {
            $data = array(
                $_POST[$meta_box['name'] . '_value'],
                $_POST[$meta_box['name'] . '_lat'],
                $_POST[$meta_box['name'] . '_long']
            );
        } else if ($meta_box['type'] == "mappoints") {

            $data = array();
            foreach ($_POST[$meta_box['name'] . '_pointaddress'] as $k => $v) {
                $data[] = array(
                    'pointaddress' => $v,
                    'pointlat' => $_POST[$meta_box['name'] . '_pointlat'][$k],
                    'pointlong' => $_POST[$meta_box['name'] . '_pointlong'][$k],
                    'pointdata' => $_POST[$meta_box['name'] . '_pointdata'][$k],
                );
            }
        } else {
            $data = $_POST[$meta_box['name'] . '_value'];
        }
        if (get_post_meta($post_id, $meta_box['name'] . '_value') == "")
            add_post_meta($post_id, $meta_box['name'] . '_value', $data, true);

        elseif ($data != get_post_meta($post_id, $meta_box['name'] . '_value', true))
            update_post_meta($post_id, $meta_box['name'] . '_value', $data);

        elseif ($data == "")
            delete_post_meta($post_id, $meta_box['name'] . '_value', get_post_meta($post_id, $meta_box['name'] . '_value', true));
    }
}

function save_recipe_data($post_id) {
    global $post, $recipe_meta_boxes;

    foreach ($recipe_meta_boxes as $meta_box) {
// Verify
        if (!wp_verify_nonce($_POST[$meta_box['name'] . '_noncename'], plugin_basename(__FILE__))) {
            return $post_id;
        }

        if ('page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id))
                return $post_id;
        } else {
            if (!current_user_can('edit_post', $post_id))
                return $post_id;
        }

        if ($meta_box['type'] == "ingridients") {
            $data = array();
            foreach ($_POST[$meta_box['name'] . '_name'] as $k => $v) {
                if(!empty($v)) { ;
             
                
               
                    $data[] = array(
                        'name' => $v,
                        'note' => $_POST[$meta_box['name'] . '_note'][$k],
                    );
               }
           }
        } else if ($meta_box['type'] == "recipeoptions") {
            $data = array(
                $_POST[$meta_box['name'] . '_preptime'],
                $_POST[$meta_box['name'] . '_cooktime'],
                $_POST[$meta_box['name'] . '_yield'],
                $_POST[$meta_box['name'] . '_calories'],
                $_POST[$meta_box['name'] . '_fat']
            );
        } else {
            $data = $_POST[$meta_box['name']];
        }

        if (get_post_meta($post_id, $meta_box['name']) == "")
            add_post_meta($post_id, $meta_box['name'], $data, true);

        elseif ($data != get_post_meta($post_id, $meta_box['name'], true))
            update_post_meta($post_id, $meta_box['name'], $data);

        elseif ($data == "")
            delete_post_meta($post_id, $meta_box['name'], get_post_meta($post_id, $meta_box['name'], true));
    }
}

function save_taxonomy_data($post_id) {
// verify this came from our screen and with proper authorization.

    if (!wp_verify_nonce($_POST['cookingpressservings_noncename'], plugin_basename(__FILE__))) {
        return $post_id;
    }
    // verify if this is an auto save routine. If it is our form has not been submitted, so we dont want to do anything
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;


    // Check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
    } else {
        if (!current_user_can('edit_post', $post_id))
            return $post_id;
    }

    // OK, we're authenticated: we need to find and save the data
    $post = get_post($post_id);
    if (($post->post_type == 'post') || ($post->post_type == 'page')) {
        // OR $post->post_type != 'revision'
        $serving = $_POST['cookingpressservings'];
        wp_set_object_terms($post_id, $serving, 'serving');
        $level = $_POST['cookingpresslevel'];
        wp_set_object_terms($post_id, $level, 'level');

        $tags = array();
        foreach ($_POST['cookingpressingridients_name'] as $k => $v) {
           if($_POST['cookingpressingridients_note'][$k] != 'separator')  {
               wp_insert_term($v, 'post_tag');
                //if(term_exists($v, 'post_tag'))
                array_push($tags, $v);
            }
        }

       $sttags = split(",", $_POST['tax_input']['post_tag']);

        foreach ($sttags as  $v) {
            wp_insert_term($v, 'post_tag');
            //if(term_exists($v, 'post_tag'))
            array_push($tags, $v);
        }
        wp_set_post_terms($post_id, $tags, 'post_tag');

        return $serving;
    }
}

add_action('admin_menu', 'create_meta_box');
add_action('save_post', 'save_postdata');
add_action('save_post', 'save_recipe_data');
add_action('save_post', 'save_taxonomy_data');

