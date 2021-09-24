<?php
$section_id = get_sub_field('section_id');
$section_classes = get_sub_field('section_classes');
$include_padding = get_sub_field('padding_between_sections');
$gallery = get_sub_field('gallery'); // gallery
$display_type = get_sub_field('display_type'); // List, Carousel
$rand_id = substr(md5(microtime()),rand(0,26),3);

// Can't just print an empty id and have id="", so build printout here instead
$id = !empty($section_id) ? "id=\"{$section_id}\"" : '';

// padding class
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
$section_classes .= $display_type === 'List' ? ' gallery--list' : ' gallery--carousel';
?>
<section <?= $id; ?> class="section-wrap gallery <?= $section_classes; ?>">
    <div class="gallery__container container">
        <?php 
        if($section_title): 
            ?>
            <h2 class="gallery__title section-title">
                <?= $section_title; ?>
            </h2>
            <?php 
        endif;
        
        if( $display_type === 'List' ) :
            ?>
            <ul class="gallery__list gallery-columns-4">
            <?php 
            foreach( $gallery as $image ) :
                ?>
                <li class="gallery__list-item">
                    <figure class="gallery__list-item__figure">
                        <a class="gallery__list-item__link" href="<?= $image['url']; ?>" rel="magnificMe" data-group="[<?= $rand_id; ?>]">
                            <img class="gallery__list-item__image" src="<?= $image['sizes']['medium-plus']; ?>" alt="<?= $image['alt']; ?>">
                        </a>
                    </figure>
                </li>
                <?php
            endforeach; 
            ?>
            </ul>
            <?php
        else :
            ?>
            <ul id="gallery-carousel-<?= $rand_id; ?>" class="gallery__list slick-slider">
                <?php 
                foreach( $gallery as $image ) :
                    ?>
                    <li class="gallery__list-item slick-slide">
                        <img class="gallery__list-item__image" src="<?= $image['url']; ?>" alt="<?= $image['alt']; ?>">
                    </li><?php
                endforeach; 
                ?>
            </ul>
            <script>
                jQuery(window).load(function() {
                    jQuery('#gallery-carousel-<?= $rand_id; ?>').slick({
                        autoplay: true,
                        rows: 0,
                        slide: '#gallery-carousel-<?= $rand_id; ?> .gallery__list-item',
                        slidesToShow: 3,
                        speed: 500,
                        autoplaySpeed: 4000,
                    });
                });
            </script>
            <?php
        endif;
        ?>
    </div>
</section>
