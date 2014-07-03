<?php
$categories = get_categories();

function get_cats($val) {
    $result = array();
    $result[] = "None";
    foreach ($val as $key => $object) {
        $result[$object->cat_ID] = $object->category_nicename;
    }
    return $result;
}

$cats = get_cats($categories);


$options = array(
    array("name" => __("General Options", 'purepress'),
        "type" => "seperate"),
    array("name" => __("Upload Logo", 'purepress'),
        "desc" => __("Leave empty to use text (Site Title will be used)", 'purepress'),
        "id" => $shortname . "_logo_url",
        "std" => "",
        "type" => "upload"),
    array("name" => __("Set width of logo<br/><small>(only if it won't show automatically)</small>", 'purepress'),
        "id" => $shortname . "_logo_width",
        "desc" => __("Theme in most cases will get logo size by getimagesize() function in PHP, but some hosting doesn't allow it, then you have to put width  here", 'purepress'),
        "std" => '',
        "type" => "text"),
    array("name" => __("Set height of logo<br/><small>(only if it won't show automatically)</small>", 'purepress'),
        "id" => $shortname . "_logo_height",
        "desc" => __("Theme in most cases will get logo size by getimagesize() function in PHP, but some hosting doesn't allow it, then you have to put height here", 'purepress'),
        "std" => '',
        "type" => "text"),
    array("name" => __("Show blog description?", 'purepress'),
        "desc" => __("Choose Yes to show Tagline, you can set it in General Settings)", 'purepress'),
        "id" => $shortname . "_blogdesc_remove",
        "options" => array(
            'Yes' => 'Yes',
            'No' => 'No',
            ),
        "std" => "",
        "type" => "select"),
    array("name" => __("Choose colour scheme", 'purepress'),
        "id" => $shortname . "_color_scheme",
        "options" => array(
            'light' => 'Light',
            'light2' => 'Paper',
            'wood' => 'Wooden board',
            'elegant' => 'Elegant',
            'Minimal' => 'Minimal',
            ),
        "std" => "",
        "type" => "select"),
    array("name" => __("Choose sidebar position", 'purepress'),
        "desc" => __("Choose layout position", 'purepress'),
        "id" => $shortname . "_sidebar_position",
        "options" => array(
            'leftsb' => __('Left sidebar', 'purepress'),
            'rightsb' => __('Right sidebar', 'purepress'),
            ),
        "std" => "",
        "type" => "select"),
    array("name" => __("Choose homepage posts version", 'purepress'),
        "desc" => __("Choose layout version", 'purepress'),
        "id" => $shortname . "_homepost_type",
        "options" => array(
            'index' => __('Thumbs grid', 'purepress'),
            'excerpt' => __('Excerpt mode', 'purepress'),
            'full' => __('Full text mode', 'purepress'),
            ),
        "std" => "",
        "type" => "select"),


//    array("name" => __("Exclude categories from homepage", 'purepress'),
//        "id" => $shortname . "_ex_cats",
//        "desc" => __("Choose categories to exclude from website, usefull when you want to have e.g seperate blog", 'purepress'),
//        "type" => "exclude"),
    array("name" => __("Copyrights in footer", 'purepress'),
        "desc" => __("Text displayed under the footer widgets area.", 'purepress'),
        "id" => $shortname . "_copyrights",
        "std" => '&copy; CookingPress by <a href="http://www.themeforest.net/user/purethemes/portfolio?ref=purethemes">purethemes.net</a>',
        "type" => "textarea"),
// posts options
    array("type" => "close"),
    array("name" => __("Posts Options", 'purepress'),
        "type" => "seperate"),

       array("name" => __("Show author info under post and page?", 'purepress'),

        "id" => $shortname . "_author_info",
        "options" => array(
            'yes' => __('Yes, show it', 'purepress'),
            'no' => __('No, hide it', 'purepress'),
            ),
        "std" => "",
        "type" => "select"),
    array("name" => __("Home page post meta - show informations like comments number, tags etc. below post", 'purepress'),
        "id" => $shortname . "_postmeta",
        "options" => array(
            'Time' => __('Recipe Time', 'purepress'),
            'Ratings' => __('Recipe Ratings', 'purepress'),
            'Servings' => __('Recipe Servings', 'purepress'),
            'Level' => __('Recipe level', 'purepress'),
            'Allergens' => __('Food Allergens', 'purepress'),
            'Author' => __('Author', 'purepress'),
            'Categories' => __('Categories', 'purepress'),
            'Tags' => __('Tags', 'purepress'),
            'Comments' => __('Comments', 'purepress'),
            ),
        "std" => array('Date', 'Categories', 'Comments'),
        "type" => "checkbox_multiple"),
    array("name" => __("Single post meta - show informations like comments number, tags etc. below post", 'purepress'),
        "id" => $shortname . "_single_postmeta",
        "options" => array(
            'Date' => __('Date', 'purepress'),
            'Author' => __('Author', 'purepress'),
            'Categories' => __('Categories', 'purepress'),
            'Tags' => __('Tags', 'purepress'),
            'Comments' => __('Comments', 'purepress'),
            ),
        "std" => array('Date', 'Categories', 'Comments'),
        "type" => "checkbox_multiple"),

    array("type" => "close"),
    array("name" => __("Recipe configuration", 'purepress'),
        "type" => "seperate"),
     array("name" => __("Search configuration", 'purepress'),
        "id" => $shortname . "_search_elements",
        "options" => array(
            'cat' => __('Category', 'purepress'),
            'lvl' => __('Level', 'purepress'),
            'serving' => __('Serving', 'purepress'),
            'time' => __('Time needed', 'purepress'),
            'allergens' => __('Allergens', 'purepress'),
            ),
        "std" => array('cat', 'lvl', 'serving','time','allergens'),
        "type" => "checkbox_multiple"),
    array("name" => __("Recipe microformat", 'purepress'),
        "desc" => __("Choose layout version", 'purepress'),
        "id" => $shortname . "_recipe_format",
        "options" => array(
            'hrecipe' => __('hRecipe', 'purepress'),
            'schema' => __('Schema.org', 'purepress')
            ),
        "std" => "",
        "type" => "select"),
    array("name" => __("Add recipe to post automatically?", 'purepress'),
        "desc" => __("If recipe form is filled, shortcode with recipe will be added at the end of post", 'purepress'),
        "id" => $shortname . "_recipe_autoadd",
        "options" => array(
            'no' => __('No', 'purepress'),
            'yes' => __('Yes', 'purepress')
            ),
        "std" => "",
        "type" => "select"),
    array("name" => __("Add tooltips to recipe?", 'purepress'),
        "desc" => __("If tag has description and optional image it will be shown in tooltip on recipe list", 'purepress'),
        "id" => $shortname . "_recipe_tooltip",
        "options" => array(
            'no' => __('No', 'purepress'),
            'yes' => __('Yes', 'purepress')
            ),
        "std" => "no",
        "type" => "select"),
    array(  "name" => __("Nutrition facts configuration", 'purepress'),
            "id" => $shortname . "_nutrition_facts",
            "desc" => __("Configure your nutrition facts lists", 'purepress'),
            "std" => "",
            "type" => "ntfacts"),

    array("name" => __("Add post content in 'Add recipe' form?", 'purepress'),
            "desc" => __("If recipe form is filled, shortcode with recipe will be added at the end of post", 'purepress'),
            "id" => $shortname . "_recipeadd_content",
            "options" => array(
                    'no' => __('Yes', 'purepress'),
                    'yes' => __('No', 'purepress')
            ),
            "std" => "",
            "type" => "select"),
    array("name" => __("'Recipe add' template - success text", 'purepress'),
            "desc" => __("Text displayed after recipe was added", 'purepress'),
            "id" => $shortname . "_recipe_success",
            "std" => 'Thank you for adding recipe! We will submit it after review!',
            "type" => "textarea"),

    array("name" => __("'Recipe add' template - ingridients error text", 'purepress'),
            "desc" => __("Text displayed after recipe was added", 'purepress'),
            "id" => $shortname . "_recipe_ing_error",
            "std" => 'I\'m sure there should be at least one ingridient :) !',
            "type" => "textarea"),

    array("name" => __("'Recipe add' template - instructions error text", 'purepress'),
            "desc" => __("Text displayed after recipe was added", 'purepress'),
            "id" => $shortname . "_recipe_ins_error",
            "std" => 'No instructions? How am I supposed to do this? :)',
            "type" => "textarea"),
//    
//    array("name" => __("Change text \"Ingriedients\" to something else", 'purepress'),
//        "id" => $shortname . "_ingredients_text",
//        "std" => 'Ingriedients',
//        "type" => "text"),
//    array("name" => __("Change text \"Instructions\" to something else", 'purepress'),
//        "id" => $shortname . "_instructions_text",
//        "std" => 'Instructions',
//        "type" => "text"),
//    array("name" => __("Change text \"Prep time\" to something else", 'purepress'),
//        "id" => $shortname . "_preptime_text",
//        "std" => 'Prep time',
//        "type" => "text"),
//    array("name" => __("Change text \"Cook time\" to something else", 'purepress'),
//        "id" => $shortname . "_cooktime_text",
//        "std" => 'Cook time',
//        "type" => "text"),
//    array("name" => __("Change text \"Yield\" to something else", 'purepress'),
//        "id" => $shortname . "_yield_text",
//        "std" => 'Yield',
//        "type" => "text"),
//    array("name" => __("Change text \"Nutrition facts\" to something else", 'purepress'),
//        "id" => $shortname . "_nutrition_text",
//        "std" => 'Nutrition facts:',
//        "type" => "text"),
//// colour options
    array("type" => "close"),
    array("name" => __("Colour Options", 'purepress'),
        "type" => "seperate"),
    array("name" => __("Choose fonts family?", 'purepress'),
        "desc" => __("Default is Droid", 'purepress'),
        "id" => $shortname . "_custom_font",
        "options" => array(
            'droid' => 'Droid',
            'arial' => 'Helvetica, Arial',
            'ptsans' => 'PT Sans',
            ),
        "std" => "",
        "type" => "select"),
    array("name" => __("Choose font for Recipe?", 'purepress'),

        "id" => $shortname . "_recipe_font",
        "options" => array(
            'Satisfy' => 'Satisfy',
            'Shadows+Into+Light+Two::latin' => 'Shadows Into Light Two',
            'Condiment::latin' => 'Condiment',
            'Leckerli+One::latin' => 'Leckerli One',
            'Amatic+SC::latin' => 'Amatic SC',
            'Handlee::latin' => 'Handlee',
            'Pacifico::latin' => 'Pacifico',
            'Droid+Serif::latin' => 'Droid Serif',
            'Droid+Sans::latin' => 'Droid Sans',
            'PT+Sans::latin' => 'PT Sans',
            ),
        "std" => "",
        "type" => "select"),
    array("name" => __("Footer background?", 'purepress'),

        "id" => $shortname . "_footer_bg",
        "options" => array(
            'pattern.jpg' => 'Chequ-ered cloth',
            'xv.png' => 'Floral',
            'tileable_wood_texture.png' => 'Wood 1',
            'wood_pattern.png' => 'Wood 2',
            'wavecut.png' => 'Wavecut',
            'grunge.jpg' => 'Grunge',
            'whitediamond.png' => 'White Diamond',
            ),
        "std" => "",
        "type" => "select"),
    array("name" => __("Custom CSS", 'purepress'),
        "desc" => __("You can put here custom CSS, it will help to keep your changes after updating theme.", 'purepress'),
        "id" => $shortname . "_custom_css",
        "std" => "",
        "type" => "textarea"),
    array("name" => __("Apply custom colours?", 'purepress'),
        "desc" => __("Select Yes to apply custom colours", 'purepress'),
        "id" => $shortname . "_custom_colours",
        "options" => array(
            'No' => 'No',
            'Yes' => 'Yes',
            ),
        "std" => "",
        "type" => "select"),
    array("name" => __("Page Full Background", 'purepress'),
        "desc" => "",
        "id" => $shortname . "_bgcolor",
        "std" => "",
        "type" => "colorpicker"),
    array("name" => __("Page Background (with white sidebar)", 'purepress'),
        "desc" => "",
        "id" => $shortname . "_bgcolorsbwhite",
        "std" => "",
        "type" => "colorpicker"),
    array("name" => __("Background of Footer area", 'purepress'),
        "desc" => "",
        "id" => $shortname . "_footer_bgcolor",
        "std" => "",
        "type" => "colorpicker"),
    array("name" => __("Menu background", 'purepress'),
        "desc" => "",
        "id" => $shortname . "_menu_bgcolor",
        "std" => "",
        "type" => "colorpicker"),
    array("name" => __("Menu hover background", 'purepress'),
        "desc" => "",
        "id" => $shortname . "_menu_hover_bgcolor",
        "std" => "",
        "type" => "colorpicker"),
    array("name" => __("Menu text color", 'purepress'),
        "desc" => "",
        "id" => $shortname . "_menu_color",
        "std" => "",
        "type" => "colorpicker"),
    array("type" => "picker"),
    array("type" => "close"),
    array("name" => __("Social widget", 'purepress'),
        "type" => "seperate"),
    array("name" => __("Enable social widget?", 'purepress'),
        "desc" => __("Select Yes to turn it on", 'purepress'),
        "id" => $shortname . "_social_widget",
        "options" => array(
            'No' => 'No',
            'Yes' => 'Yes',
            ),
        "std" => "",
        "type" => "select"),
    array("name" => __("Title of widget", 'purepress'),
        "id" => $shortname . "_social_widget_title",
        "desc" => __("Just a title", 'purepress'),
        "std" => "",
        "type" => "text"),
    array("name" => __("Social elements:", 'purepress'),
        "id" => $shortname . "_social_widget_element",
        "options" => array(
            'twitter' => __('Twitter', 'purepress'),
            'facebook' => __('Facebook', 'purepress'),
            'googleplus' => __('Google Plus', 'purepress'),
            'pinterest' => __('Pinterest', 'purepress'),
            'shortlink' => __('Shortlink', 'purepress'),
            ),
        "std" => array('Date', 'Categories', 'Comments'),
        "type" => "checkbox_multiple"),
    array("name" => __("Facebook App ID", 'purepress'),
        "id" => $shortname . "_social_widget_fbid",
        "desc" => __("You need to create facebook aplication to be able to share, paste here ID of it", 'purepress'),
        "std" => "",
        "type" => "text"),
    );

function ppoptionsCreator($options) {
    $num = 1;
    foreach ($options as $value) {
        switch ($value['type']) {
            case "seperate":
            ?>
            <div id="tabs-<?php echo $num;
            $num++; ?>" class="tab_content">
            <?php break;

            case "close": ?>
        </div>
        <?php break;

        case 'text': ?>
        <div class="pp_text panel-element" id="<?php echo $value['id']; ?>" >
            <label><?php echo $value['name']; ?></label>
            <input style="width:320px" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php
            if (get_option($value['id']) != "") {
                echo get_option($value['id']);
            } else {
                echo $value['std'];
            }
            ?>" />

            <?php if ($value['desc']) { ?>
            <span class="help">Help</span>
            <p class="help-info"><span><?php echo $value['desc']; ?></span></p>
            <?php } ?>
        </div>

        <?php break;
        case 'hr': ?>
        <div class="pp_hr">
            <h4><?php echo $value['name']; ?></h4>
            <?php if ($value['desc']) { ?>
            <span class="help">Help</span>
            <p class="help-info"><span><?php echo $value['desc']; ?></span></p>
            <?php } ?>
        </div>

        <?php
        break;
        case 'textarea':
        ?>
        <div class="pp_textarea panel-element" id="<?php echo $value['id']; ?>" >
            <label><?php echo $value['name']; ?></label>
            <textarea name="<?php echo $value['id']; ?>" style="width:370px; height:200px;" type="<?php echo $value['type']; ?>" cols="" rows=""><?php
            if (get_option($value['id']) != "") {
                echo get_option($value['id']);
            } else {
                echo $value['std'];
            }
            ?></textarea>

            <?php if ($value['desc']) { ?>

            <span class="help">Help</span>
            <p class="help-info"><span><?php echo $value['desc']; ?></span></p>
            <?php } ?>
        </div>

        <?php
        break;
        case 'select':
        ?>
        <div class="pp_select panel-element" id="<?php echo $value['id']; ?>" >
            <label><?php echo $value['name']; ?></label>

            <select style="width:320px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">

                <?php foreach ($value['options'] as $key => $option) { ?>
                <option <?php
                if (get_option($value['id']) == $key) {
                    echo ' selected="selected"';
                    $selected = 1;
                } elseif (isset($selected) && $selected != 1 && $key == $value['std']) {
                    echo ' selected="selected"';
                }
                ?> value="<?php echo $key; ?>"><?php echo $option; ?>
            </option><?php } ?>
        </select>

        <?php if (isset($value['desc'])) { ?>

        <span class="help">Help</span>
        <p class="help-info"><span><?php echo $value['desc']; ?></span></p>
        <?php } ?>
    </div>

    <?php
    break;
    case 'select_multiple':
    ?>
    <div class="pp_select_multiple panel-element" id="<?php echo $value['id']; ?>" >
        <label><?php echo $value['name']; ?></label>
        <select style="width:240px;height:100px;" name="<?php echo $value['id']; ?>[]" multiple="multiple" id="<?php echo $value['id']; ?>">
            <?php
            foreach ($value['options'] as $key => $option) {
                echo '<option value="' . $key . '"';
                if (get_option($value['id'])) {
                    if (in_array($key, get_option($value['id']))) {
                        echo ' selected="selected"';
                    }
                } elseif ($key == $value['std']) {
                    echo ' selected="selected"';
                }
                echo '>' . $option . '</option>';
            }
            ?></select>

            <?php if ($value['desc']) { ?>
        }
        <span class="help">Help</span>
        <p class="help-info"><span><?php echo $value['desc']; ?></span></p>
        <?php } ?>
    </div>

    <?php
    break;
    case "checkbox":
    ?>
    <div class="pp_checkbox panel-element" id="<?php echo $value['id']; ?>" >

        <label><?php echo $value['name']; ?></label>
        <?php
        if (get_option($value['id'])) {
            $checked = "checked=\"checked\"";
        } else {
            $checked = "";
        }
        ?>
        <input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
        <label for="<?php echo $value['id']; ?>"></label>

        <?php if ($value['desc']) { ?>
    }
    <span class="help"><?php _e('Help', 'purepress'); ?></span>
    <p class="help-info"><span><?php echo $value['desc']; ?></span></p>
    <?php } ?>
</div>

<?php
break;
case "checkbox_multiple":
?>
<div class="pp_checkbox_multiple panel-element" id="<?php echo $value['id']; ?>" >
    <h4><?php echo $value['name']; ?></h4>
    <?php
    $i = 0;
    foreach ($value['options'] as $key => $option) {
        $checked = "";
        if (get_option($value['id'])) {
            if (in_array($key, get_option($value['id'])))
                $checked = "checked=\"checked\"";
        } elseif (in_array($key, $value['std']) && get_option($value['id'] . '_status') !== 'saved')
        $checked = "checked=\"checked\"";
        ?>
        <p>
            <input type="checkbox" name="<?php echo $value['id']; ?>[]" id="<?php echo $value['id']; ?>-<?php echo $key; ?>" value="<?php echo $key; ?>" <?php echo $checked; ?> />
            <label for="<?php echo $value['id']; ?>-<?php echo $key; ?>"><?php echo $option; ?></label>   </p><?php $i++;
        } ?>

        <?php if (isset($value['desc'])) { ?>
        <span class="help"><?php _e('Help', 'purepress'); ?></span>
        <p class="help-info"><span><?php echo $value['desc']; ?></span></p>
        <?php } ?>
    </div>

    <?php
    break;
    case "ntfacts":
    ?>
    <div class="pp_checkbox_multiple ntfacts panel-element" id="<?php echo $value['id']; ?>" >
        <h4><?php echo $value['name']; ?></h4>
        <p><strong><?php _e('Important', 'purepress'); ?></strong> Because of the fact that it's hard and resource consuming to make list of nutrition facts in conjunction with data from each posts,
            you can't delete any elements from this table. That's why you should really think through lists of elements you want to show. Of course you can edit them, change name or scale
            but this changes won't be linked with data in posts. For example - if you'll decide to change "Fat" to "Protein amount", you'll need to edit each post in which you've already put 
            "Fat" value and change this value. Of course it's not required to fill all values, if you won't put Fat amount in post, it won't be displayed.
            There's also no limit of what kind of nutrition data you want to show, but try to not make a mess with it ;). If it's unclear, check Documentation or contact me to discuss it.
             </p>
        <table class="widefat" id="nutrition_facts" style="margin-bottom: 20px;">
            <thead>
                <tr>
                    <th><?php _e('Name', 'purepress'); ?> </th>
                    <th><?php _e('Unit', 'purepress'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $nfacts = get_option($value['id']); ?>
                <?php if (empty($nfacts)) { ?>
                <tr class="ntfact-cont">
                    <td><input name="<?php echo  $value['id']; ?>_name[]" type="text" class="name" value="Calories" /> </td>
                    <td><input name="<?php echo  $value['id']; ?>_unit[]" type="text" class="unit"  value="kcal" /></td>
                </tr>
                <tr class="ntfact-cont">
                    <td><input name="<?php echo  $value['id']; ?>_name[]" type="text" class="name" value="Fat" /> </td>
                    <td><input name="<?php echo  $value['id']; ?>_unit[]" type="text" class="unit"  value="grams" /></td>
                </tr>
              
                <?php } else {
                    foreach ($nfacts as $k => $v) { ?>
                    <tr class="ntfact-cont"> 
                        <td><input name="<?php echo $value['id']; ?>_name[]" type="text" class="ingridient"  value="<?php echo $v["name"]; ?>" /></td>
                        <td><input name="<?php echo $value['id']; ?>_unit[]" type="text" class="notes"  value="<?php echo $v["unit"]; ?>" /></td>
                      
                    </tr>
                    <?php } 
                } ?>
            </tbody>
        </table>
        <a href="#" class="add_nutrition button button-primary"><?php _e("Add new nutrition fact element", 'purepress'); ?></a>


        <?php if (isset($value['desc'])) { ?>
        <span class="help">Help</span>
        <p class="help-info"><span><?php echo $value['desc']; ?></span></p>
        <?php } ?>

        <h3><?php _e('Add recipe template configuration', 'purepress'); ?></h3>
    </div>

    <?php
    break;
    case "colorpicker":
    ?>
    <div class="pp_colorpicker panel-element color" id="<?php echo $value['id']; ?>" >
        <label><?php echo $value['name']; ?></label>
        <input name="<?php echo $value['id']; ?>" class="colorwell" type="text" value="<?php
        if (get_option($value['id']) != "") {
            echo get_option($value['id']);
        } else {
            echo 'fff';
        }
        ?>" style="background-color:#<?php
        if (get_option($value['id']) != "") {
            echo get_option($value['id']);
        }
        ?>" />

        <?php
        if (get_option($value['id'] . '_enabler')) {
            $checked = "checked=\"checked\"";
        } else {
            $checked = "";
        }
        ?>
        <input type="checkbox" name="<?php echo $value['id'] . '_enabler'; ?>" id="<?php echo $value['id'] . '_enabler'; ?>" value="true" <?php echo $checked; ?> />


        <?php if ($value['desc']) { ?>
        <span class="help">Help</span>
        <p class="help-info"><span><?php echo $value['desc']; ?></span></p>
        <?php } ?>
    </div>

    <?php
    break;
    case "exclude":
    ?>
    <div  id="<?php echo $value['id']; ?>" class="panel-element" >
        <strong><?php echo $value['name']; ?></strong>
        <br/><br/>

        <ul id="<?php echo $value['id']; ?>">
            <?php
            $categories = get_categories(array('hide_empty' => 0));
            $cats = get_cats($categories);

            foreach ($cats as $cat => $catnr) {
                ?>

                <li id="<?php echo $cat; ?>"><?php echo $catnr; ?></li>

                <?php } ?>
            </ul>
            <input type="hidden" id="<?php echo $value['id']; ?>" name="<?php echo $value['id']; ?>" value="<?php echo get_option($value['id']); ?>" />
            <div style="padding:0px" class="clear"></div>
            <?php if ($value['desc']) { ?>
            <span class="help">Help</span>
            <p class="help-info"><span><?php echo $value['desc']; ?></span></p>
            <?php } ?>
        </div>

        <?php
        break;
        case 'upload':
        ?>

        <div class="upload panel-element" id="<?php echo $value['id']; ?>" >
            <label id="<?php echo get_option_page_ID('purepress-data'); ?>"><?php echo $value['name']; ?></label>


            <input id="upload_image" type="text" size="36" name="<?php echo $value['id']; ?>" value="<?php
            if (get_option($value['id']) != "") {
                echo get_option($value['id']);
            } else {
                echo $value['std'];
            }
            ?>" />
            <input id="upload_image_button" type="button" value="Upload Image"  />
            <div class="preview-upload"> </div>
            <?php if ($value['desc']) { ?>
            <span class="help">Help</span>
            <p class="help-info"><span><?php echo $value['desc']; ?></span></p>
            <?php } ?>
        </div>
        <?php
        break;
        case 'picker':
        ?>
        <div class="pickerhandler">
            <div id="picker"></div>
        </div>
        <?php
        break;
    }
}
}

function ppoptionstabsCreator($options) {
    $num = 1;
    echo '<ul>';
    foreach ($options as $value) {
        switch ($value['type']) {
            case "seperate":
            ?>
            <li><a href="#tabs-<?php echo $num; ?>"><?php echo $value['name'];
            $num++ ?></a></li>

            <?php
            break;
        }
    }
    echo '</ul>';
}
?>