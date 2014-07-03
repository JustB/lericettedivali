     (function($){ jQuery.fn.styleSwitcher = function(){
                $(this).click(function(){
                    loadStyleSheet(this);
                    return false;
                });
                function loadStyleSheet(obj) {
                    $('body').append('<div id="overlay" />');
                    $('body').css({height:'100%'});
                    $('#overlay')
                    .css({
                        display: 'none',
                        position: 'absolute',
                        top:0,
                        left: 0,
                        width: '100%',
                        height: '100%',
                        zIndex: 1000,
                        background: '#fff url(<?php bloginfo('template_url'); ?>/images/ajax.gif) no-repeat center'
                    })
                    .fadeIn(500,function(){
                        $.get( obj.href+'&js',function(data){
                            $('#stylesheet').attr('href','<?php bloginfo('template_url'); ?>/css/style-'+data+'.css');

                                $('#overlay').fadeOut(1500,function(){
                                    $(this).remove();
                                });

                        });
                    });
                }

            }})(this.jQuery);
            (function($){
                $(document).ready(function(){
                  $('#style-switcher a').styleSwitcher();
                  $('#style-switcher').hover(function(){
                      $(this).animate({
                          left : '0'
                      });
                  },
                  function(){
                      $(this).animate({
                          left : '-100'
                      });
                  }
              );


                });
            })(this.jQuery);