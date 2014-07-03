<?php
if(function_exists('register_sidebar')) {
    register_sidebar(array(
            'id' => 'sidebar',
            'name'=>'Sidebar Area',
            'before_widget' => '<div id="%1$s" class="widget  %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3><span>',
            'after_title' => '</span></h3>',
    ));
    register_sidebar(array(
            'id'=>'footerleft',
            'name'=>'Footer Left Column',
            'description' => 'Left column for widgets in Footer.',
            'before_widget' => '<div id="%1$s" class="widget column  %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3><span>',
            'after_title' => '</span></h3>',
    ));
    register_sidebar(array(
            'id'=>'footercenter',
            'name'=>'Footer Center Column',
            'description' => 'Center column for widgets in Footer.',
            'before_widget' => '<div id="%1$s" class="widget column  %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3><span>',
            'after_title' => '</span></h3>',
    ));
    register_sidebar(array(
            'id'=>'footerright',
            'name'=>'Footer Right Column',
            'description' => 'Right column for widgets in Footer.',
            'before_widget' => '<div id="%1$s" class="widget column  %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3><span>',
            'after_title' => '</span></h3>',
    ));
}
if (get_option('pp_sidebars')):

    $pp_sidebars = get_option('pp_sidebars');
    foreach ($pp_sidebars as $k => $pp_sidebar) {

        $sb_id = str_replace(" ","", $pp_sidebar["name"]);

        register_sidebar( array(
                'name' => $pp_sidebar["name"],
                'id' => strtolower($sb_id),
                'description' => $pp_sidebar["desc"],
                'before_widget' => '<div id="%1$s" class="widget column  %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3><span>',
                'after_title' => '</span></h3>',
                ) );

}

endif;
?>