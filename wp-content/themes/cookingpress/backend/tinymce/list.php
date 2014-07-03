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
        <title>Lists generator</title>
        <link rel="stylesheet" href="<?php echo home_url() ?>/backend/css/tinymce.css" type="text/css" media="screen" />
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
                    jQuery('#selector').change(function(){
                       
                        jQuery("#selector option:selected").each(function () {
                           
                           var style = $(this).val();
                         jQuery("ul.purelist").attr('class', 'purelist').addClass(style);
                          });
                    }).change();

                },

                insert : function() {

                    var choosedStyle = jQuery('#selector option:selected').val();
                        
                    output = ' [list type='+choosedStyle+']'+ ListsDialog.local_ed.selection.getContent() + ' [/list] ';
                   
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
                    <p>
                        <select id="selector">
                            <option value="asterisk">Asterisk</option>
                            <option value="go">Bullet Go</option>
                            <option value="bullet_green">Bullet Green</option>
                            <option value="bullet_orange">Bullet Orange</option>
                            <option value="bullet_pink">Bullet Pink</option>
                            <option value="bullet_purple">Bullet Purple</option>
                            <option value="bullet_star">Bullet Star</option>
                            <option value="bullet_red">Bullet Red</option>
                            <option value="bullet_yellow">Bullet Yellow</option>
                            <option value="information">Info</option>
                            <option value="key">Key</option>
                            <option value="lightning">Lightning</option>
                            <option value="picture">Picture</option>
                            <option value="star">Star</option>
                            <option value="tag_green">Tag green</option>
                            <option value="tag_orange">Tag orange</option>
                            <option value="tag_pink">Tag pink</option>
                            <option value="tag_red">Tag red</option>
                            <option value="tag_yellow">Tag yellow</option>
                        </select>

                    </p>
                    <p>
                        <h3>List example: </h3>
                        <ul class="purelist">
                            <li>List element 1</li>
                            <li>List element 2</li>
                            <li>List element 3</li>
                        </ul>
                    </p>
            </div>

            <div class="mceActionPanel">
                <input type="button" id="insert" name="insert" value="{#insert}" onclick="ListsDialog.insert();" />
                <input type="button" id="cancel" name="cancel" value="{#cancel}" onclick="tinyMCEPopup.close();" />
            </div>
        </form>

    </body>
</html>
