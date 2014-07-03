// JavaScript Document
(function() {
    tinymce.create('tinymce.plugins.purethemesmce', {
        init : function(ed, url) {

            ed.addCommand('ppTabs', function() {
                ed.windowManager.open({
                    file : url + '/tinymce/tabs.php',
                    width : 500,
                    height : 500,
                    inline : 1
                }, {
                    plugin_url : url
                });
            });
            ed.addButton('pptabs', {title : 'Add Tabs', cmd : 'ppTabs', image: url + '/tinymce/images/tab.png' });

            ed.addCommand('ppAccordion', function() {
                ed.windowManager.open({
                    file : url + '/tinymce/accordion.php',
                    width : 500,
                    height : 500,
                    inline : 1
                }, {
                    plugin_url : url
                });
            });
            ed.addButton('ppaccordion', {title : 'Add Accordion', cmd : 'ppAccordion', image: url + '/tinymce/images/accordion.png' });

            ed.addCommand('ppLists', function() {
                ed.windowManager.open({
                    file : url + '/tinymce/list.php',
                    width : 250,
                    height : 300,
                    inline : 1
                }, {
                    plugin_url : url
                });
            });
            ed.addButton('pplist', {title : 'Add List', cmd : 'ppLists', image: url + '/tinymce/images/lists.png' });

            ed.addCommand('ppColumns', function() {
                ed.windowManager.open({
                    file : url + '/tinymce/columns.php',
                    width : 450,
                    height : 500,
                    inline : 1
                }, {
                    plugin_url : url
                });
            });
            ed.addButton('ppcolumns', {title : 'Add Columns', cmd : 'ppColumns', image: url + '/tinymce/images/columns.png' });

            ed.addCommand('ppBoxes', function() {
                ed.windowManager.open({
                    file : url + '/tinymce/boxes.php',
                    width : 450,
                    height : 370,
                    inline : 1
                }, {
                    plugin_url : url
                });
            });
            ed.addButton('ppboxes', {title : 'Add Box', cmd : 'ppBoxes', image: url + '/tinymce/images/box.png' });
        
            ed.addCommand('ppButton', function() {
                ed.windowManager.open({
                    file : url + '/tinymce/button.php',
                    width : 450,
                    height : 370,
                    inline : 1
                }, {
                    plugin_url : url
                });
            });
            ed.addButton('ppbutton', {title : 'Add Button', cmd : 'ppButton', image: url + '/tinymce/images/brick.png' });

            ed.addButton('dropcap', {
                title : 'Drop Cap',
                image : url+'/tinymce/images/text_dropcaps.png',
                onclick : function() {
                     ed.selection.setContent('[dropcap]' + ed.selection.getContent() + '[/dropcap]');

                }
            });

            ed.addButton('hr', {
                title : 'Separator',
                image : url+'/tinymce/images/link_go.png',
                onclick : function() {
                     ed.selection.setContent('[separator]');

                }
            });

            ed.addButton('purerecipe', {
                title : 'Add Recipe',
                image : url+'/tinymce/images/recipegroup.png',
                onclick : function() {
                     ed.selection.setContent('[purerecipe]');

                }
            });

            ed.addButton('slider', {
                title : 'Add Slider',
                image : url+'/tinymce/images/slider.png',
                onclick : function() {
                     ed.selection.setContent('[slider title="Put Title"]' + ed.selection.getContent() + '[/slider]');

                }
            });
         
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
    tinymce.PluginManager.add('purethemesmce', tinymce.plugins.purethemesmce);
})();