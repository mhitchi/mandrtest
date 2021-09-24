<?php
$section_id = get_sub_field('section_id');
$section_classes = get_sub_field('section_classes');
$testimonials = get_sub_field('testimonials');
$display_type = get_sub_field('display_type'); // List, Carousel
$rand_id = substr(md5(microtime()),rand(0,26),3);

// Can't just print an empty id and have id="", so build printout here instead
$id = !empty($section_id) ? "id=\"{$section_id}\"" : '';

// Apply padding class
$padding = get_sub_field('padding_between_sections');
$padding_top = $padding['section_padding_top'];
$padding_bottom = $padding['section_padding_bottom'];
if( $padding_top && $padding_bottom ) {
    $section_classes .= ' double-padding';
} elseif( $padding_top ) {
    $section_classes .= ' double-padding--top';
} elseif( $padding_bottom ) {
    $section_classes .= ' double-padding--bot';
}

// Determine display type
$section_classes .= $display_type === 'List' ? ' testimonials--list' : ' testimonials--carousel';
?>
<section <?= $id; ?> class="section-wrap testimonials <?= $section_classes; ?>">
    <div class="testimonials__container container">
        <?php 
        if( $testimonials ) : 
            ?>
            <div id="testimonials-<?= $rand_id; ?>" class="testimonials__wrap">
                <?php 
                foreach( $testimonials as $testimonial ) :
                    $image = $testimonial['testimonial_image'];
                    $author = $testimonial['testimonial_author'];
                    $title = $testimonial['testimonial_title'];
                    $content = $testimonial['testimonial_excerpt'];
                    ?>
                    <div class="testimonials__item testimonial">
                        <?php
                        if( $image ) :
                            ?>
                            <figure class="testimonial__figure">
                                <img class="testimonial__image" src="<?= $image['url']; ?>" alt="<?= $image['alt']; ?>">
                            </figure>
                            <?php
                        endif;
                        if( $author ) :
                            ?>
                            <div class="testimonial__author">
                                <h3><?= $author; ?></h3>
                            </div>
                            <?php
                        endif;
                        if( $title ) :
                            ?>
                            <div class="testimonial__title">
                                <h4><?= $title; ?></h4>
                            </div>
                            <?php
                        endif;
                        if( $content ) :
                            ?>
                            <div class="testimonial__content">
                                <p><?= $content; ?></p>
                            </div>
                            <?php
                        endif;
                        ?>
                    </div>
                    <?php 
                endforeach; 
                if( $display_type === 'Carousel' ) :
                    ?>
                    <div class="testimonials__wrap__controls"></div>
                    <?php
                endif;
                ?> 
            </div> 
            <?php
            if( $display_type === 'Carousel' ) :
                ?>
                <script>
                    jQuery(window).load(function() {
                        jQuery(".testimonials--carousel #testimonials-<?= $rand_id; ?>").slick({
                            appendArrows: jQuery('.testimonials--carousel #testimonials-<?= $rand_id; ?> .testimonials__wrap__controls'),
                            appendDots: jQuery('.testimonials--carousel #testimonials-<?= $rand_id; ?> .testimonials__wrap__controls'),
                            arrows: true,
                            autoplay: true,
                            autoplaySpeed: 5000,
                            centerMode: false,
                            dots: true,
                            draggable: true,
                            infinite: true,
                            rows: 0,
                            slide: '.testimonials--carousel #testimonials-<?= $rand_id; ?> .testimonial',
                            slidesToShow: 1,
                            slidesToScroll: 1,
                        });
                    });
                </script>
                <?php
            endif;
        endif;
        ?>
    </div>
</section>	
<?php 