(function($){
    $(document).ready(function(){

        /*
 *
 * Single page gallery script
 * @author rzepak
 *
 */
        var conveyor = $("#thumbs"),
        item = $("#thumbs li");

        //set length of conveyor
    

        //config
        var sliderOpts = {
            animate: true,
            max: (item.length * parseInt(item.css("width")))-405,
            slide: function(e, ui) {
                conveyor.css("left", "-" + ui.value + "px");
            }
        };

        //create slider
        $("#content-slider").slider(sliderOpts);
 
        $('#slider img').hide();

        if ($('#slider').length) {
            var startwidth = $('#slider img').width();
            var startheight = $('#slider img').height();
            $('#slider').width(startwidth).height(startheight);
        }
        //         $('#thumbs li:first').find('.exif-data').clone().appendTo("#slider-wrapper");
        //         $('#thumbs li:first').find('.singlephoto-tools').clone().appendTo("#slider-wrapper");
        $(function() {
            //some elements..
            var $container	= $('body.single,body.page'),
            $image_wrapper 	= $container.find('#slider'),
            $nextBtn = $container.find('.next'),
            $prevBtn = $container.find('.prev'),
            $thumbs	= $container.find('#thumbs'),

            $links = $thumbs.children('li'),
            total_images = $links.length,
            current	= 0,
            $loader	= $('#loader');
            $nextBtn.hide();
            /*first preload images (thumbs and large images)*/
            $links.each(function(i){
                var $link 	= $(this);
                $link.find('img').css('opacity','0.4');
                $link.find('a').preload({
                    onComplete: function() {
                        $link.find('img').animate({
                            opacity : '1'
                        });
                        $nextBtn.fadeIn();
                    }
                }
                );
            });

            $prevBtn.hide();
           
            $loader.hide();
            $image_wrapper.find('img').show();
            //clicking on one will display the respective image
            $links.bind('click',showImage);
            //navigate through the images
            $nextBtn.bind('click',nextImage);
            $prevBtn.bind('click',prevImage);
            //mousewheel navigation
            $image_wrapper.bind('mousewheel', function(event, delta) {
                if (delta > 0){
                    nextImage();
                } else {
                    prevImage();
                }
                return false;
            });
            //keyboard navigation - arrows
            $(document.documentElement).keyup(function (event) {
                if (event.keyCode == 37) {
                    prevImage();
            
                    return false;
                }
                else if (event.keyCode == 39) {
                    nextImage();
                    return false;
                }
            });


            function showImage(e){
                var $link = $(this),
                idx	= $link.index(),
                $image = $link.find('a').attr('href'),
                total_images = $('#thumbs li').length,
                $currentImage = $image_wrapper.find('img'),
                currentImageWidth = $currentImage.width(),
                $nextBtn			= $('.next'),
                $prevBtn			= $('.prev');

                //if we click the current one return false
                if(current == idx) return false;
                $prevBtn.show();
                $nextBtn.show();
                // if it's first, hide prev button
                if(idx == 0){
                    $prevBtn.fadeOut();
                }
                // if it's last, hide next button
                if(idx+1 == total_images){
                    $nextBtn.fadeOut();
                }

                //add class selected to the current page
                $links.removeClass('selected');
                $link.addClass('selected');
                $("#slider-wrapper .exif-data").remove();
                $("#slider-wrapper .singlephoto-tools").remove();
                $("#slider-wrapper .singlephoto-caption").remove();
                $link.find('.exif-data').clone().appendTo("#slider-wrapper");
                $link.find('.singlephoto-tools').clone().appendTo("#slider-wrapper");
                $link.find('.singlephoto-caption').clone().appendTo("#slider-wrapper");


                // new image
                //                var $newImage = $('<img/>').css('left',currentImageWidth + 'px')
                //                .attr('src',$image);

                // title
                $("#slider-wrapper h2").remove();
                
        
                //remove old image
                
                if($image_wrapper.children().length > 1)
                    $image_wrapper.children(':last').remove();
                
                // $loader.show();
                $($image_wrapper).image($image,function () { 
                    // $loader.hide();

                    //var newImageWidth	= $(this).width();
                    //var newImageHeight	= $(this).height();
                    $(this).css('left',currentImageWidth + 'px')
                             

                    var img = $(this)[0]; // obrazek jako element DOM
                    var self = this;
                    $("<img/>").attr("src", $(img).attr("src")).load( function() {
                        var newImageWidth = this.width,
                        newImageHeight = this.height;
                        //check animation direction
                        if(current > idx){
                            $(self).css('left',- newImageWidth + 'px');
                            currentImageWidth = - newImageWidth;
                        }
                        current = idx;
                        //animate the new width and height
                        $image_wrapper.stop().animate({
                            width	: newImageWidth + 'px',
                            height  : newImageHeight + 'px'
                        },350);
                        //animate the new image in
                        $(self).stop().animate({
                            left	: '0px'
                        },350);
                        //animate the old image out
                        $currentImage.stop().animate({
                            left	: - currentImageWidth + 'px'
                        },350);
                    });
                  
                });
                
                e.preventDefault();
            }

            function nextImage(){
                if(current < total_images){
                    $links.eq(current+1).trigger('click');
                    $nextBtn.show();
                    $prevBtn.show();
                }
                if(current+1 == total_images){
                    $nextBtn.fadeOut();
                }
             
            }
            function prevImage(){
                if(current > 0){
                    $links.eq(current-1).trigger('click');
                    $prevBtn.show();
                    $nextBtn.show();
                }
                if(current == 0) {
                    $prevBtn.fadeOut();
                }
            }


            $('#slider-wrapper a.exif-switch').live('click',function(e){
                $('#slider-wrapper').find('.exif-data').fadeIn();
                e.preventDefault();
                return false;
            });
            $('#slider-wrapper .exif-data').live('click',function(e){
                if ( $(e.target).is('#slider-wrapper .exif-data ul') ) {
                    return false;
                }
                else {
                    $(this).fadeOut();
                }
            
            });
       
        });

        /*
 *
 * Thumbs scroller
 * @author rzepak
 *
 */

        function thumbsScroller() {
            var thumbs = $('#thumbs'),
            thumbsCont = $('#thumbs-scroller'),
            // divWidth = thumbsCont.width(),
            thumb = thumbs.find('li'),
            thumbslength = thumb.length;
            //  var extra           = 800;
            var singleHeight = thumb.outerHeight(true);
            var singleWidth = thumb.outerWidth(true);
            thumbsCont.height(singleHeight+10);

            thumbs.width(singleWidth*thumbslength);
   

          
            thumbsCont.scrollLeft(0);
            //When user move mouse over menu
            thumb.bind('click',function(e){
                var $link = $(this),
                idx	= $link.index();
               
                var left2 = $('#thumbs li').eq(idx).position().left;

                $( "#content-slider" ).slider( "value", left2 );
                
                if (left2 > 405) {
                    thumbs.animate({
                        left: -left2+405
                    });
                }
                if (left2 < 405) {
                    thumbs.animate({
                        left: 0
                    });
                }
                
            });

        }
        $.fn.image = function(src, f){
            return this.each(function(){
                $("<img />").prependTo(this).each(function(){
                   
                    this.onload = f;
                    this.src = src;
                });
            });
        }

        thumbsScroller();

    });

    (function($) {
        $.fn.preload = function(options) {
            var opts 	= $.extend({}, $.fn.preload.defaults, options),
            o		= $.meta ? $.extend({}, opts, this.data()) : opts;
            return this.each(function() {
                var $e	= $(this),
                t	= $e.find('img').attr('src'),
                i	= $e.attr('href'),
                l	= 0;
                $('<img/>').load(function(i){
                    ++l;
                    if(l==2) o.onComplete();
                }).attr('src',i);
                $('<img/>').load(function(i){
                    ++l;
                    if(l==2) o.onComplete();
                }).attr('src',t);
            });
        };
        $.fn.preload.defaults = {
            onComplete	: function(){
                return false;
            }
        };
    })(jQuery);

})(this.jQuery);



