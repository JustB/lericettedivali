<?php
/**
 * Template Name: Add Recipe by registered user
 *
 * A custom page template without sidebar.
 *
 * The "Template Name:" bit above allows this to be selectable
 * from a dropdown menu on the edit page screen.
 *
 * @package WordPress
 * @subpackage purepress
 * @since purepress 1.0
 */
if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) &&  $_POST['action'] == "new_post") {

    // Do some minor form validation to make sure there is content


    if (empty($_POST['title'])) {
        $hasError = true;
        $titleError = true;
    }


    $title =  mysql_real_escape_string($_POST['title']);
    $description = mysql_real_escape_string($_POST['description']);
    $summary = mysql_real_escape_string($_POST['cookingpresssummary']);

    $tags = $_POST['cookingpressingridients_name'];

    $ingredients = array();
    foreach ($_POST['cookingpressingridients_name'] as $k => $v) {
        $ingredients[] = array(
                'name' => $v,
                'note' => mysql_real_escape_string($_POST['cookingpressingridients_note'][$k]),
        );
    }


    $instructions = mysql_real_escape_string($_POST['cookingpressinstructions']);

    if (empty($_POST['cookingpressinstructions']) || $_POST['cookingpressinstructions']==' ') {
        $hasError = true;
        $instructionsError = true;
    }

    $recipeoptions = array(
            mysql_real_escape_string($_POST['cookingpressrecipeoptions_preptime']),
            mysql_real_escape_string($_POST['cookingpressrecipeoptions_cooktime']),
            mysql_real_escape_string($_POST['cookingpressrecipeoptions_yield']),
    );

    $ntfacts = mysql_real_escape_string($_POST['cookingpressntfacts']);
    $serving = mysql_real_escape_string($_POST['serving']);
    $level = mysql_real_escape_string($_POST['level']);
    // ADD THE FORM INPUT TO $new_post ARRAY
    $new_post = array(
            'post_title'	=>	$title,
            'post_content'	=>	$description,
            'post_category'	=>	array($_POST['cat']),  // Usable for custom taxonomies too
            'post_status'	=>	'draft',           // Choose: publish, preview, future, draft, etc.
            'post_type'	=>	'post'  //'post',page' or use a custom post type if you want to
    );



    //SAVE THE POST
    if($hasError==false) {
        $pid = wp_insert_post($new_post);
//
        add_post_meta($pid, 'cookingpressingridients', $ingredients, true);
        add_post_meta($pid, 'cookingpressinstructions', $instructions, true);
        add_post_meta($pid, 'cookingpressrecipeoptions', $recipeoptions, true);
        add_post_meta($pid, 'cookingpressntfacts', $ntfacts, true);
        add_post_meta($pid, 'cookingpresssummary', $summary, true);

        //SET OUR TAGS UP PROPERLY
        wp_set_post_tags($pid, $tags);

        wp_set_object_terms($pid, $level, 'level');
        wp_set_object_terms($pid, $serving, 'serving');


        do_action('wp_insert_post', 'wp_insert_post');

        $postAdded = true;
    }


    //REDIRECT TO THE NEW POST ON SAVE
//    $link = get_permalink( $pid );
//    wp_redirect( $link );




} // END THE IF STATEMENT THAT STARTED THE WHOLE FORM

//POST THE POST YO

add_action('wp_footer', 'add_post_js_template');
remove_action('wp_footer', 'coda_slider_init');
remove_action('wp_footer', 'flexslider_init');
get_header();

$content_status = get_option(PPTNAME . '_recipeadd_content');
?>

<section id="content">
    <?php if (have_posts())
        while (have_posts()) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
                <?php printf('<a href="%1$s" class="published-time" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>', get_permalink(), esc_attr(get_the_time()), get_the_date()); ?>
        <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'purepress'), the_title_attribute('echo=0')); ?>" rel="bookmark"><?php the_title(); ?></a></h2>


        <div class="entry-content">
                    <?php the_content(); ?>

            
            <?php if ( is_user_logged_in() ) { ?>
            <div class="addrecipe">

                <div class="box-ok-outer <?php if( isset($postAdded)) { echo 'show'; } ?>">
                    <div class="box-ok">
                        <p><?php echo get_option(PPTNAME . '_recipe_success');?></p>
                    </div>
                </div>

                <form id="new_post" name="new_post" method="post" action="" class="addrecipe-form" enctype="multipart/form-data">
                    <!-- post name -->
                    <fieldset class="title <?php if(isset($hasError) && isset($titleError)) { echo 'error'; } ?>" name="name">
                        <h4><span><?php _e('Recipe Title:', 'purepress'); ?></span></h4>

                        <div class="box-error-outer <?php if(isset($hasError) && isset($titleError)) { echo 'show'; } ?>" >
                            <div class="box-error">
                                <p><?php _e(' Title is required!', 'purepress'); ?></p>
                            </div>
                        </div>

                        <input type="text" id="title" value="<?php if(isset($_POST['title'])) echo $_POST['title'];?>" tabindex="1" name="title" />
                        <span class="req"><?php _e('Required', 'purepress'); ?></span>
                    </fieldset>

                    <!-- post Content -->
                    <?php if($content_status == 'yes') { ?>
                    <fieldset class="content">
                        <h4><span><?php _e('Post Content:', 'purepress'); ?></span></h4>
                                <?php
                                $editor_settings = array(
                                        'wpautop' => true,
                                        'media_buttons' => true,
                                        'editor_class' => 'frontend',
                                        'textarea_rows' => 5,
                                        'tabindex' => 2,
                                        'teeny' => true
                                );
                                wp_editor(' ','description', $editor_settings);
                                ?>

                    </fieldset>
                    <?php } ?>
                    <!-- post Category -->
                    <fieldset class="category">
                        <h4><span><?php _e('Category:', 'purepress'); ?></span></h4>
                                <?php wp_dropdown_categories( 'tab_index=3&taxonomy=category&hide_empty=0&id=cat2' ); ?>
                    </fieldset>


                    <fieldset class="content">
                        <h4><span><?php _e('Short summary:', 'purepress'); ?></span></h4>
                                <?php
                                $editor_settings = array(
                                        'wpautop' => true,
                                        'media_buttons' => true,
                                        'editor_class' => 'cookingpresssummary',
                                        'textarea_rows' => 5,
                                        'tabindex' => 4,
                                        'teeny' => true

                                );
                                wp_editor(' ','cookingpresssummary', $editor_settings);
                                ?>

                    </fieldset>
                    <!-- post tags -->
                    <!-- <fieldset class="tags">
                         <label for="post_tags">Additional Keywords (comma separated):</label>
                         <input type="text" value="" tabindex="35" name="post_tags" id="post_tags" />
                     </fieldset> -->

                    <fieldset class="ingridients <?php if(isset($hasError) && isset($ingridientsError)) { echo 'error'; } ?>">
                        <h4><span><?php _e('Ingredients:', 'purepress'); ?></span></h4>

                        <div class="box-error-outer <?php if(isset($hasError) && isset($ingridientsError)) { echo 'show'; } ?>" >
                            <div class="box-error">
                                <p><?php echo get_option(PPTNAME . '_recipe_ing_error');?></p>
                            </div>
                        </div>
                        <table id="ingridients-sort" class="widefat">
                            <thead>
                                <tr>
                                    
                                    <th><?php _e("Name of ingriedient", 'purepress'); ?></th>
                                    <th><?php _e("Notes (quantity, additional info)", 'purepress'); ?></th>
                                    <th><?php _e("Actions", 'purepress'); ?></th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr class="ingridients-cont ing">
                                   
                                    <td><input name="cookingpressingridients_name[]" tabindex="5" type="text" class="ingridient" value="" /> </td>
                                    <td><input name="cookingpressingridients_note[]" tabindex="6" type="text" class="notes"  value="" /></td>
                                    <td class="action">
                                        <a  title="Delete ingridient" href="#" class="delete" style="background-image:url('<?php echo get_admin_url(); ?>/images/no.png');"><?php _e("Delete", 'purepress'); ?></a>
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                        <a href="#" class="add_ingridient button "><?php _e("Add new ingridient", 'purepress'); ?></a>
                        <a href="#" class="add_separator button "><?php _e("Add separator", 'purepress'); ?></a>
                        <span class="req"><?php _e('Required', 'purepress'); ?></span>
                    </fieldset>
                    <input type="hidden" value="<?php wp_create_nonce('new-post')?>" id="cookingpressinstructions_noncename" name="cookingpressinstructions_noncename">
                    <fieldset class="instructions <?php if(isset($hasError) && isset($instructionsError)) { echo 'error'; } ?>">
                        <h4>Instructions:</h4>
                        <div class="box-error-outer <?php if(isset($hasError) && isset($instructionsError)) { echo 'show'; } ?>" >
                            <div class="box-error">
                                <p><?php echo get_option(PPTNAME . '_recipe_ins_error');?></p>
                            </div>
                        </div>
                                <?php
                                $editor_settings2 = array(
                                        'wpautop' => true,
                                        'media_buttons' => true,
                                        'editor_class' => 'frontend2',
                                        'textarea_rows' => 5,
                                        'tabindex' => 10,
                                        'teeny' => true
                                );
                                wp_editor(' ','cookingpressinstructions', $editor_settings2);
                                ?>
                        <span class="req"><?php _e('Required', 'purepress'); ?></span>
                    </fieldset>

                    <fieldset class="nutritionfacts">
                        <h4><?php _e("Additional informations:", 'purepress'); ?></h4>
                        <ul id="nutritionfacts_list">
                            <li><?php _e('Preparation time ', 'purepress'); ?><input type="text" name="cookingpressrecipeoptions_preptime" /> <?php _e('minutes', 'purepress'); ?></li>
                            <li><?php _e('Cooking time ', 'purepress'); ?><input type="text" name="cookingpressrecipeoptions_cooktime" /> <?php _e('minutes', 'purepress'); ?></li>
                            <li><?php _e('Yield:', 'purepress'); ?> <input type="text" name="cookingpressrecipeoptions_yield" /></li>
                                    <?php
                                    $nfacts_lists = get_option('cookingpress_nutrition_facts');
                                    $i=0;
                                    if(!empty($nfacts_lists)) {
                                        foreach ($nfacts_lists as $k => $v) {
                                            echo '<li>'. $v['name'];
                                            echo '<input type="text" name="cookingpressntfacts[]" />';
                                            echo  $v['unit'].'</li>';
                                        }
                                    } ?>
                        </ul>
                    </fieldset>

                    <fieldset class="category">
                        <label for="cat"><?php _e('Servings:', 'purepress'); ?></label>
                                <?php $serving = get_terms('serving', 'hide_empty=0'); ?>
                        <select name="serving">
                            <option class='theme-option' value=''>None</option>
                                    <?php foreach ($serving as $serve) {
                                        echo "<option class='theme-option' value='" . $serve->slug . "'>" . $serve->name . "</option>\n";
                                    } ?>
                        </select>
                    </fieldset>
                    <fieldset class="category">
                        <label for="cat"><?php _e('Levels:', 'purepress'); ?></label>
                                <?php $levels = get_terms('level', 'hide_empty=0'); ?>
                        <select name="level">
                            <option class='theme-option' value=''>None</option>
                                    <?php foreach ($levels as $level) {
                                        echo "<option class='theme-option' value='" . $level->slug . "'>" . $level->name . "</option>\n";
                                    } ?>
                        </select>
                    </fieldset>
                    <fieldset class="category">
                        <label for="cat"><?php _e('Time needed:', 'purepress'); ?></label>
                                <?php $timeneeded = get_terms('timeneeded', 'hide_empty=0'); ?>
                        <select name="timeneeded">
                            <option class='theme-option' value=''>None</option>
                                    <?php foreach ($timeneeded as $time) {
                                        echo "<option class='theme-option' value='" . $time->slug . "'>" . $time->name . "</option>\n";
                                    } ?>
                        </select>
                    </fieldset>



                    <fieldset class="submit">
                        <input type="submit" value="<?php _e( 'Post Review', 'purepress' ); ?>" tabindex="40" id="submit" name="submit" />
                        <span><?php _e('Loading', 'purepress'); ?></span>
                    </fieldset>

                    <input type="hidden" name="action" value="new_post" />
                            <?php
                            wp_nonce_field( 'new-post' ); ?>
                </form>

            </div>
            <?php } else { ?>
              
                
                <!-- Custom Login/Register/Password Code @ http://digwp.com/2010/12/login-register-password-code/ -->
<!-- Theme Template Code -->

<div id="login-register-password">

	<?php global $user_ID, $user_identity; get_currentuserinfo(); if (!$user_ID) { ?>


        <ul class="tabs">
            <li class="active"><a href="#tab1_login">Login</a></li>
            <li><a href="#tab2_login">Register</a></li>
            <li><a href="#tab3_login">Lost your password?</a></li>
        </ul>
	<div class="tabs-content loginbox">
		<div id="tab1_login" class="tab">

			<?php $register = $_GET['register']; $reset = $_GET['reset']; if ($register == true) { ?>

                            <h3>Success!</h3>
                            <p>Check your email for the password and then return to log in.</p>

			<?php } elseif ($reset == true) { ?>

                            <h3>Success!</h3>
                            <p>Check your email to reset your password.</p>

			<?php } else { ?>

                            <h3>Have an account?</h3>
                            <p>You need to log in to add recipe.</p>

			<?php } ?>

			<?php wp_login_form(); ?>
		</div>
		<div id="tab2_login" class="tab" style="display:none;">
			<h3>Register for this site!</h3>
			<p>Sign up now for the good stuff.</p>
			<form method="post" action="<?php echo site_url('wp-login.php?action=register', 'login_post') ?>" class="wp-user-form">
				<p class="login-username">
					<label for="user_login"><?php _e('Username'); ?>: </label>
					<input type="text" name="user_login" value="<?php echo esc_attr(stripslashes($user_login)); ?>" size="20" id="user_login" tabindex="101" />
				</p>
				<p class="login-password">
					<label for="user_email"><?php _e('Your Email'); ?>: </label>
					<input type="text" name="user_email" value="<?php echo esc_attr(stripslashes($user_email)); ?>" size="25" id="user_email" tabindex="102" />
				</p>
				<p class="login_fields">
					<?php do_action('register_form'); ?>
					<input type="submit" name="user-submit" value="<?php _e('Sign up!'); ?>" class="user-submit" tabindex="103" />
					<?php $register = $_GET['register']; if($register == true) { echo '<p>Check your email for the password!</p>'; } ?>
					<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>?register=true" />
					<input type="hidden" name="user-cookie" value="1" />
				</p>
			</form>
		</div>
		<div id="tab3_login" class="tab" style="display:none;">
			<h3>Lost your password?</h3>
			<p>Enter your username or email to reset your password.</p>
			<form method="post" action="<?php echo site_url('wp-login.php?action=lostpassword', 'login_post') ?>" class="wp-user-form">
				<p class="login-username">
					<label for="user_login" class="hide"><?php _e('Username or Email'); ?>: </label>
					<input type="text" name="user_login" value="" size="20" id="user_login" tabindex="1001" />
				</p>
				<div class="login_fields">
					<?php do_action('login_form', 'resetpass'); ?>
					<input type="submit" name="user-submit" value="<?php _e('Reset my password'); ?>" class="user-submit" tabindex="1002" />
					<?php $reset = $_GET['reset']; if($reset == true) { echo '<p>A message will be sent to your email address.</p>'; } ?>
					<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>?reset=true" />
					<input type="hidden" name="user-cookie" value="1" />
				</div>
			</form>
		</div>
	</div>

	<?php } else { // is logged in ?>

	<div class="sidebox">
		<h3>Welcome, <?php echo $user_identity; ?></h3>
		<div class="usericon">
			<?php global $userdata; get_currentuserinfo(); echo get_avatar($userdata->ID, 60); ?>

		</div>
		<div class="userinfo">
			<p>You&rsquo;re logged in as <strong><?php echo $user_identity; ?></strong></p>
			<p>
				<a href="<?php echo wp_logout_url('index.php'); ?>">Log out</a> | 
				<?php if (current_user_can('manage_options')) { 
					echo '<a href="' . admin_url() . '">' . __('Admin') . '</a>'; } else { 
					echo '<a href="' . admin_url() . 'profile.php">' . __('Profile') . '</a>'; } ?>

			</p>
		</div>
	</div>

	<?php } ?>

</div>

<!-- Custom Login/Register/Password Code @ http://digwp.com/2010/12/login-register-password-code/ -->
            <?php } ?>

        </div><!-- .entry-content -->


    </article><!-- #post-## -->



        <?php endwhile; // end of the loop. ?>

</section>
<div id="primary">
    <?php echo get_sidebar(); ?></div>
</div>
</div>


<?php get_footer(); ?>







