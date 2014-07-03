(function($){ 
    $(document).ready(function(){
  $("a[rel^='prettyPhoto']").prettyPhoto();
        /*
         * go to top anchor
         */
        $('body').removeClass('no-js').addClass('js');
        $('a#gototop').click(function(){
            $('html, body').animate({
                scrollTop:0
            }, 'slow');
            return false;
        });
        $('.hr').click(function(){
            $('html, body').animate({
                scrollTop:0
            }, 'slow');
            return false;
        });
        
        $('.taglist').jScrollPane({
            //    showArrows :true,
            contentWidth : 8,
            verticalGutter : 0
        });

        /*
         * dropdown menu
         */
        $("#nav .menu li").hover(
            function () {
                $(this).has('ul').addClass("active");
                $(this).find('ul:first').css({
                    visibility: "visible",
                    display: "none"
                }).stop(true, true).slideDown('fast');
            },
            function () {
                $(this).removeClass("active");
                $(this).find('ul:first').css({
                    visibility: "visible",
                    display: "block"
                }).stop(true, true).slideUp('fast');
            }
            );

      

        $($('#nav .menu li')).each( function() {
            if( $(this).find('ul').size() > 0 ){
                $(this).addClass("arrow");
            }
        });
        /*
         * ajax more
         */
      
        $("nav select").change(function() {
            window.location = $(this).find("option:selected").val();
        });
     
        
        $('.multiselect,.chosen').chosen({allow_single_deselect: true});

        /*
         * overlay
         */
     
       
        

        $(" .nav-next, .nav-previous" ).bind('click',function(){
        
            window.location=$(this).find("a").attr("href");
            return false;
        });


        
        $('.purerecipe .instructions ul li,.purerecipe ul.ingredients li').click(function(){
            if($(this).hasClass('active')) {
                $(this).removeClass('active')
            }
            else {
                $(this).addClass('active')
            }
        })

    
        
        /*
             * shortcodes - tabs, accordion
             */

   
      
      

        $('.tabs-content .tab:first').show();
        $('.tabs li:first').addClass('active');
        $.each($('.tabs li'),function(i,el){
            $(el).click(function(){
                $('.tabs-content .tab').slideUp();
                $('.tabs-content .tab').eq(i).slideDown();
                $('.tabs li').removeClass('active');
                $(this).addClass('active');
                return false;
            });
        });


        $("div.accordion div:not(:first)").hide();
        $("div.accordion h4:first").addClass('active');
        $("div.accordion h4").click(function() {
            if ($(this).next().is(":hidden")) {
                $("div.accordion h4").removeClass('active');
                $("div.accordion div:visible").slideUp();
                $(this).next().slideDown();
                $(this).addClass('active');
            }
            return false;
        });

        $(".toggle-container").hide();
        $(".toggle-trigger").click(function(){
            $(this).toggleClass("active").next().slideToggle();
            return false;
        });
        
        
        var $mascontainer = $('#articles');
        winwidth = $(window).width();
        if(winwidth > '976'){
            $mascontainer.imagesLoaded( function(){
                $mascontainer.masonry({
                    itemSelector: '.post',
                    gutterWidth:30,
                    isResizable: false,
                    isAnimated: true
                });
            });
           
        }
        $(window).resize(masonryHandler);
     
        function masonryHandler() {
            winwidth = $(window).width();
      
            if(winwidth < '976'){
                if ($('#articles article:first').css('position') == 'absolute')
                    $('#articles').masonry( 'destroy' )
            } else {
                $mascontainer.imagesLoaded( function(){
                $mascontainer.masonry({
                    itemSelector: '.post',
                    gutterWidth:30,
                    isResizable: false
                });
            });
            }
        }
        
        if(winwidth > '976'){
            $('.fcolumn').setAllToMaxHeight();
        }

            $("li.ingredient.hasdesc a").each(function() {
                var tipSelecter = $(this).parent().find('.tooltip');

                $(this).tooltip({
                    effect: "fade",
                    opacity: 0.9,
                    tip: tipSelecter,
                    position: "bottom right",
                     relative: true
                });
            });
    });


$.fn.setAllToMaxHeight = function(){
return this.height( Math.max.apply(this, $.map( this , function(e){return $(e).height()}) ) );
}

$.fn.imagesLoaded = function(callback){
    var elems = this.find('img'),
    len   = elems.length,
    _this = this;

    elems.bind('load',function(){
        if (--len <= 0){ 
            callback.call( _this ); 
        }
    }).each(function(){
        // cached images don't fire load sometimes, so we reset src.
        if (this.complete || this.complete === undefined){
            var src = this.src;
            // webkit hack from http://groups.google.com/group/jquery-dev/browse_thread/thread/eee6ab7b2da50e1f
            // data uri bypasses webkit log warning (thx doug jones)
            this.src = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";
            this.src = src;
        }  
    }); 

    return this;
};
})(this.jQuery); 


/**
 * jQuery Masonry v2.1.02
 * A dynamic layout plugin for jQuery
 * The flip-side of CSS Floats
 * http://masonry.desandro.com
 *
 * Licensed under the MIT license.
 * Copyright 2011 David DeSandro
 */
(function(a,b,c){
    var d=b.event,e;
    d.special.smartresize={
        setup:function(){
            b(this).bind("resize",d.special.smartresize.handler)
        },
        teardown:function(){
            b(this).unbind("resize",d.special.smartresize.handler)
        },
        handler:function(a,b){
            var c=this,d=arguments;
            a.type="smartresize",e&&clearTimeout(e),e=setTimeout(function(){
                jQuery.event.handle.apply(c,d)
            },b==="execAsap"?0:100)
        }
    },b.fn.smartresize=function(a){
        return a?this.bind("smartresize",a):this.trigger("smartresize",["execAsap"])
    },b.Mason=function(a,c){
        this.element=b(c),this._create(a),this._init()
    },b.Mason.settings={
        isResizable:!0,
        isAnimated:!1,
        animationOptions:{
            queue:!1,
            duration:500
        },
        gutterWidth:0,
        isRTL:!1,
        isFitWidth:!1,
        containerStyle:{
            position:"relative"
        }
    },b.Mason.prototype={
        _filterFindBricks:function(a){
            var b=this.options.itemSelector;
            return b?a.filter(b).add(a.find(b)):a
        },
        _getBricks:function(a){
            var b=this._filterFindBricks(a).css({
                position:"absolute"
            }).addClass("masonry-brick");
            return b
        },
        _create:function(c){
            this.options=b.extend(!0,{},b.Mason.settings,c),this.styleQueue=[];
            var d=this.element[0].style;
            this.originalStyle={
                height:d.height||""
            };
            
            var e=this.options.containerStyle;
            for(var f in e)this.originalStyle[f]=d[f]||"";this.element.css(e),this.horizontalDirection=this.options.isRTL?"right":"left",this.offset={
                x:parseInt(this.element.css("padding-"+this.horizontalDirection),10),
                y:parseInt(this.element.css("padding-top"),10)
            },this.isFluid=this.options.columnWidth&&typeof this.options.columnWidth=="function";
            var g=this;
            setTimeout(function(){
                g.element.addClass("masonry")
            },0),this.options.isResizable&&b(a).bind("smartresize.masonry",function(){
                g.resize()
            }),this.reloadItems()
        },
        _init:function(a){
            this._getColumns(),this._reLayout(a)
        },
        option:function(a,c){
            b.isPlainObject(a)&&(this.options=b.extend(!0,this.options,a))
        },
        layout:function(a,b){
            for(var c=0,d=a.length;c<d;c++)this._placeBrick(a[c]);
            var e={};
        
            e.height=Math.max.apply(Math,this.colYs);
            if(this.options.isFitWidth){
                var f=0,c=this.cols;
                while(--c){
                    if(this.colYs[c]!==0)break;
                    f++
                }
                e.width=(this.cols-f)*this.columnWidth-this.options.gutterWidth
            }
            this.styleQueue.push({
                $el:this.element,
                style:e
            });
            var g=this.isLaidOut?this.options.isAnimated?"animate":"css":"css",h=this.options.animationOptions,i;
            for(c=0,d=this.styleQueue.length;c<d;c++)i=this.styleQueue[c],i.$el[g](i.style,h);
            this.styleQueue=[],b&&b.call(a),this.isLaidOut=!0
        },
        _getColumns:function(){
            var a=this.options.isFitWidth?this.element.parent():this.element,b=a.width();
            this.columnWidth=this.isFluid?this.options.columnWidth(b):this.options.columnWidth||this.$bricks.outerWidth(!0)||b,this.columnWidth+=this.options.gutterWidth,this.cols=Math.floor((b+this.options.gutterWidth)/this.columnWidth),this.cols=Math.max(this.cols,1)
        },
        _placeBrick:function(a){
            var c=b(a),d,e,f,g,h;
            d=Math.ceil(c.outerWidth(!0)/(this.columnWidth+this.options.gutterWidth)),d=Math.min(d,this.cols);
            if(d===1)f=this.colYs;
            else{
                e=this.cols+1-d,f=[];
                for(h=0;h<e;h++)g=this.colYs.slice(h,h+d),f[h]=Math.max.apply(Math,g)
            }
            var i=Math.min.apply(Math,f),j=0;
            for(var k=0,l=f.length;k<l;k++)if(f[k]===i){
                j=k;
                break
            }
            var m={
                top:i+this.offset.y
            };
            
            m[this.horizontalDirection]=this.columnWidth*j+this.offset.x,this.styleQueue.push({
                $el:c,
                style:m
            });
            var n=i+c.outerHeight(!0),o=this.cols+1-l;
            for(k=0;k<o;k++)this.colYs[j+k]=n
        },
        resize:function(){
            var a=this.cols;
            this._getColumns(),(this.isFluid||this.cols!==a)&&this._reLayout()
        },
        _reLayout:function(a){
            var b=this.cols;
            this.colYs=[];
            while(b--)this.colYs.push(0);
            this.layout(this.$bricks,a)
        },
        reloadItems:function(){
            this.$bricks=this._getBricks(this.element.children())
        },
        reload:function(a){
            this.reloadItems(),this._init(a)
        },
        appended:function(a,b,c){
            if(b){
                this._filterFindBricks(a).css({
                    top:this.element.height()
                });
                var d=this;
                setTimeout(function(){
                    d._appended(a,c)
                },1)
            }else this._appended(a,c)
        },
        _appended:function(a,b){
            var c=this._getBricks(a);
            this.$bricks=this.$bricks.add(c),this.layout(c,b)
        },
        remove:function(a){
            this.$bricks=this.$bricks.not(a),a.remove()
        },
        destroy:function(){
            this.$bricks.removeClass("masonry-brick").each(function(){
                this.style.position="",this.style.top="",this.style.left=""
            });
            var c=this.element[0].style;
            for(var d in this.originalStyle)c[d]=this.originalStyle[d];this.element.unbind(".masonry").removeClass("masonry").removeData("masonry"),b(a).unbind(".masonry")
        }
    },b.fn.imagesLoaded=function(a){
        function i(a){
            a.target.src!==f&&b.inArray(this,g)===-1&&(g.push(this),--e<=0&&(setTimeout(h),d.unbind(".imagesLoaded",i)))
        }
        function h(){
            a.call(c,d)
        }
        var c=this,d=c.find("img").add(c.filter("img")),e=d.length,f="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==",g=[];
        e||h(),d.bind("load.imagesLoaded error.imagesLoaded",i).each(function(){
            var a=this.src;
            this.src=f,this.src=a
        });
        return c
    };
    
    var f=function(a){
        this.console&&console.error(a)
    };
    
    b.fn.masonry=function(a){
        if(typeof a=="string"){
            var c=Array.prototype.slice.call(arguments,1);
            this.each(function(){
                var d=b.data(this,"masonry");
                if(!d)f("cannot call methods on masonry prior to initialization; attempted to call method '"+a+"'");
                else{
                    if(!b.isFunction(d[a])||a.charAt(0)==="_"){
                        f("no such method '"+a+"' for masonry instance");
                        return
                    }
                    d[a].apply(d,c)
                }
            })
        }else this.each(function(){
            var c=b.data(this,"masonry");
            c?(c.option(a||{}),c._init()):b.data(this,"masonry",new b.Mason(a,this))
        });
        return this
    }
})(window,jQuery);


/*!
 * jQuery Tools v1.2.7 - The missing UI library for the Web
 *
 * tooltip/tooltip.js
 * tooltip/tooltip.dynamic.js
 * tooltip/tooltip.slide.js
 *
 * NO COPYRIGHTS OR LICENSES. DO WHAT YOU LIKE.
 *
 * http://flowplayer.org/tools/
 *
 */
(function(a){a.tools=a.tools||{version:"v1.2.7"},a.tools.tooltip={conf:{effect:"toggle",fadeOutSpeed:"fast",predelay:0,delay:30,opacity:1,tip:0,fadeIE:!1,position:["top","center"],offset:[0,0],relative:!1,cancelDefault:!0,events:{def:"mouseenter,mouseleave",input:"focus,blur",widget:"focus mouseenter,blur mouseleave",tooltip:"mouseenter,mouseleave"},layout:"<div/>",tipClass:"tooltip"},addEffect:function(a,c,d){b[a]=[c,d]}};var b={toggle:[function(a){var b=this.getConf(),c=this.getTip(),d=b.opacity;d<1&&c.css({opacity:d}),c.show(),a.call()},function(a){this.getTip().hide(),a.call()}],fade:[function(b){var c=this.getConf();!a.browser.msie||c.fadeIE?this.getTip().fadeTo(c.fadeInSpeed,c.opacity,b):(this.getTip().show(),b())},function(b){var c=this.getConf();!a.browser.msie||c.fadeIE?this.getTip().fadeOut(c.fadeOutSpeed,b):(this.getTip().hide(),b())}]};function c(b,c,d){var e=d.relative?b.position().top:b.offset().top,f=d.relative?b.position().left:b.offset().left,g=d.position[0];e-=c.outerHeight()-d.offset[0],f+=b.outerWidth()+d.offset[1],/iPad/i.test(navigator.userAgent)&&(e-=a(window).scrollTop());var h=c.outerHeight()+b.outerHeight();g=="center"&&(e+=h/2),g=="bottom"&&(e+=h),g=d.position[1];var i=c.outerWidth()+b.outerWidth();g=="center"&&(f-=i/2),g=="left"&&(f-=i);return{top:e,left:f}}function d(d,e){var f=this,g=d.add(f),h,i=0,j=0,k=d.attr("title"),l=d.attr("data-tooltip"),m=b[e.effect],n,o=d.is(":input"),p=o&&d.is(":checkbox, :radio, select, :button, :submit"),q=d.attr("type"),r=e.events[q]||e.events[o?p?"widget":"input":"def"];if(!m)throw"Nonexistent effect \""+e.effect+"\"";r=r.split(/,\s*/);if(r.length!=2)throw"Tooltip: bad events configuration for "+q;d.on(r[0],function(a){clearTimeout(i),e.predelay?j=setTimeout(function(){f.show(a)},e.predelay):f.show(a)}).on(r[1],function(a){clearTimeout(j),e.delay?i=setTimeout(function(){f.hide(a)},e.delay):f.hide(a)}),k&&e.cancelDefault&&(d.removeAttr("title"),d.data("title",k)),a.extend(f,{show:function(b){if(!h){l?h=a(l):e.tip?h=a(e.tip).eq(0):k?h=a(e.layout).addClass(e.tipClass).appendTo(document.body).hide().append(k):(h=d.next(),h.length||(h=d.parent().next()));if(!h.length)throw"Cannot find tooltip for "+d}if(f.isShown())return f;h.stop(!0,!0);var o=c(d,h,e);e.tip&&h.html(d.data("title")),b=a.Event(),b.type="onBeforeShow",g.trigger(b,[o]);if(b.isDefaultPrevented())return f;o=c(d,h,e),h.css({position:"absolute",top:o.top,left:o.left}),n=!0,m[0].call(f,function(){b.type="onShow",n="full",g.trigger(b)});var p=e.events.tooltip.split(/,\s*/);h.data("__set")||(h.off(p[0]).on(p[0],function(){clearTimeout(i),clearTimeout(j)}),p[1]&&!d.is("input:not(:checkbox, :radio), textarea")&&h.off(p[1]).on(p[1],function(a){a.relatedTarget!=d[0]&&d.trigger(r[1].split(" ")[0])}),e.tip||h.data("__set",!0));return f},hide:function(c){if(!h||!f.isShown())return f;c=a.Event(),c.type="onBeforeHide",g.trigger(c);if(!c.isDefaultPrevented()){n=!1,b[e.effect][1].call(f,function(){c.type="onHide",g.trigger(c)});return f}},isShown:function(a){return a?n=="full":n},getConf:function(){return e},getTip:function(){return h},getTrigger:function(){return d}}),a.each("onHide,onBeforeShow,onShow,onBeforeHide".split(","),function(b,c){a.isFunction(e[c])&&a(f).on(c,e[c]),f[c]=function(b){b&&a(f).on(c,b);return f}})}a.fn.tooltip=function(b){var c=this.data("tooltip");if(c)return c;b=a.extend(!0,{},a.tools.tooltip.conf,b),typeof b.position=="string"&&(b.position=b.position.split(/,?\s/)),this.each(function(){c=new d(a(this),b),a(this).data("tooltip",c)});return b.api?c:this}})(jQuery);
(function(a){var b=a.tools.tooltip;b.dynamic={conf:{classNames:"top right bottom left"}};function c(b){var c=a(window),d=c.width()+c.scrollLeft(),e=c.height()+c.scrollTop();return[b.offset().top<=c.scrollTop(),d<=b.offset().left+b.width(),e<=b.offset().top+b.height(),c.scrollLeft()>=b.offset().left]}function d(a){var b=a.length;while(b--)if(a[b])return!1;return!0}a.fn.dynamic=function(e){typeof e=="number"&&(e={speed:e}),e=a.extend({},b.dynamic.conf,e);var f=a.extend(!0,{},e),g=e.classNames.split(/\s/),h;this.each(function(){var b=a(this).tooltip().onBeforeShow(function(b,e){var i=this.getTip(),j=this.getConf();h||(h=[j.position[0],j.position[1],j.offset[0],j.offset[1],a.extend({},j)]),a.extend(j,h[4]),j.position=[h[0],h[1]],j.offset=[h[2],h[3]],i.css({visibility:"hidden",position:"absolute",top:e.top,left:e.left}).show();var k=a.extend(!0,{},f),l=c(i);if(!d(l)){l[2]&&(a.extend(j,k.top),j.position[0]="top",i.addClass(g[0])),l[3]&&(a.extend(j,k.right),j.position[1]="right",i.addClass(g[1])),l[0]&&(a.extend(j,k.bottom),j.position[0]="bottom",i.addClass(g[2])),l[1]&&(a.extend(j,k.left),j.position[1]="left",i.addClass(g[3]));if(l[0]||l[2])j.offset[0]*=-1;if(l[1]||l[3])j.offset[1]*=-1}i.css({visibility:"visible"}).hide()});b.onBeforeShow(function(){var a=this.getConf(),b=this.getTip();setTimeout(function(){a.position=[h[0],h[1]],a.offset=[h[2],h[3]]},0)}),b.onHide(function(){var a=this.getTip();a.removeClass(e.classNames)}),ret=b});return e.api?ret:this}})(jQuery);
(function(a){var b=a.tools.tooltip;a.extend(b.conf,{direction:"up",bounce:!1,slideOffset:10,slideInSpeed:200,slideOutSpeed:200,slideFade:!a.browser.msie});var c={up:["-","top"],down:["+","top"],left:["-","left"],right:["+","left"]};b.addEffect("slide",function(a){var b=this.getConf(),d=this.getTip(),e=b.slideFade?{opacity:b.opacity}:{},f=c[b.direction]||c.up;e[f[1]]=f[0]+"="+b.slideOffset,b.slideFade&&d.css({opacity:0}),d.show().animate(e,b.slideInSpeed,a)},function(b){var d=this.getConf(),e=d.slideOffset,f=d.slideFade?{opacity:0}:{},g=c[d.direction]||c.up,h=""+g[0];d.bounce&&(h=h=="+"?"-":"+"),f[g[1]]=h+"="+e,this.getTip().animate(f,d.slideOutSpeed,function(){a(this).hide(),b.call()})})})(jQuery);
