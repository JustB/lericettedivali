(function($){

    $(document).ready(function(){
        //gallery load
 
        set_saved_gallery()
        $('#load-gallery').click(function(){
            id = $(this).attr('class');
            url = $(this).attr('rel');
            $('#gallloading').css('display','block');
           
            $.ajax({
                data: 'id='+id,
                url: url,
                success: function(data) {
                    $('#gallery-exlude').remove();
                    $('#gallloading').css('display','none');
                    $('.pp-gallery-exluder .pp_h4').after(data);
                    set_saved_gallery()
                }
            })
            return false;
        })
      
        $('#gallery-exlude li').live('click',function(){
            $this = $(this); 
            if ($this.hasClass('exclude')) {
                $this.removeClass('exclude');
                exlude_gallery()

            }else {
                $this.addClass('exclude');
                exlude_gallery()
            }
        });



        $('#flexorder').change(function(){
            exlude_gallery();
        });
        $('#flexorderby').change(function(){
            exlude_gallery();
        });
        
        
        function exlude_gallery(){
            var allEcxlude = [];
            $('#gallery-exlude li.exclude').each(function (i){
                var excluded = $(this).attr('id');
                allEcxlude[allEcxlude.length] = Number(excluded);
            });
                
            $('#ppgallery-exlude').val(allEcxlude.join(", "));
            var excluded = allEcxlude.join(", ");
            var order = $('#flexorder').val();
            var orderby = $('#flexorderby').val();
          
            $('input#generated-code').val('[puregallery exclude="'+excluded+'" order="'+order+'" orderby="'+orderby+'"]')
        }

        function set_saved_gallery(){
            var excluded = $('#ppgallery-exlude').val();
            if(excluded) {
                var excluded_array = excluded.split(', ');

                for( index in excluded_array){
                    $("#"+excluded_array[index]).addClass('exclude');
                }
            }

        }


$('a#remove-recipe-photo').click(function(e){
   
    e.preventDefault();
    $('#recipe-drop-area img').remove();
    $('input#cookingpressphoto').val('');
})

        function switch_metabox() {
            var posttype = $('select#posttype').val();
            if(  posttype == 'photopost_type' || posttype == 'photoposthorizontal_type'){
                $('.pp-gallery-exluder').slideDown();
                $('#galleryorder').slideDown();
                $('#loadertype').slideDown();
            } else {
                $('.pp-gallery-exluder').slideUp();
                $('#galleryorder').slideUp();
                $('#loadertype').slideUp();
            }
        }
    
        $("select#posttype").change(switch_metabox);
        switch_metabox();




        window.formfield = '';

        $('#upload_image_button').live('click', function() {
            window.formfield = $('.upload_field',$(this).parent());
            tb_show('', 'media-upload.php?type=image&TB_iframe=true');
            return false;
        });

        window.original_send_to_editor = window.send_to_editor;
        window.send_to_editor = function(html) {
            if (window.formfield) {
                imgurl = $('img',html).attr('src');
                window.formfield.val(imgurl);
                tb_remove();
            }
            else {
                window.original_send_to_editor(html);
            }
            window.formfield = '';
            window.imagefield = false;
        }


        $('#gallery-exlude li ').draggable({
            helper: "clone",
            revert: "invalid"
        });

        function addIng() {
            var newElem = $('tr.ingridients-cont.ing:first').clone();
            newElem.find('input').val('');
            newElem.appendTo('table#ingridients-sort');
        }
        $('.add_ingridient').click(function(e){
            e.preventDefault();
            addIng();
            addIng();
            addIng();
        })

        $('.add_separator').click(function(e){
            e.preventDefault();
            var newElem = $('<tr class="ingridients-cont separator"><td><a title="Drag and drop rows to sort table" href="#" class="move">move</a></td><td><input name="cookingpressingridients_name[]" type="text" class="ingridient"  value="" /></td><td><input name="cookingpressingridients_note[]" type="text" class="notes"  value="separator" /></td><td class="action"></a></td></tr>');
            newElem.appendTo('table#ingridients-sort');
        })

       var fixHelper = function(e, ui) {
            ui.children().each(function() {
                $(this).width($(this).width());
            });
            return ui;
        };
        $('table#ingridients-sort tbody').sortable({
              helper: fixHelper
        });

        $('#ingridients-sort .delete').live('click',function(e){
            e.preventDefault();
            $(this).parent().parent().remove();
        });

    
 $('#ingridients-sort input.ingridient').live('keyup.autocomplete', function(){
    $(this).autocomplete({
      source: availableTags
    });
  });


        getfeatphoto();
        $( "#recipe-drop-area" ).droppable({
            activeClass: "ui-state-active",
            drop: function(event, ui) {
                $(this).addClass('loading');
                var dropid = $(ui.draggable).attr('id');
                $('input#cookingpressphoto').val(dropid);
                getfeatphoto();
            }
        });

           function getfeatphoto(){
                 var id = $('input#cookingpressphoto').val();
                 var data = {
                        action: 'get_feat_photo',
                        id: id
                    };
                    $.post(ajaxurl, data, function(response) {
                        $('#recipe-drop-area').html(response); //.masonry('reload');

                    })
        }



        // init main map in panel setup
        // if #address has value add marker to map
 

        ///
        
       
        
       
    });
    

})(this.jQuery);

  