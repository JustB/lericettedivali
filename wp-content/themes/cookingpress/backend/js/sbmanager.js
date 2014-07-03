jQuery(document).ready(function($) {
	
    // calls appendo
    $('#manager_form_wrap').appendo({
        allowDelete: false,
        labelAdd: 'Add New Sidebar',
        subSelect: 'li.sidebar:last'
    });
	
    // slide delete button
    $('#manager_form_wrap .remove_slide').live('click', function() {
        if($('#manager_form_wrap li.sidebar').size() == 1) {
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


 

  
});

