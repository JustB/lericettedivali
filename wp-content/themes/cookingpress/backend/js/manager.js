jQuery(document).ready(function($) {
	
    // calls appendo
    $('#manager_form_wrap').appendo({
        allowDelete: false,
        labelAdd: 'Add New Slide',
        subSelect: 'li.slide:last'
    });
	
    // slide delete button
    $('#manager_form_wrap li.slide .remove_slide').live('click', function() {
        if($('#manager_form_wrap li.slide').size() == 1) {
            alert('Sorry, you need at least one element');
        }
        else {
            $(this).parent().slideUp(300, function() {
                $(this).remove();
            })
        }
        return false;
    });

	
    // $ UI sortable
    $("#manager_form_wrap").sortable({
        placeholder: 'slide-highlight'
    });


    $('.sidebar-name').live('click', function() {
        var box = $(this).parent().find('.slide-inside');
        box.toggle();
    });

    $('input.slide_title').live('keyup',function(){
        var title = $(this).val();
        $(this).parent().parent().parent().parent().parent().find('h3 span').text(title);
    })
    // media uploader
    $('.upload_image_button').live('click', function() {
        $(this).parent().addClass('current');
        var post_id = $(this).parent().find('label').attr("id");
        tb_show('', 'media-upload.php?type=image&amp;&amp;post_id='+post_id+'send=true&amp;TB_iframe=true');
        return false;
    });

    window.send_to_editor = function(html) {
        //var imgurl = $('img',html).attr('src');
        var imgurl = html.match(/src=\".*\" alt/);
        imgurl = imgurl[0].replace(/^src=\"/, "").replace(/" alt$/, "");
             
        $('.current .slide_src').val(imgurl);
        tb_remove();
        $('.current').removeClass('current');

    }

    //slider choose

    if($('input#automatic:checked').val() == 'automatic'){
        $('#automatic-container').show();
        $('#manual-container').hide();
    }
    if($('input#manual:checked').val() == 'manual'){
        $('#automatic-container').hide();
        $('#manual-container').show();
    }
    if($('input#none:checked').val() == 'none'){
        $('#automatic-container').hide();
        $('#manual-container').hide();
    }
    $('input#automatic').change(function(){
        $('#automatic-container').fadeIn('fast');
        $('#manual-container').fadeOut('fast');
    });

    $('input#manual').change(function(){
      
        $('#automatic-container').fadeOut('fast');
        $('#manual-container').fadeIn('fast');
    });
    $('input#none').change(function(){

        $('#automatic-container').fadeOut('fast');
        $('#manual-container').fadeOut('fast');
    });
});

