<?php
$tags = array();
$extags = array();

if ($_GET['submit']) {
    $tags = $_GET['include_ing'];
    $extags = $_GET['exclude_ing'];
    $level = $_GET['level'];
    $serving = $_GET['serving'];
    $time = $_GET['timeneeded'];
    $relation = $_GET['relation'];
    $allergen_select = $_GET['allergens'];
    
}


$search_elem = get_option(PPTNAME.'_search_elements'); 

?>

<form action="" method="get">
    <section class="advsearch-cont">
        <div class="advsearch">
            <?php if($_GET['s']) { ?>
                <p>
                    <label><?php _e( 'Search term', 'purepress' ); ?></label>
                    <input value="<?php echo $_GET['s']?>" name="s" id="s" type="text"/>
                </p>
            <?php } else { ?>
                <input value="" name="s" id="s" type="hidden"/>
            <?php } ?>
            <p>
                <label class="full"><?php _e('Select one or more ingredients that should be <strong>included in recipe</strong>', 'purepress'); ?></label>
                <?php echo alltags_select("include_ing",$tags); ?>
            </p>
            <p id="relation"><?php _e( 'Recipe needs to have ', 'purepress' ); ?><select name="relation" class="chosen" style="width:70px;min-width:70px">
                    <option <?php if ($relation && $relation =='any') echo 'selected="selected"'; ?> value="any"><?php _e( 'Any', 'purepress' ); ?></option>
                    <option <?php if ($relation && $relation =='all') echo 'selected="selected"'; ?> value="all"><?php _e( 'All', 'purepress' ); ?></option>
                </select> <?php _e( 'of selected ingredients', 'purepress' ); ?> </p>
            <p>
                <label  class="full"><?php _e('Select one or more ingredients that should be <strong>excluded from recipe</strong>', 'purepress'); ?></label>
                <?php echo alltags_select("exclude_ing",$extags); ?>
            </p>
            <?php if(is_array($search_elem) && in_array('cat',$search_elem)){ ?>
            <p>
                <label><?php _e( 'Choose category', 'purepress' ); ?></label>
                <?php wp_dropdown_categories( 'show_option_all=Select...&hide_empty=0&id=cat2&class=chosen' ); ?>
            </p>
            <?php } ?>
            <?php if(is_array($search_elem) && in_array('lvl',$search_elem)){ ?>
            <p>
                <label><?php _e( 'Choose level', 'purepress' ); ?></label>
                <select name="level" class="chosen">
                     <option value=""></option>
                    <?php dropdown_search('level', '',$level); ?>
                </select>
            </p>
               <?php } ?>
            <?php if(is_array($search_elem) && in_array('serving',$search_elem)){ ?>
            <p>
                <label><?php _e( 'Choose serving', 'purepress' ); ?></label>
                <select name="serving" class="chosen">
                     <option value=""></option>
                    <?php dropdown_search('serving', '',$serving); ?>
                </select>
            </p>
               <?php } ?>
            <?php if(is_array($search_elem) && in_array('time',$search_elem)){ ?>
            <p>
                <label><?php _e( 'Choose time needed', 'purepress' ); ?></label>
                <select name="timeneeded" class="chosen">
                    <option value=""></option>
                    <?php dropdown_search('timeneeded', '',$time); ?>
                </select>
            </p>
               <?php } ?>
            <?php if(is_array($search_elem) && in_array('allergens',$search_elem)){ ?>
            <p>
                <label><?php _e( 'Choose allergens', 'purepress' ); ?></label>
           
                <select name="allergens[]" multiple="true" size="5" class="chosen">
                    <option value="0"><?php _e( 'Select...', 'purepress' ); ?></option>
                 

                    <?php dropdown_search('allergen','', $allergen_select); ?>
                </select>
            </p>
               <?php } ?>


            

            <input type="submit" name="submit" class="searchtags" value="Search" class="btn" />
        </div>



</form>
</section>