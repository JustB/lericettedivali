
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/backend/css/farbtastic.js"></script>

<style>
    .left {float:left;width:400px}
    .right {float:right;}
    .clear {clear:both}

    #panel-wrapper {


        overflow:hidden;

        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border-radius: 5px; /* future proofing */
    }

    #content {
        padding:0px 15px 0px 0px;
        background: url('<?php echo get_template_directory_uri(); ?>/backend/images/content-bg.jpg') top left;
        position:relative
    }
    #panel-wrapper table tr td {padding:5px}
    #panel-wrapper h2 {
        font: italic 24px/35px Georgia,"Times New Roman","Bitstream Charter",Times,serif;
        margin: 0px 0px 0px 20px;
        padding: 14px 15px 3px 0;
        border-bottom:1px dashed #eee;
        text-shadow: 0 1px 0 #FFFFFF;
    }
    #top { 
        overflow: hidden;
        padding: 10px 0px;
        width:800px
    }
    #top h1 {text-shadow: #fff 0px 1px 1px;
             margin:0px;
             padding:20px 0px 20px;
             color:#5e5e5e;
             font-family: Helvetica, Arial, sans-serif;
             font-size: 35px;
             font-style: normal;
             font-weight: bold;
             letter-spacing: -1px;
             line-height: 0.7em;
             text-shadow: 1px 1px 0px #fff;
             float: left;}
    #top h1 span {
        display:block;
        font-size:16px;
        color:#999;
        text-shadow: 1px 1px 0px #fff;
    }
    div#cookingpress_logo_height,
    div#cookingpress_logo_width {
        display:none;
    }
    #savebar {
        background: url('<?php echo get_template_directory_uri(); ?>/backend/images/menu-noise.png')#4c4c4c;
        padding: 10px;
        text-align: right;
        overflow:hidden;
        -moz-box-shadow:  0 0 30px 1px #303030 inset;
        -webkit-box-shadow:  0 0 30px 1px #303030 inset;
        box-shadow:  0 0 30px 1px #303030 inset;
      
        border-radius:0px 0px 5px 5px ;
        width:787px;
    }
    #panel-wrapper  { padding: 0px;}

    #savebar input.button-primary,
    #top input.button-primary {
        border: 1px solid #13455b;
        background: #298bb9;
        color:#fff;
        text-shadow: 1px 1px 0px #000;

        font-weight: bold;
        font-size: 11px;
        display: block;
        padding: 7px 0 11px;
        text-align:center;
        margin:0px 10px 0 0;
        text-decoration: none;
        width:130px;

        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border-radius: 5px;

        -moz-box-shadow: 0 1px 0 0 #44a6d3 inset,
            0px 1px 2px #000,
            0 -4px 0 #1b668a inset;

        -webkit-box-shadow: 0 1px 0 0 #44a6d3 inset,
            0px 1px 2px #000,
            0 -4px 0 #650606 inset;
        box-shadow:0 1px 0 0 #44a6d3 inset,
            0px 1px 2px #000,
            0 -4px 0 #1b668a inset;
        float: right;
    }
    #savebar input.button-primary:hover,
    #top input.button-primary:hover {
        opacity:.9;
        -moz-box-shadow: 0 1px 0 0 #44a6d3 inset, 0px 1px 2px #44a6d3;
        -webkit-box-shadow: 0 1px 0 0 #44a6d3 inset, 0px 1px 2px #44a6d3;
        box-shadow: 0 1px 0 0 #44a6d3 inset, 0px 1px 2px #44a6d3;
        padding:9px 0px 9px;
    }

    #upload_image_button {
        border: 1px solid #b7b7b7;
        background: #d1d1d1;
        color:#444;
        text-shadow: 1px 1px 0px #fff;

        font-weight: bold;
        font-size: 11px;

        padding: 7px 0 11px;
        text-align:center;
        margin:0px 20px 0px 0px;
        text-decoration: none;
        width:130px;

        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border-radius: 5px;

        -moz-box-shadow: 0 1px 0 0 #fff inset,
            0px 1px 2px #666,
            0 -4px 0 #909090 inset;

        -webkit-box-shadow: 0 1px 0 0 #fff inset,
            0px 1px 2px #666,
            0 -4px 0 #909090 inset;
        box-shadow:0 1px 0 0 #fff inset,
            0px 1px 2px #666,
            0 -4px 0 #909090 inset;
    }


    #top input.button-primary:hover {


    }
    #savebar a.btn {
        float:left;
        margin:10px 0px 0px 20px;
    }
    .btn,
    a.btn {
        border: 1px solid #5b0a0f;
        background: #941313;
        color:#fff;
        text-shadow: 1px 1px 0px #000;

        font-weight: bold;
        font-size: 11px;
        display: block;
        padding: 5px 0 9px;
        text-align:center;
        margin:10px 20px 0px 0px;
        text-decoration: none;
        width:130px;

        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border-radius: 5px;

        -moz-box-shadow: 0 1px 0 0 #c86666 inset,
            0px 1px 2px #000,
            0 -4px 0 #650606 inset;

        -webkit-box-shadow: 0 1px 0 0 #c86666 inset,
            0px 1px 2px #000,
            0 -4px 0 #650606 inset;
        box-shadow:0 1px 0 0 #c86666 inset,
            0px 1px 2px #000,
            0 -4px 0 #650606 inset;
        float: right;
    }
    .btn:hover,
    a.btn:hover {
        opacity:.9;
        -moz-box-shadow: 0 1px 0 0 #c86666 inset, 0px 1px 2px #8D8D8D;
        -webkit-box-shadow: 0 1px 0 0 #c86666 inset, 0px 1px 2px #8D8D8D;
        box-shadow: 0 1px 0 0 #c86666 inset, 0px 1px 2px #8D8D8D;
        padding:7px 0px;
    }



    #panel-wrapper div.panel-element {
        border-top: 1px solid #f2f2f2;
        padding: 20px;
        position: relative;
    }
  
    #panel-wrapper  div span.help {
        background: url('<?php echo get_template_directory_uri(); ?>/backend/images/icons/information.png') no-repeat;
        display: block;
        height: 24px;
        position: absolute;
        right: 15px;
        text-indent: -9999px;
        top: 15px;
        width: 24px;
        cursor: pointer
    }

    #panel-wrapper  p.help-info {
        background: #FFFFFF;
        border: 4px solid #e6e6e6;
        display: none;
        position: absolute;
        right: 40px;
        top: 16px;
        z-index: 110;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border-radius: 5px;

        -moz-box-shadow: 1px 1px 2px #999;
        -webkit-box-shadow: 1px 1px 2px #999;
        box-shadow: 1px 1px 2px #999;
    }

    #panel-wrapper  p.help-info span{
        -moz-border-radius: 3px;
        -webkit-border-radius: 3px;
        border-radius: 3px;
        border: 1px solid #CFCFCF;
        padding: 15px;
        display:block;
    }

    div.preview-upload {
        background:#fff;
        border:1px solid #ddd;
        width:350px;
        -moz-box-shadow: 0px 0px 16px #ddd;
        -webkit-box-shadow: 0px 0px 16px #ddd;
        box-shadow: 0px 0px 16px #ddd;
        margin:20px auto;
        text-align: center;
        display: none;
    }

    #panel-wrapper  label {
        display:block;
        width:190px;
        padding-right:20px;
        float:left;
        font-weight: bold;
    }

    #panel-wrapper  select {
        padding:10px;
        height:auto;
    }
    textarea,
    select,
    input {
      padding:10px;
    border-radius: 5px 5px 5px 5px;
    box-shadow: 1px 1px 1px #DDDDDD;
    }
    textarea:focus,
    select:focus,
    input:focus {
         box-shadow: 0 0 2px 1px #06D3FF
}
    .icon-general { background: url('<?php echo get_template_directory_uri(); ?>/backend/images/icons/home.png') center left no-repeat;    }
    .icon-book { background: url('<?php echo get_template_directory_uri(); ?>/backend/images/icons/address-book.png') center left no-repeat;    }
    .icon-layout { background: url('<?php echo get_template_directory_uri(); ?>/backend/images/icons/application-sidebar.png') center left no-repeat;    }
    .icon-color { background: url('<?php echo get_template_directory_uri(); ?>/backend/images/icons/color.png') center left no-repeat;    }
    .icon-gallery { background: url('<?php echo get_template_directory_uri(); ?>/backend/images/icons/photo-album.png') center left no-repeat;    }
    .icon-user { background: url('<?php echo get_template_directory_uri(); ?>/backend/images/icons/user-business.png') center left no-repeat;    }


    ul#cookingpress_ex_cats {
        background: none repeat scroll 0 0 #EEEEEE;
        overflow: hidden;
        padding: 20px;
    }
    #panel-wrapper  #cookingpress_ex_cats li {
        float: left;
        margin:5px;
        background:#fff;
        padding:5px;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border-radius: 5px;
        border:none;
    }
    #panel-wrapper  #cookingpress_ex_cats li.exclude {
        background: #941313;
        color:#fff;
    }
    #cookingpress_single_postmeta,
    #cookingpress_postmeta {
        overflow:hidden;
    }
    #cookingpress_single_postmeta p,
    #cookingpress_postmeta p {
        width:200px;
        float:left;
        background: none repeat scroll 0 0 #EEEEEE;
        overflow: hidden;
        padding: 20px;
        margin-right:5px;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border-radius: 5px;
    }
     #cookingpress_single_postmeta p label,
    #cookingpress_postmeta p label { width:150px;}

    form.reset {
        margin-left:30px;
        margin-top:20px
    }
    form.reset p {
        padding:5px;
        margin:0px;
    }

    .farbtastic {
        position: relative;
    }
    .farbtastic * {
        position: absolute;
        cursor: crosshair;
    }
    .farbtastic, .farbtastic .wheel {
        width: 195px;
        height: 195px;
    }
    .farbtastic .color, .farbtastic .overlay {
        top: 47px;
        left: 47px;
        width: 101px;
        height: 101px;
    }
    .farbtastic .wheel {
        background: url(<?php echo get_template_directory_uri(); ?>/backend/images/wheel.png) no-repeat;
        width: 195px;
        height: 195px;
    }
    .farbtastic .overlay {
        background: url(<?php echo get_template_directory_uri(); ?>/backend/images/mask.png) no-repeat;
    }
    .farbtastic .marker {
        width: 17px;
        height: 17px;
        margin: -8px 0 0 -8px;
        overflow: hidden;
        background: url(<?php echo get_template_directory_uri(); ?>/backend/images/marker.png) no-repeat;
    }
    .pickerhandler{
        left: 700px;
        position: absolute;

    }


    /* Tabs
----------------------------------*/
    .ui-tabs { padding: 0px; zoom: 1;background: url('<?php echo get_template_directory_uri(); ?>/backend/images/panelbg.jpg') -3px repeat-y;  }
    .ui-tabs .ui-tabs-nav { list-style: none; position: relative; padding: .2em .2em 0; border:0px !important; box-shadow: 0px 0px 0px #EEEEEE inset}
    .ui-tabs .ui-tabs-nav li { position: relative; float: left; border-bottom-width: 0 !important; margin: 0 .2em -1px 0; padding: 0; }
    .ui-tabs .ui-tabs-nav li a { float: left; text-decoration: none; padding: 1em;     color: #5E5E5E;}
    .ui-tabs .ui-tabs-nav li.ui-tabs-selected { padding-bottom: 1px; border-bottom-width: 0; font-weight: bold;}
    .ui-tabs .ui-tabs-nav li.ui-tabs-selected a, .ui-tabs .ui-tabs-nav li.ui-state-disabled a, .ui-tabs .ui-tabs-nav li.ui-state-processing a { cursor: text; }
    .ui-tabs .ui-tabs-nav li a, .ui-tabs.ui-tabs-collapsible .ui-tabs-nav li.ui-tabs-selected a { cursor: pointer; } /* first selector in group seems obsolete, but required to overcome bug in Opera applying cursor: text overall if defined elsewhere... */
    .ui-tabs .ui-tabs-panel { padding: 1em 1.4em; display: block; border-width: 0; background: none; }
    .ui-tabs .ui-tabs-hide { display: none !important; }
    .ui-tabs-vertical { width: 805px; }
    .ui-tabs-vertical .ui-tabs-nav { padding:5px 1px; float: left; width: 145px; }
    .ui-tabs-vertical .ui-tabs-nav li { clear: left; width: 100%; border-right: 1px solid #D6D6D6;border-bottom-color: #DFDFDF;
        border-top-color: #F9F9F9; margin: 0 0; background-color:#eee;
        background-image: url("<?php echo get_bloginfo('siteurl'); ?>/wp-admin/images/menu-shadow.png");
        background-position: right top;
        background-repeat: repeat-y;
    }
    .ui-tabs-vertical .ui-tabs-nav li a { display:block; font-size:13px; color: #21759B;border-style: solid;
        border-width: 1px 0;
        font-weight: bold;
        line-height: 18px;
        min-width: 10em;
        border-bottom-color: #DFDFDF;
        border-top-color: #F9F9F9;
    }
    .ui-tabs-vertical .ui-tabs-nav li.ui-tabs-selected { padding-bottom: 0; padding-right: .1em; border-right-width: 1px; border-right-width: 1px;  background:#fff;}
    .ui-tabs-vertical .ui-tabs-panel { float: right;
                                       padding: 30px 0;
                                       width: 650px;}
    .ui-helper-clearfix {
        border: 1px solid #DDDDDD;
        border-radius: 5px 5px 0px 0px;
        box-shadow: 5px 5px 0 #EEEEEE inset;
        clear: both;
        overflow: hidden;
    }


    .rtl #panel-wrapper {
        float:left
    }
</style>