<?php
// Call WP Load
$wp_include = "../wp-load.php";
$i = 0;
while (!file_exists($wp_include) && $i++ < 10) {
    $wp_include = "../$wp_include";
} require



        ($wp_include);
if ( !is_user_logged_in() || !current_user_can('edit_posts') )
    wp_die(__("You are not allowed to be here","purepress"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Columns creator</title>
        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/backend/css/tinymce.css?v=2" type="text/css" media="screen" />
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo home_url() ?>/wp-includes/js/tinymce/tiny_mce_popup.js?v=3211"></script>
        <script type="text/javascript" >
            tinyMCEPopup.requireLangPack();


            var ListsDialog = {
                local_ed : 'ed',
                init : function(ed) {
                    ListsDialog.local_ed = ed;
                    var f = document.forms[0];
                    output = '';
                    // Get the selected contents as text and place it in the input
                    //f.someval.value = tinyMCEPopup.editor.selection.getContent({format : 'text'});
                    jQuery('.select-col').click(function(){

                        jQuery(".select-col").attr('class', 'select-col');
                          jQuery(this).addClass('active');
                    
                    });

                },

                insert : function() {

                    var cols = jQuery('.select-col.active').attr('id');;

        switch(cols)
        {
            case "two": output = "[half] Content for 1st column [/half] [halflast] Content for 2nd column [/halflast]";
                break;
            case "three": output= "[onethree] Content for 1st column [/onethree] [onethree] Content for 2st column [/onethree] [onethreelast] Content for 3rd column [/onethreelast]";
                break;
            case "four": output= "[onefourth] Content for 1st column [/onefourth] [onefourth] Content for 2st column [/onefourth] [onefourth] Content for 3rd column [/onefourth] [onefourthlast] Content for 4th column [/onefourthlast]";
                break;
            case "five": output= "[onefifth] Content for 1st column [/onefifth] [onefifth] Content for 2st column [/onefifth] [onefifth] Content for 3rd column [/onefifth] [onefifth] Content for 4th column [/onefifth] [onefifthlast] Content for 5th column [/onefifthlast]";
                break;
            case "onetwo": output= "[onethree] Content for 1st column [/onethree] [threethree] Content for 2st column [/threethree]";
                break;
            case "onethree": output= "[onefourth] Content for 1st column [/onefourth] [threefourth] Content for 2st column [/threefourth]";
                break;
            case "twothree": output= "[twofifth] Content for 1st column [/twofifth] [threefifth] Content for 2st column [/threefifth]";
                break;
            default: output ="default";
        }

                    // Insert the contents from the input into the document
                    tinyMCEPopup.editor.execCommand('mceInsertContent', false, output);
                    tinyMCEPopup.close();
                }
            };

            tinyMCEPopup.onInit.add(ListsDialog.init, ListsDialog);

        </script>
    </head>
    <body>

        <form onsubmit="ListsDialog.insert();return false;" action="#">
            <div id="lists">

                <h3>Choose list style</h3>
                <p>Click columns layout you want to choose and fill them in post editor</p>
                <div class="select-col" id="two">
                    <h5>Two columns</h5>
                    <div class="col half"></div>
                    <div class="col half-last"></div>
                    <div class="clear"></div>
                </div>
                <div class="select-col" id="three">
                    <h5>Three columns</h5>
                    <div class="col one-three"></div>
                    <div class="col one-three"></div>
                    <div class="col one-three-last"></div>
                    <div class="clear"></div>
                </div>
                <div class="select-col" id="four">
                    <h5>Four columns</h5>
                    <div class="col one-fourth"></div>
                    <div class="col one-fourth"></div>
                    <div class="col one-fourth"></div>
                    <div class="col one-fourth-last"></div>
                    <div class="clear"></div>
                </div>
                <div class="select-col" id="five">
                    <h5>Five columns</h5>
                    <div class="col one-fifth"></div>
                    <div class="col one-fifth"></div>
                    <div class="col one-fifth"></div>
                    <div class="col one-fifth"></div>
                    <div class="col one-fifth-last"></div>
                    <div class="clear"></div>
                </div>
                <div class="select-col" id="onetwo">
                    <h5>Columns 1/3 and 2/3 </h5>
                    <div class="col one-three"></div>
                    <div class="col three-three"></div>
                    <div class="clear"></div>
                </div>
                <div class="select-col"  id="onethree">
                    <h5>Columns 1/4 and 3/4 </h5>
                    <div class="col one-fourth"></div>
                    <div class="col three-fourth"></div>
                    <div class="clear"></div>
                </div>
                <div class="select-col" id="twothree">
                    <h5>Columns 2/5 and 3/5 </h5>
                    <div class="col two-fifth"></div>
                    <div class="col three-fifth"></div>
                    <div class="clear"></div>
                </div>

                <div class="mceActionPanel">
                    <input type="button" id="insert" name="insert" value="{#insert}" onclick="ListsDialog.insert();" />
                    <input type="button" id="cancel" name="cancel" value="{#cancel}" onclick="tinyMCEPopup.close();" />
                </div>
        </form>

    </body>
</html>
