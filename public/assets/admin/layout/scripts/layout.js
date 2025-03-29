/**
Core script to handle the entire theme and core functions
**/
var Layout = function() {

    var layoutImgPath = 'layouts/layout4/img/';

    var layoutCssPath = 'layouts/layout4/css/';

    var resBreakpointMd = App.getResponsiveBreakpoint('md');

    // Handles header
    var handleHeader = function () {
        // handle search box expand/collapse
        $('.page-header').on('click', '.search-form', function (e) {
            $(this).addClass("open");
            $(this).find('.form-control').focus();

            $('.page-header .search-form .form-control').on('blur', function (e) {
                $(this).closest('.search-form').removeClass("open");
                $(this).unbind("blur");
            });
        });

        // handle hor menu search form on enter press
        $('.page-header').on('keypress', '.hor-menu .search-form .form-control', function (e) {
            if (e.which == 13) {
                $(this).closest('.search-form').submit();
                return false;
            }
        });

        // handle header search button click
        $('.page-header').on('mousedown', '.search-form.open .submit', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).closest('.search-form').submit();
        });

        // handle scrolling to top on responsive menu toggler click when header is fixed for mobile view
        $('body').on('click', '.page-header-top-fixed .page-header-top .menu-toggler', function(){
            App.scrollTop();
        });

        $(".menu-toggler").on('click', function(e) {
            e.preventDefault();
            $(".page-header-menu").css("display", "block");
            $('body').toggleClass('page-quick-sidebar-open');
        });

        $("body").on("click", ".page-content", function () {
            $('body').removeClass('page-quick-sidebar-open');
        });
    };

    // Handles main menu
    var handleMainMenu = function () {

        // handle menu toggler icon click
        $(".page-header .menu-toggler").on("click", function(event) {
            if (App.getViewPort().width < resBreakpointMd) {
                var menu = $(".page-header .page-header-menu");

                if ($('body').hasClass('page-header-top-fixed')) {
                    App.scrollTop();
                }
            }
        });

        // handle sub dropdown menu click for mobile devices only
        $(".hor-menu .menu-dropdown > a, .hor-menu .dropdown-submenu > a").on("click", function(e) {
            if (App.getViewPort().width < resBreakpointMd) {
                if ($(this).next().hasClass('dropdown-menu')) {
                    e.stopPropagation();
                    if ($(this).parent().hasClass("opened")) {
                        $(this).parent().removeClass("opened");
                    } else {
                        $(this).parent().addClass("opened");
                    }
                }
            }
        });

        // handle hover dropdown menu for desktop devices only
        if (App.getViewPort().width >= resBreakpointMd) {
            $('.hor-menu [data-hover="megamenu-dropdown"]').not('.hover-initialized').each(function() {
                $(this).dropdownHover();
                $(this).addClass('hover-initialized');
            });
        }

        // handle auto scroll to selected sub menu node on mobile devices
        $(document).on('click', '.hor-menu .menu-dropdown > a[data-hover="megamenu-dropdown"]', function() {
            if (App.getViewPort().width < resBreakpointMd) {
                App.scrollTo($(this));
            }
        });

        // close main menu on final link click for mobile mode
        $(".hor-menu li > a").on("click", function(e) {
            if (App.getViewPort().width < resBreakpointMd) {
                if (!$(this).parent('li').hasClass('classic-menu-dropdown') && !$(this).parent('li').hasClass('mega-menu-dropdown')
                    && !$(this).parent('li').hasClass('dropdown-submenu')) {
                    $('body').removeClass('page-quick-sidebar-open');
                    App.scrollTop();
                }
            }
        });

        // hold mega menu content open on click/tap.
        $(document).on('click', '.mega-menu-dropdown .dropdown-menu, .classic-menu-dropdown .dropdown-menu', function (e) {
            e.stopPropagation();
        });

        // handle fixed mega menu(minimized)
        $(window).scroll(function() {
            var offset = 75;
            if ($('body').hasClass('page-header-menu-fixed')) {
                if ($(window).scrollTop() > offset){
                    $(".page-header-menu").addClass("fixed");
                } else {
                    $(".page-header-menu").removeClass("fixed");
                }
            }

            if ($('body').hasClass('page-header-top-fixed')) {
                if ($(window).scrollTop() > offset){
                    $(".page-header-top").addClass("fixed");
                } else {
                    $(".page-header-top").removeClass("fixed");
                }
            }
        });
    };

    // Handle sidebar menu links
    var handleMainMenuActiveLink = function(mode, el) {
        var url = location.hash.toLowerCase();

        var menu = $('.hor-menu');

        if (mode === 'click' || mode === 'set') {
            el = $(el);
        } else if (mode === 'match') {
            menu.find("li > a").each(function() {
                var path = $(this).attr("href").toLowerCase();
                // url match condition
                if (path.length > 1 && url.substr(1, path.length - 1) == path.substr(1)) {
                    el = $(this);
                    return;
                }
            });
        }

        if (!el || el.size() == 0) {
            return;
        }

        if (el.attr('href').toLowerCase() === 'javascript:;' || el.attr('href').toLowerCase() === '#') {
            return;
        }

        // disable active states
        menu.find('li.active').removeClass('active');
        menu.find('li > a > .selected').remove();
        menu.find('li.open').removeClass('open');

        el.parents('li').each(function () {
            $(this).addClass('active');

            if ($(this).parent('ul.navbar-nav').size() === 1) {
                $(this).find('> a').append('<span class="selected"></span>');
            }
        });
    };

    // Handles main menu on window resize
    var handleMainMenuOnResize = function() {
        // handle hover dropdown menu for desktop devices only
        var width = App.getViewPort().width;
        var menu = $(".page-header-menu");

        if (width >= resBreakpointMd && menu.data('breakpoint') !== 'desktop') {
            // reset active states
            $('.hor-menu [data-toggle="dropdown"].active').removeClass('open');

            menu.data('breakpoint', 'desktop');
            $('.hor-menu [data-hover="megamenu-dropdown"]').not('.hover-initialized').each(function() {
                $(this).dropdownHover();
                $(this).addClass('hover-initialized');
            });
            $('.hor-menu .navbar-nav li.open').removeClass('open');
            //$(".page-header-menu").css("display", "block");
        } else if (width < resBreakpointMd && menu.data('breakpoint') !== 'mobile') {
            // set active states as open
            $('.hor-menu [data-toggle="dropdown"].active').addClass('open');

            menu.data('breakpoint', 'mobile');
            // disable hover bootstrap dropdowns plugin
            $('.hor-menu [data-hover="megamenu-dropdown"].hover-initialized').each(function() {
                $(this).unbind('hover');
                $(this).parent().unbind('hover').find('.dropdown-submenu').each(function() {
                    $(this).unbind('hover');
                });
                $(this).removeClass('hover-initialized');
            });
            //$(".page-header-menu").css("display", "none");
        } else if (width < resBreakpointMd) {
            //$(".page-header-menu").css("display", "none");
        }
    };

    ////* BEGIN:CORE HANDLERS *//
    //// this function handles responsive layout on screen size resize or mobile device rotate.
    //
    //// Set proper height for sidebar and content. The content and sidebar height must be synced always.
    //var handleSidebarAndContentHeight = function () {
    //
    //    var content = $('.page-content');
    //    var sidebar = $('.page-sidebar');
    //    var body = $('body');
    //    var height;
    //
    //    if (body.hasClass("page-footer-fixed") === true && body.hasClass("page-sidebar-fixed") === false) {
    //        var available_height = App.getViewPort().height - $('.page-footer').outerHeight(true) - $('.page-header').outerHeight(true);
    //        if (content.height() < available_height) {
    //            content.attr('style', 'min-height:' + available_height + 'px');
    //        }
    //    } else {
    //        if (body.hasClass('page-sidebar-fixed')) {
    //            height = _calculateFixedSidebarViewportHeight()  - 10;
    //            if (body.hasClass('page-footer-fixed') === false) {
    //                height = height - $('.page-footer').outerHeight(true);
    //            }
    //        } else {
    //            var headerHeight = $('.page-header').outerHeight(true);
    //            var footerHeight = $('.page-footer').outerHeight(true);
    //
    //            if (App.getViewPort().width < resBreakpointMd) {
    //                height = App.getViewPort().height - headerHeight - footerHeight;
    //            } else {
    //                height = sidebar.height() - 10;
    //            }
    //
    //            if ((height + headerHeight + footerHeight) <= App.getViewPort().height) {
    //                height = App.getViewPort().height - headerHeight - footerHeight - 45;
    //            }
    //        }
    //        content.attr('style', 'min-height:' + height + 'px');
    //    }
    //};
    //
    //// Handle sidebar menu links
    //var handleSidebarMenuActiveLink = function(mode, el) {
    //    var url = location.hash.toLowerCase();
    //
    //    var menu = $('.page-sidebar-menu');
    //
    //    if (mode === 'click' || mode === 'set') {
    //        el = $(el);
    //    } else if (mode === 'match') {
    //        menu.find("li > a").each(function() {
    //            var path = $(this).attr("href").toLowerCase();
    //            // url match condition
    //            if (path.length > 1 && url.substr(1, path.length - 1) == path.substr(1)) {
    //                el = $(this);
    //                return;
    //            }
    //        });
    //    }
    //
    //    if (!el || el.size() == 0) {
    //        return;
    //    }
    //
    //    if (el.attr('href').toLowerCase() === 'javascript:;' || el.attr('href').toLowerCase() === '#') {
    //        return;
    //    }
    //
    //    var slideSpeed = parseInt(menu.data("slide-speed"));
    //    var keepExpand = menu.data("keep-expanded");
    //
    //    // disable active states
    //    menu.find('li.active').removeClass('active');
    //    menu.find('li > a > .selected').remove();
    //
    //    if (menu.hasClass('page-sidebar-menu-hover-submenu') === false) {
    //        menu.find('li.open').each(function(){
    //            if ($(this).children('.sub-menu').size() === 0) {
    //                $(this).removeClass('open');
    //                $(this).find('> a > .arrow.open').removeClass('open');
    //            }
    //        });
    //    } else {
    //         menu.find('li.open').removeClass('open');
    //    }
    //
    //    el.parents('li').each(function () {
    //        $(this).addClass('active');
    //        $(this).find('> a > span.arrow').addClass('open');
    //
    //        if ($(this).parent('ul.page-sidebar-menu').size() === 1) {
    //            $(this).find('> a').append('<span class="selected"></span>');
    //        }
    //
    //        if ($(this).children('ul.sub-menu').size() === 1) {
    //            $(this).addClass('open');
    //        }
    //    });
    //
    //    if (mode === 'click') {
    //        if (App.getViewPort().width < resBreakpointMd && $('.page-sidebar').hasClass("in")) { // close the menu on mobile view while laoding a page
    //            $('.page-header .responsive-toggler').click();
    //        }
    //    }
    //};
    //
    //// Handle sidebar menu
    //var handleSidebarMenu = function() {
    //    $('.page-sidebar').on('click', 'li > a', function(e) {
    //
    //        if (App.getViewPort().width >= resBreakpointMd && $(this).parents('.page-sidebar-menu-hover-submenu').size() === 1) { // exit of hover sidebar menu
    //            return;
    //        }
    //
    //        if ($(this).next().hasClass('sub-menu') === false) {
    //            if (App.getViewPort().width < resBreakpointMd && $('.page-sidebar').hasClass("in")) { // close the menu on mobile view while laoding a page
    //                $('.page-header .responsive-toggler').click();
    //            }
    //            return;
    //        }
    //
    //        if ($(this).next().hasClass('sub-menu always-open')) {
    //            return;
    //        }
    //
    //        var parent = $(this).parent().parent();
    //        var the = $(this);
    //        var menu = $('.page-sidebar-menu');
    //        var sub = $(this).next();
    //
    //        var autoScroll = menu.data("auto-scroll");
    //        var slideSpeed = parseInt(menu.data("slide-speed"));
    //        var keepExpand = menu.data("keep-expanded");
    //
    //        if (keepExpand !== true) {
    //            parent.children('li.open').children('a').children('.arrow').removeClass('open');
    //            parent.children('li.open').children('.sub-menu:not(.always-open)').slideUp(slideSpeed);
    //            parent.children('li.open').removeClass('open');
    //        }
    //
    //        var slideOffeset = -200;
    //
    //        if (sub.is(":visible")) {
    //            $('.arrow', $(this)).removeClass("open");
    //            $(this).parent().removeClass("open");
    //            sub.slideUp(slideSpeed, function() {
    //                if (autoScroll === true && $('body').hasClass('page-sidebar-closed') === false) {
    //                    if ($('body').hasClass('page-sidebar-fixed')) {
    //                        menu.slimScroll({
    //                            'scrollTo': (the.position()).top
    //                        });
    //                    } else {
    //                        App.scrollTo(the, slideOffeset);
    //                    }
    //                }
    //                handleSidebarAndContentHeight();
    //            });
    //        } else {
    //            $('.arrow', $(this)).addClass("open");
    //            $(this).parent().addClass("open");
    //            sub.slideDown(slideSpeed, function() {
    //                if (autoScroll === true && $('body').hasClass('page-sidebar-closed') === false) {
    //                    if ($('body').hasClass('page-sidebar-fixed')) {
    //                        menu.slimScroll({
    //                            'scrollTo': (the.position()).top
    //                        });
    //                    } else {
    //                        App.scrollTo(the, slideOffeset);
    //                    }
    //                }
    //                handleSidebarAndContentHeight();
    //            });
    //        }
    //
    //        e.preventDefault();
    //    });
    //
    //    // handle menu close for angularjs version
    //    if (App.isAngularJsApp()) {
    //        $(".page-sidebar-menu li > a").on("click", function(e) {
    //            if (App.getViewPort().width < resBreakpointMd && $(this).next().hasClass('sub-menu') === false) {
    //                $('.page-header .responsive-toggler').click();
    //            }
    //        });
    //    }
    //
    //    // handle ajax links within sidebar menu
    //    $('.page-sidebar').on('click', ' li > a.ajaxify', function(e) {
    //        e.preventDefault();
    //        App.scrollTop();
    //
    //        var url = $(this).attr("href");
    //        var menuContainer = $('.page-sidebar ul');
    //        var pageContent = $('.page-content');
    //        var pageContentBody = $('.page-content .page-content-body');
    //
    //        menuContainer.children('li.active').removeClass('active');
    //        menuContainer.children('arrow.open').removeClass('open');
    //
    //        $(this).parents('li').each(function() {
    //            $(this).addClass('active');
    //            $(this).children('a > span.arrow').addClass('open');
    //        });
    //        $(this).parents('li').addClass('active');
    //
    //        if (App.getViewPort().width < resBreakpointMd && $('.page-sidebar').hasClass("in")) { // close the menu on mobile view while laoding a page
    //            $('.page-header .responsive-toggler').click();
    //        }
    //
    //        App.startPageLoading();
    //
    //        var the = $(this);
    //
    //        $.ajax({
    //            type: "GET",
    //            cache: false,
    //            url: url,
    //            dataType: "html",
    //            success: function(res) {
    //
    //                if (the.parents('li.open').size() === 0) {
    //                    $('.page-sidebar-menu > li.open > a').click();
    //                }
    //
    //                App.stopPageLoading();
    //                pageContentBody.html(res);
    //                Layout.fixContentHeight(); // fix content height
    //                App.initAjax(); // initialize core stuff
    //            },
    //            error: function(xhr, ajaxOptions, thrownError) {
    //                App.stopPageLoading();
    //                pageContentBody.html('<h4>Could not load the requested content.</h4>');
    //            }
    //        });
    //    });

    // Handles the go to top button at the footer
    var handleGoTop = function() {
        var offset = 300;
        var duration = 500;

        if (navigator.userAgent.match(/iPhone|iPad|iPod/i)) { // ios supported
            $(window).bind("touchend touchcancel touchleave", function (e) {
                if ($(this).scrollTop() > offset) {
                    $('.scroll-to-top').fadeIn(duration);
                } else {
                    $('.scroll-to-top').fadeOut(duration);
                }
            });
        } else { // general 
            $(window).scroll(function () {
                if ($(this).scrollTop() > offset) {
                    $('.scroll-to-top').fadeIn(duration);
                } else {
                    $('.scroll-to-top').fadeOut(duration);
                }
            });
        }

        $('.scroll-to-top').click(function (e) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: 0
            }, duration);
            return false;
        });

    };

    //* END:CORE HANDLERS *//

    return {

        // Main init methods to initialize the layout
        // IMPORTANT!!!: Do not modify the core handlers call order.

        initHeader: function() {
            handleHeader(); // handles horizontal menu
            handleMainMenu(); // handles menu toggle for mobile
            App.addResizeHandler(handleMainMenuOnResize); // handle main menu on window resize

            if (App.isAngularJsApp()) {
                handleMainMenuActiveLink('match'); // init sidebar active links
            }
        },

        initMainMenu: function() {
          handleMainMenu();
        },

        setSidebarMenuActiveLink: function(mode, el) {
            handleSidebarMenuActiveLink(mode, el);
        },

        initSidebar: function() {
            //layout handlers
            handleFixedSidebar(); // handles fixed sidebar menu
            handleSidebarMenu(); // handles main menu
            handleSidebarToggler(); // handles sidebar hide/show

            if (App.isAngularJsApp()) {      
                handleSidebarMenuActiveLink('match'); // init sidebar active links 
            }

            App.addResizeHandler(handleFixedSidebar); // reinitialize fixed sidebar on window resize
        },

        initContent: function() {
            return; 
        },

        initFooter: function() {
            handleGoTop(); //handles scroll to top functionality in the footer
        },

        init: function () {            
            this.initHeader();
            //this.initSidebar();
            this.initContent();
            this.initFooter();
        },

        //public function to fix the sidebar and content height accordingly
        fixContentHeight: function() {
            return;
        },

        initFixedSidebarHoverEffect: function() {
            handleFixedSidebarHoverEffect();
        },

        initFixedSidebar: function() {
            handleFixedSidebar();
        },

        getLayoutImgPath: function() {
            return App.getAssetsPath() + layoutImgPath;
        },

        getLayoutCssPath: function() {
            return App.getAssetsPath() + layoutCssPath;
        }
    };

}();

if (App.isAngularJsApp() === false) {
    jQuery(document).ready(function() {    
       Layout.init(); // init metronic core componets
    });
}