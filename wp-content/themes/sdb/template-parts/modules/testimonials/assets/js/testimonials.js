(function ($) {
    var initializeBlock = function ($block) {
        $block.find('.testimonials--carousel .testimonials__wrap').slick({
            appendDots: $('.testimonials--carousel .testimonials__wrap'),
            arrows: false,
            autoplay: true,
            autoplaySpeed: 5000,
            centerMode: false,
            dots: true,
            draggable: true,
            infinite: true,
            rows: 0,
            slide: '.testimonial',
            slidesToShow: 1,
            slidesToScroll: 1,
        });
    };

    // Initialize each block on page load (front end).
    $(document).ready(function () {
        $('.testimonials--carousel').each(function () {
            initializeBlock($(this));
        });
    });

    // Initialize dynamic block preview (editor).
    if (window.acf) {
        window.acf.addAction(
            'render_block_preview/type=testimonials',
            initializeBlock
        );
    }
})(jQuery);
