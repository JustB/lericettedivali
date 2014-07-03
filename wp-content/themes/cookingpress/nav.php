<?php
/**
 * Navigation for wpTraveller.
 *
 * @package WordPress
 * @subpackage wpTraveller
 * @since wpTraveller 1.0
 */
?>
<nav id="nav" role="navigation" class="col_4 omega">
    <?php
    $menu = wp_nav_menu(
            array('topmenu' => 'Top Menu', 'fallback_cb' => 'purepress_nav_fallback', 'echo'=>0 )
    );

    $menu = str_replace("\n", "", $menu);
    $menu = str_replace("\r", "", $menu);
    echo $menu;
    ?>
    <?php
    wp_nav_menu(array(
            'mobilemenu' =>'Mobile Menu',
            'walker'         => new Walker_Nav_Menu_Dropdown(),
            'items_wrap'     => '<select id="mobile-nav"><option value="/">Select Page</option>%3$s</select>',
    ));
?>
</nav><!-- #nav -->

