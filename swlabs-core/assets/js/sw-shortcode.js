(function($) {
    "use strict";
    $.swbignews_tab = function() {
        $('.shw-tab-container').each(function() {
            var id = $(this).attr('id');
            var style = $(this).children().attr('class');
            if (style === 'tab-04') {
                $(this).find('.box-tab').wrap('<div class="col-md-4 col-sm-4 tab-panel-left">');
                $(this).find('.tab-content').wrap('<div class="col-md-8 col-sm-8 tab-panel-right">');
            }
            $('.wpb_accordion_section', $(this)).each(function(index) {
                var title = $('.wpb_accordion_header a', $(this)).html();
                $(this).parents(".shw-tab-container").find(".box-tab").append('<div><a class = "tab-title" href="#' + id + index + '" data-toggle="tab">' + title + '</a></div>');
                var content = $(this).find('.wpb_accordion_content').html();

                $(this).parents(".shw-tab-container").find(".tab-content").append('<div id="' + id + index + '" class="tab-pane">' + content + '</div>')
            });
            $(this).find('.wpb_accordion_section').remove();
            $(this).find('.tab-pane').first().addClass('active');
            $(this).find('.box-tab').children().first().addClass('active');
        });

        $('.nav.nav-tabs.box-tab').children().on('click', function(){
            $('.nav.nav-tabs.box-tab').children().each(function() {
                $(this).removeClass('active');
            });
            $(this).addClass('active');
        });
    };
    $.swbignews_video_single = function() {
        $('.video-style-3').owlCarousel({
            margin: 10,
            loop: true,
            lazyLoad: true,
            nav: false,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 2
                },
                600: {
                    items: 3
                },
                768: {
                    items: 4
                }
            }
        });
    };
    $.swbignews_carousel_multi = function() {
        $('.carousel-inner-style').owlCarousel({
            margin: 6,
            loop: true,
            nav: false,
            items: 5,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 2
                },
                480: {
                    items: 2
                },
                568: {
                    items: 3
                },
                600: {
                    items: 3
                },
                768: {
                    items: 4
                },
                1025: {
                    items: 5
                }
            }
        });
    };
    $.swbignews_widget_block_slider = function() {
        var itemNumber = $('.mega-menu .most-poppular-widget').attr('data-item');
        var loop;
        var number_post = $('.mega-menu .most-poppular-widget').attr('data-number-post');
        if (number_post == 1) {
            loop = false;
            itemNumber = 1;
        } else {
            loop = true;
        }
        $('.mega-menu .most-poppular-widget').owlCarousel({
            margin: 30,
            loop: +loop,
            lazyLoad: true,
            autoplayTimeout: 5000,
            smartSpeed: 1200,
            nav: true,
            items: itemNumber,
            navText: ['&#x2039;', '&#x203A;'],
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1
                },
                480: {
                    items: 2
                },
                768: {
                    items: itemNumber
                },
                1024: {
                    items: itemNumber
                }
            }
        });
        $('.shw-widget .most-poppular-widget').owlCarousel({
            margin: 30,
            loop: +loop,
            lazyLoad: true,
            autoplayTimeout: 5000,
            smartSpeed: 1200,
            nav: true,
            items: 1,
            navText: ['&#x2039;', '&#x203A;'],
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1
                },
                480: {
                    items: 2
                },
                768: {
                    items: 2
                },
                1024: {
                    items: 1
                }
            }
        });
    };
    $.swbignews_accordion = function() {
        $('.accordion').each(function() {
            var id = $(this).attr('id');
            var icon = '';
            if (id === 'accordion-01') {
                icon = '<i class="fa fa-caret-down"></i>';
            } else if (id === 'accordion-03') {
                icon = '<i class="icon-arrow"></i>';
            } else if (id === 'accordion-05') {
                icon = '<i class="fa fa-caret-down"></i>';
            }
            var style = id.substr(-2);
            $('.wpb_accordion_section', $(this)).each(function(index) {
                if (style == '02') {
                    icon = '<span class="mrm">' + (index + 1) + '.</span>';
                }
                var element = $(this);
                element.addClass('panel');
                $('h3', element).wrap('<div class="panel-heading"></div>');
                var title = $('h3 a', element).html();
                var content = $('.wpb_accordion_content').html();
                var collapse_in = '';
                var collapsed = ' collapsed';
                if (index == 0) {
                    collapse_in = ' in';
                    collapsed = '';
                }
                $('h3', element).replaceWith('<h5 class="panel-title"><a data-toggle="collapse" data-parent="#' + id + '" href="#' + id + '-' + index + '" class="accordion-toggle  ' + collapsed + '">' + icon + title + '</a></h5>');
                $('.wpb_accordion_content', element).replaceWith('<div id="' + id + '-' + index + '" class="panel-collapse collapse ' + collapse_in + '"><div class="panel-body">' + content + '</div></div>');
            });
        });
    };

    $.swbignews_video_list = function() {
        $('.top-video').find('.carousel-inner').find('.item:first').addClass('active');
    };
    $.swbignews_equalHeightvideo = function() {
        var xh = $('.video-col.left').height();
        $('.video-col.right').css('height', (xh - 55));
    };
    // Custom scroll bar
    $.swbignews_scrollBarCustom = function() {
        $(".video-style-1, .scrollbar").mCustomScrollbar({
            theme: "dark"
        });
    };

    $.swbignews_block_carousel = function() {
        //1 column
        $('.carousel-1g-items').owlCarousel({
            margin: 30,
            loop: true,
            lazyLoad: true,
            smartSpeed: 1000,
            nav: false,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1
                },
                1024: {
                    items: 1
                }
            }
        });

        //1 column
        $('.carousel-1a-items').owlCarousel({
            margin: 10,
            loop: true,
            lazyLoad: true,
            smartSpeed: 1000,
            nav: false,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1
                },
                1024: {
                    items: 1
                }
            }
        });
        //3 column
        $('.carousel-3-items').owlCarousel({
            margin: 5,
            loop: true,
            lazyLoad: true,
            nav: false,
            autoplay: true,
            autoplayTimeout: 5000,
            smartSpeed: 1200,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 2
                },
                768: {
                    items: 3
                },
                1024: {
                    items: 3
                }
            }
        });
        //4 column 
        $('.carousel-4-items').owlCarousel({
            margin: 5,
            loop: true,
            lazyLoad: true,
            nav: false,
            autoplay: true,
            autoplayTimeout: 5000,
            smartSpeed: 1200,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 2
                },
                768: {
                    items: 3
                },
                1024: {
                    items: 4
                }
            }
        });
        //2 column
        $('.carousel-2-items').owlCarousel({
            margin: 5,
            loop: true,
            lazyLoad: true,
            smartSpeed: 1000,
            nav: false,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 2
                },
                1024: {
                    items: 2
                }
            }
        });
    };
    //block slider
    $.swbignews_block_slider = function() {
        $('.background-cover').owlCarousel({
            center: true,
            loop: true,
            mouseDrag: false,
            touchDrag: false,
            dots: false,
            nav: true,
            navText: ['&#x2039;', '&#x203A;'],
            autoplay: true,
            autoplayTimeout: 5000,
            smartSpeed: 1200,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1
                }
            }
        });
        //button click
        $('.control-slide-banner .btn-slide-prev').click(function() {
            $('.background-cover .owl-prev').click();
        });
        $('.control-slide-banner .btn-slide-next').click(function() {
            $('.background-cover .owl-next').click();
        });
    };

    $.swbignews_block_slider_2 = function() {
        $('.carousel-style-7').owlCarousel({
            margin: 30,
            loop: true,
            lazyLoad: true,
            nav: true,
            autoplay: true,
            autoplayTimeout: 5000,
            smartSpeed: 1200,
            navText: ['&#x2039;', '&#x203A;'],
            responsiveClass: true,
            responsive: {
                0: {
                    items: 2
                },
                768: {
                    items: 3
                },
                1024: {
                    items: 4
                }
            }
        });
    };

    $.swbignews_block_slider_3 = function() {
        $('.carousel-style-6').owlCarousel({
            margin: 0,
            loop: true,
            nav: true,
            navText: ['&#x2039;', '&#x203A;'],
            autoplay: true,
            autoplayHoverPause: true,
            autoplayTimeout: 5000,
            smartSpeed: 1200,
            items: 1,
        });
        $('.sub-carousel-style-6 .media-1').owlCarousel({
            loop: true,
            mouseDrag: false,
            touchDrag: false,
            autoplayHoverPause: true,
            animateIn: 'slideInUp',
            animateOut: 'slideOutUp',
            margin: 0,
            nav: false,
            autoplay: false,
            items: 1,
            URLhashListener: true,
            startPosition: '1'
        });
        $('.sub-carousel-style-6 .media-2').owlCarousel({
            loop: true,
            mouseDrag: false,
            touchDrag: false,
            autoplayHoverPause: true,
            animateIn: 'slideInUp',
            animateOut: 'slideOutUp',
            margin: 0,
            nav: false,
            autoplay: false,
            items: 1,
            URLhashListener: true,
            startPosition: '2'
        });
        //set active for news list
        $('.carousel-style-6').on("translate.owl.carousel", function(event) {
            var current = event.item.index;
            $('.sub-carousel-style-6 .media-1').trigger('to.owl.carousel', [current - 1, 300, true]);
            $('.sub-carousel-style-6 .media-2').trigger('to.owl.carousel', [current, 300, true]);
        });
    };

    $.swbignews_click_btn_carousel = function() {
        $('.btn-slider-left').click(function() {
            $(this).parents('.carousel-section').find('.owl-prev').click();
        });
        $('.btn-slider-right').click(function() {
            $(this).parents('.carousel-section').find('.owl-next').click();
        });
    };

    $.swbignews_block_slider_4 = function() {
        //add active class
        $('.carousel-style-5').find('.carousel-inner').children().first().addClass('active');
        var sync2 = $('.sub-carousel-style-5');
        sync2.owlCarousel({
            margin: 5,
            loop: true,
            autoplay: true,
            autoplayTimeout: 5000,
            smartSpeed: 800,
            autoHeight:true,
            nav: true,
            navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right" ></i>'],
            responsiveClass: true,
            responsive: {
                0: {
                    items: 2
                },
                600: {
                    items: 2
                },
                768: {
                    items: 3
                },
                1024: {
                    items: 4
                }
            },
            afterInit: function(el) {
                el.find(".owl-item").eq(0).addClass("synced");
            }
        });
    };

    $.swbignews_block_slider_5 = function() {
        $('.carousel-style-4').owlCarousel({
            margin: 10,
            loop: true,
            lazyLoad: true,
            nav: false,
            autoplay: true,
            autoplayTimeout: 5000,
            smartSpeed: 1200,
            items: 1
        });
    };

    $.swbignews_block_slider_6 = function() {
        var owl_8 = $('.carousel-style-8 .main-slide');
        owl_8.owlCarousel({
            loop: true,
            margin: 0,
            nav: true,
            dots: true,
            animateIn: 'fadeIn',
            animateOut: 'fadeOut',
            autoplay: true,
            autoplayTimeout: 6000,
            autoplaySpeed: 1000,
            smartSpeed: 1000,
            navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right" ></i>'],
            items: 1,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 1
                }
            }
        });
        //set active for news list
        owl_8.on("changed.owl.carousel", function(event) {
            var current = event.item.index;
            var datasrc = $(event.target).find('.owl-item').eq(current).find('.item').attr('data-item');
            $('.carousel-style-8 .slide-items li').removeClass('active');
            $('.carousel-style-8 .slide-items li.' + datasrc).addClass('active');
        });
        //set active when click item
        $('.carousel-style-8 .slide-items li').each(function(index) {
            $(this).click(function(event) {
                var xlenght = $('.carousel-style-8 .owl-dots .owl-dot').length;
                var key = $(this).index();
                $('.carousel-style-8 .owl-dots .owl-dot').eq(key).click();
            });
        });
        //add class active
        $('.carousel-style-8').find('.slide-items').children().first().addClass('active');
        //equal_height
        var xh = $('.carousel-style-8 .left').height();
        $(".carousel-style-8 .right").css('height', xh);
        //scrollBar
        $(".carousel-style-8 .right").mCustomScrollbar({
            theme: "dark",
            scrollbarPosition: "outside",
        });
    };

    $.swbignews_block_slider_7 = function() {
        var container = $('.most-poppular-widget');
        var item = container.attr('data-item');
        var item_loop = false;
        if (item != undefined && parseInt(item) > 1) {
            item_loop = true;
        }
        $('.most-poppular-widget').owlCarousel({
            autoplay: true,
            margin: 30,
            loop: item_loop,
            lazyLoad: true,
            autoplayTimeout: 5000,
            smartSpeed: 1200,
            nav: true,
            navText: ['&#x2039;', '&#x203A;'],
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 1
                }
            }
        });
    };
    $.swbignews_pagination_with_ajax = function() {
        $('.shw-shortcode ul.pagination_with_ajax li a').unbind("click");
        $('.shw-shortcode ul.pagination_with_ajax li a').on('click', function(e) {
            e.preventDefault();
            var $this = $(this);
            var page = $(this).attr('href');
            $this.closest('.shw-shortcode').append('<div class="mask"></div>');
            $this.closest('.shw-shortcode').find('.mask').fadeIn();
            var block_atts = jQuery.parseJSON($(this).closest('.pagination-box').find('input.block_atts').val());
            var data = {
                "page": page,
                "atts": block_atts,
                "block": block_atts['layout']
            }  
            $.fn.Form.ajax(['shortcode.Shortcode_Controller', 'ajax_get_more_news'], [data], function(res) {
                $this.closest('.shw-shortcode').find('.mask').fadeOut();
                $this.closest('.shw-shortcode').replaceWith(res);
                $.swbignews_pagination_with_ajax();
                $.swbignews_pagination_with_category();
                $('.' +block_atts['block-class']  + ' .first_video .carousel-inner > .item:first-child').addClass('active');
            });
        });
    };
    $.swbignews_pagination_with_load_more = function() {
        $('.shw-shortcode .pagination_with_load_more').unbind("click");
        $('.shw-shortcode .pagination_with_load_more').on('click', function(e) {
            e.preventDefault();
            var $this = $(this);
            $this.closest('.shw-shortcode').append('<div class="mask"></div>');
            $this.closest('.shw-shortcode').find('.mask').fadeIn();
            var block_atts = jQuery.parseJSON($(this).parent().find('input.block_atts').val());
            var block = block_atts['layout'];
            var data = {
                "atts": block_atts,
                "block": block
            }
            $.fn.Form.ajax(['shortcode.Shortcode_Controller', 'ajax_get_more_news'], [data], function(res) {
                $this.closest('.shw-shortcode').find('.mask').fadeOut();
                $this.closest('.shw-shortcode').replaceWith(res);
                $.swbignews_pagination_with_load_more();
                $.swbignews_pagination_with_category();
            });
        });
    };
    $.swbignews_pagination_with_category = function() {
        $('.shw-shortcode ul.block_category_tabs li a').unbind("click");
        $('.shw-shortcode ul.block_category_tabs li a').on('click', function(e) {
            e.preventDefault();
            var $this = $(this);
            if ($this.attr('href') == "#") return;
            $this.closest('.shw-shortcode').append('<div class="mask"></div>');
            $this.closest('.shw-shortcode').find('.mask').fadeIn();
            var block_atts = jQuery.parseJSON($this.closest('.shw-shortcode .section-name').find('input.cat_block_atts').val());
            var block = block_atts['layout'].substring(block_atts['layout'].length - 2);
            var all_tab;
            if ($this.html() == 'All') all_tab = 1;
            var data = {
                "atts": block_atts,
                "block": block,
                "cat": $this.attr('href'),
                "all_tab": all_tab
            };
            // var current_page = $this.closest('.shw-shortcode').find('.pagination li.active a').html();
            // if (current_page) {
            //     data["page"] = current_page;
            // }
            data["page"] = 1;
            $.fn.Form.ajax(['shortcode.Shortcode_Controller', 'ajax_get_post_by_category'], [data], function(res) {
                $this.closest('.shw-shortcode').find('.mask').fadeOut();
                $this.closest('.shw-shortcode').replaceWith(res);
                $.swbignews_pagination_with_category();
                $.swbignews_pagination_with_load_more();
                $.swbignews_pagination_with_ajax();
                $.swbignews_responsive_tab();
            });
        });
    };
    $.swbignews_survey = function() {
        $('.shortcode-survey .answer-survey .form-actions input[type="submit"]').val("Vote");
        $('.survey-widget .answer-survey .form-actions input[type="submit"]').val("Vote");
    };
    $.swbignews_news_marsory = function() {
        var $grid = $('.news-masonry .section-content');
        $grid.isotope({
            itemSelector: '.block-item',
            layoutMode: 'masonry',
            percentPosition: true,
            masonry: {
                columnWidth: '.item-width-1'
            }

        });
    };
    $.swbignews_responsive_tab = function() {
        $(".droptabs").droptabs({});
        $(".droptabs").each(function() {
            var parent = $(this).parent();
            if ($(this).find("ul li.active").html()) {
                parent.find('li a.dropdown-toggle').html($(this).find("ul li.active a").html() + '...<span class="caret"></span>');
            }
        });
    };

    $.swbignews_grid_5_load_more_ajax = function() {
        $('.latest-articles-list-grid ul.pagination li a').unbind('click');
        $('.latest-articles-list-grid ul.pagination li a').on('click', function(e) {
            e.preventDefault(); 
            var block = $(this).parent().parent().parent().parent().data('block');
            var active = '0';
            $('.' + block + ' .section-name .pull-right ul li').each(function(e) {
                if ($(this).hasClass('active')) {
                    active = e;
                }
            });
            var tab = $(this).parent().parent().parent().parent(),
                $this = $(this),
                paged = $this.attr('href'),
                paged = paged.replace('?page=', ''),
                data = {
                    "tab": tab.data('grid'),
                    "paged": paged,
                    "active": active
                };
            $('div#tab-content-of-' + block).append('<div class="mask"></div>').find('.mask').fadeIn();
            $.fn.Form.ajax(['shortcode.Shortcode_Controller', 'ajax_get_load_grid_5'], [data], function(res) {
                $('div#tab-content-of-' + block).html(res);
                $.swbignews_grid_5_load_more_ajax();
            });
            return false;
        });
    };
    $.swbignews_carousel_3_ajax = function() {
        $('.ajax_load_carousel_3post').unbind('click');
        $('.ajax_load_carousel_3post').on('click', function(e) {
            e.preventDefault();
            var $this = $(this),
                cate = $this.data('cate'),
                id = $this.data('id'),
                block = $('#' + id).data('block');

            block.category_list = encodeURIComponent('[{"category_slug":"' + cate.slug + '"}]');
            var data = {
                "data": block,
            };
            $('div#location-carousel-' + id + ' > .carousel-inner').html('<div class="waiting"></div>');
            $.fn.Form.ajax(['shortcode.Shortcode_Controller', 'ajax_get_load_post'], [data], function(res) {
                $('div#location-carousel-' + id + ' > .carousel-inner').html(res);
                $('div#location-carousel-' + id + ' .carousel-inner > div:first-child').addClass('active');
                $('#title-block-14-right-' + id).html(cate.cat_name);
                $.swbignews_carousel_3_ajax();
            })
            return false;
        });
    };
    $.swbignews_livescore = function() {
        $('.livescore-table').each(function(e) {
            var indexId = $(this).data('id'),
                block = $(this).find('#carousel-inner-' + indexId).data('block');
            if (typeof block === 'undefined') {
                var $this = $(this),
                    indexId = $this.attr('id'),
                    league = $this.find('.carousel').data('league'),
                    data = {
                        'type': '1',
                        'data': {
                            'leagues_list': league,
                            'type': '1'
                        },
                        'indexId': indexId
                    };
                $this.find('.carousel').attr('id', 'cup-name-carousel-' + indexId);
                $.fn.Form.ajax(['shortcode.Shortcode_Controller', 'ajax_get_load_livescore'], [data], function(res) {
                    $this.find('.carousel-inner').html(res);
                    $this.find('.carousel-inner').find('.item').first().addClass('active');
                });
            } else {
                var data = {
                    'data': block,
                    'indexId': indexId
                };
                $.fn.Form.ajax(['shortcode.Shortcode_Controller', 'ajax_get_load_livescore'], [data], function(res) {
                    $('#carousel-inner-' + indexId).html(res);
                    $('#carousel-inner-' + indexId + " .item:first").addClass('active');
                });
            }
        });
    };
    $.swbignews_slideractive = function() {
        $('.carousel-inner > .item:first-child').addClass('active');
    }
    $.swbignews_slider = function() {
        // js for slider homepage
        $('.slider-for').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: '.slider-nav',
            adaptiveHeight: true
        });
        $('.slider-nav').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            asNavFor: '.slider-for',
            focusOnSelect: true,
            adaptiveHeight: true,
            responsive: [
                {
                  breakpoint: 601,
                  settings: {
                    slidesToShow: 3
                  }
                },
                {
                  breakpoint: 481,
                  settings: {
                    slidesToShow: 2
                  }
                },
                {
                  breakpoint: 415,
                  settings: {
                    slidesToShow: 2
                  }
                }
            ]
        });
    }

    $.slide_banner_sidebar = function() {

        $('.banner-sidebar').owlCarousel({
            autoplay: true,
            margin: 20,
            loop: true,
            autoHeight: true,
            autoplayTimeout: 5000,
            smartSpeed: 1200,
            nav: true,
            navText: ['&#x2039;', '&#x203A;'],
            items: 1
        });
    }
    $.carousel2 = function() {
        $('.carousel-02').owlCarousel({
            loop: true,
            margin: 30,
            smartSpeed: 1200,
            nav: true,
            navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right" ></i>'],
            responsive: {
                0: {
                    items: 2,
                    margin: 15
                },
                480 : {
                    items: 2,
                    margin: 15
                },
                600: {
                    items: 3,
                    margin: 15
                },
                1000: {
                    items: 3
                }
            }
        })
    }
})(jQuery);

jQuery(document).ready(function() {
    jQuery.swbignews_widget_block_slider();
    jQuery.swbignews_accordion();
    jQuery.swbignews_video_list();
    jQuery.swbignews_block_carousel();
    jQuery.swbignews_click_btn_carousel();
    jQuery.swbignews_block_slider();
    jQuery.swbignews_block_slider_2();
    jQuery.swbignews_block_slider_4();
    jQuery.swbignews_block_slider_3();
    jQuery.swbignews_block_slider_5();
    jQuery.swbignews_block_slider_6();
    jQuery.swbignews_block_slider_7();
    jQuery.swbignews_pagination_with_ajax();
    jQuery.swbignews_pagination_with_load_more();
    jQuery.swbignews_pagination_with_category();
    jQuery.swbignews_survey();
    jQuery.swbignews_responsive_tab();
    jQuery.swbignews_tab();
    jQuery.swbignews_equalHeightvideo();
    jQuery.swbignews_scrollBarCustom();
    jQuery.swbignews_video_single();
    jQuery.swbignews_carousel_3_ajax();
    jQuery.swbignews_grid_5_load_more_ajax();
    jQuery.swbignews_livescore();
    jQuery.swbignews_slideractive();
    jQuery.swbignews_slider();
    jQuery.swbignews_carousel_multi();
    jQuery.slide_banner_sidebar();
    jQuery.carousel2();
});

jQuery(window).load(function(){
    jQuery.swbignews_news_marsory();

});

jQuery(window).resize(function() {
    jQuery.swbignews_equalHeightvideo();
    jQuery.swbignews_scrollBarCustom();
});

function striptag(content){
    var html = /(<([^>]+)>)/gi;
    for (i=0; i < content.length; i++){
        content[i] = content[i].replace(html, "");
    }

}