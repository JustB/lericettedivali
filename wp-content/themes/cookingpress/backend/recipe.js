// JavaScript Document
(function() {
    tinymce.create('tinymce.plugins.recipe', {
        init : function(ed, url) {

            ed.addCommand('pprecipe', function() {
                ed.windowManager.open({
                    file : url + '/tinyMCErecipe.php',
                    width : 750,
                    height : window.innerHeight -200,
                    inline : 1,
                    popup_css : false
                }, {
                    plugin_url : url
                });
            });
            ed.addButton('pprecipe', {title : 'Add Recipe', cmd : 'pprecipe', image: url + '/tinymce/images/recipegroup.png' });



        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function(){
            return {
                longname: 'Purethemes TinyMCE Buttons',
                author: 'Purethemes',
                authorurl: 'http://purethemes.net/',
                version: "1.0"
            };
        }
    });
    tinymce.PluginManager.add('recipe', tinymce.plugins.recipe);
})();