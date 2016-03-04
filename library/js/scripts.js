(function ($) {

    $(function () {
        //fade initial page show
        $('html').animate({
            opacity: 1
        }, 100);

        var winSize = '';
        window.onresize = onWindowResize;
        function onWindowResize() {
            var windowWidth = $(this).width();
            var newWinSize = 'xs'; // default value, check for actual size
            if (windowWidth >= 1200) {
                newWinSize = 'lg';
            } else if (windowWidth >= 992) {
                newWinSize = 'md';
            } else if (windowWidth >= 768) {
                newWinSize = 'sm';
            }
            if (newWinSize !== winSize) {
                winSize = newWinSize;
            }
        }
        onWindowResize();

        //hide navbar on menu click(only on mobiles| xs)
        $('.nav a').on('click', function () {
            if (winSize === 'xs') {
                $('.navbar-toggle').click();
            }
        });

        //add popover to slider gallery
        //requires html
        $('a[data-toggle="popover"]').on("click", function (e) {
            e.preventDefault();
            var img_src = $(this).find('img').attr('src');
            $('#modalimagepreview').attr('src', img_src); // here asign the image to the modal when the user click the enlarge link
            $('#imagemodal').modal('show'); // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
        });

        var $body = $('body');
        //form
        $body.on("input propertychange", ".floating-label-form-group", function (e) {
            $(this).toggleClass("floating-label-form-group-with-value", !!$(e.target).val());
        }).on("focus", ".floating-label-form-group", function () {
            $(this).addClass("floating-label-form-group-with-focus");
        }).on("blur", ".floating-label-form-group", function () {
            $(this).removeClass("floating-label-form-group-with-focus");
        });

        var $main_img = $('#main-img');
        var mainimg = {
            setCenter: function () {
                $body.removeClass('main-img-left');
                $main_img.attr('src', $main_img.data('normal'));
            },
            setLeft: function () {

                $body.addClass('main-img-left');
                $main_img.attr('src', $main_img.data('twist'));
            }
        };

        var waypoint = new Waypoint({
            element: document.getElementById('home'),
            offset: -50,
            handler: function (direction) {
                if ('down' === direction) {
                    mainimg.setLeft();
                    /*                    
                     $body.addClass('main-img-left');
                     $main_img.attr('src', $main_img.data('twist'));
                     * */
                } else {
                    mainimg.setCenter();
                    /*                    
                     $body.removeClass('main-img-left');
                     $main_img.attr('src', $main_img.data('normal'));
                     * */
                }
            }
        });

        $(document).on('mouseleave', function (e) {
            console.log($(window).scrollTop());

            if (e.clientY < 0 && $(window).scrollTop() > 50 ) {
                $body.addClass('mouse-leave-top');

                mainimg.setCenter();
            }

        });
        $(document).on('mouseenter', function (e) {
            if ($(window).scrollTop() > 50) {
                $body.removeClass('mouse-leave-top');
                mainimg.setLeft();

            }

        });

        //jQuery to collapse the navbar on scroll
        $(window).scroll(function () {
            if ($(".navbar").offset().top > 50) {
                $(".navbar-fixed-top").addClass("top-nav-collapse");
            } else {
                $(".navbar-fixed-top").removeClass("top-nav-collapse");
            }
        });

        //jQuery for page scrolling feature - requires jQuery Easing plugin
        $('a.page-scroll').bind('click', function (event) {
            var $anchor = $(this);
            $('html, body').stop().animate({
                scrollTop: $($anchor.attr('href')).offset().top
            }, 1500, 'easeInOutExpo');
            event.preventDefault();
        });

    });
})(jQuery);

/*debug
 function includeCssDebug(e) {
 var evtobj = window.event ? event : e
 if (evtobj.keyCode == 90 && evtobj.ctrlKey) {
 
 var cssId = 'debug-bootstrap';  // you could encode the css path itself to generate id..
 if (!document.getElementById(cssId))
 {
 var head = document.getElementsByTagName('head')[0];
 var link = document.createElement('link');
 link.id = cssId;
 link.rel = 'stylesheet';
 link.type = 'text/css';
 link.href = 'app/bootstrap-responsive-debug.css';
 link.media = 'all';
 head.appendChild(link);
 }
 
 }
 }
 
 document.onkeydown = includeCssDebug;
 * */
