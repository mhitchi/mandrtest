/*!----------------------------------------

	Custom JS for Child Theme v20

----------------------------------------*/

(function ($) {
    'use strict';
    //var $document = $(document);
    //var $window = $(window);

    /*----------------------------------------
		On Load 
	----------------------------------------*/
    //$window.on('load', function() {
    //});

    /*----------------------------------------
		On Ready
	----------------------------------------*/
    $(document).ready(function () {

        // whole card clicks from single <a> tag
        const cards = Array.from(document.querySelectorAll('.mr-card'));
        if (cards) {
            cards.forEach(function(card){
                var mainLink = card.querySelector('.mr-card-link');
                const clickableElements = Array.from(card.querySelectorAll('a')); //we are using 'a' here for simplicity but ideally you should put a class like 'clickable' on every clickable element inside card(a, button) and use that in query selector

                clickableElements.forEach((ele) =>
                    ele.addEventListener('click', (e) => e.stopPropagation())
                );

                card.addEventListener('click', function(){
                    const noTextSelected = !window.getSelection().toString();

                    if(noTextSelected) {
                        mainLink.click();
                    }
                }); 
            });
        }

        // wrappers for h2 styling
        $(".column h2, .columns__heading").each(function (el) {
            $(this).wrapInner('<span class="inner">');
        });

        // Superfish it
        $('ul.sf-menu').superfish();

        // Magnific - For Video Only
        $('.popup-video').magnificPopup({
            disableOn: 480,
            type: 'iframe',
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: false,
            fixedContentPos: false,
            iframe: {
                patterns: {
                    youtube: {
                        src:
                            '//www.youtube.com/embed/%id%?autoplay=1&modestbranding=1',
                    },
                },
            },
        });

        // Magnific - Images & Galleries
        var groups = {};

        $("a[rel^='magnificMe']").each(function () {
            var id = parseInt($(this).attr('data-group'), 10);

            if (!groups[id]) {
                groups[id] = [];
            }

            groups[id].push(this);
        });

        $.each(groups, function () {
            $(this).magnificPopup({
                type: 'image',
                closeOnContentClick: true,
                closeBtnInside: false,
                gallery: { enabled: true },

                image: {
                    verticalFit: true,
                    titleSrc: function (item) {
                        return (
                            '<a class="image-source-link" href="' +
                            item.src +
                            '" target="_blank">view file</a>'
                        );
                    },
                },
                iframe: {
                    patterns: {
                        youtube: {
                            src:
                                '//www.youtube.com/embed/%id%?autoplay=1&amp;rel=0',
                        },
                    },
                },
            });
        });

        // ---------------------------------------------------------
        // Responsive wrap for Wordpress aligned images
        // ---------------------------------------------------------

        $('img.alignleft').each(function () {
            var $this = $(this);

            if ($this.parent('a').length > 0) {
                $this
                    .parent('a')
                    .wrap('<span class="mobile-center-image"></span>');
            } else {
                $this.wrap('<span class="mobile-center-image"></span>');
            }
        });

        $('img.alignright').each(function () {
            var $this = $(this);

            if ($this.parent('a').length > 0) {
                $this
                    .parent('a')
                    .wrap('<span class="mobile-center-image"></span>');
            } else {
                $this.wrap('<span class="mobile-center-image"></span>');
            }
        });

        // ---------------------------------------------------------
        // Smooth in page scrolling
        // ---------------------------------------------------------
        $("a[href*='#']:not([href='#'])").on('click', function () {
            if (
                location.pathname.replace(/^\//, '') ===
                    this.pathname.replace(/^\//, '') &&
                location.hostname === this.hostname
            ) {
                var target = $(this.hash);
                target = target.length
                    ? target
                    : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    // Scroll
                    $('html,body').animate(
                        {
                            scrollTop: target.offset().top - 100,
                        },
                        1000,
                        function () {
                            // Focus and guarantee focus
                            var $target = $(target);
                            $target.focus();
                            if ($target.is(':focus')) {
                                return false;
                            } else {
                                $target.attr('tabindex', '-1');
                                $target.focus();
                            }
                            // click if a toggle
                            if (
                                $target.is('a.trigger') &&
                                !$target.hasClass('active')
                            ) {
                                $target.click();
                            }
                        }
                    );
                    return false;
                }
            }
        });

        //Load specific tab depending upon the hash in URL
        function hashLoad() {
            // Keep page at top until after load
            $(document).scrollTop(0);

            // Get hash from URL, removing # (compatibility)
            var hashTarget = location.hash.replace('#', '');

            // Find hash id on page (using .find to guarantee we're just searching existing nodes), adding # back for search
            hashTarget = $('body').find('#' + hashTarget);

            $('html,body').animate(
                {
                    scrollTop: hashTarget.offset().top - 100,
                },
                1000,
                function () {
                    // Focus and guarantee focus
                    var $target = $(hashTarget);
                    $target.focus();
                    if ($target.is(':focus')) {
                        //return false;
                    } else {
                        $target.attr('tabindex', '-1');
                        $target.focus();
                    }
                    // click if a toggle
                    if (
                        $target.is('a.trigger') &&
                        !$target.hasClass('active')
                    ) {
                        $target.click();
                    }
                }
            );

            return false;
        }

        // Only load if there is a hash in URL
        if (location.hash !== '') {
            $(window).on('load', hashLoad);
        }
    });
})(jQuery);
