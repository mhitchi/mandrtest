<?php
$section_id = get_sub_field('section_id');
$section_classes = get_sub_field('section_classes');
$pages = get_sub_field('cards'); // repeater
//$display_type = get_sub_field('display_type'); // List, Overlay
$display_type = 'List'; // List, Overlay

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

// Set image column style class
$section_classes .= $display_type === 'List' ? ' pages--list' : ' pages--overlay';
?>
<section <?= $id; ?> class="section-wrap service-cards <?= $section_classes; ?>">
    <div class="service-cards__container container">
    <?php 
    if( $pages ) :
        ?>
        <ul class="service-cards__list">
        <?php
        $classes = 'service-cards__list__item service-card';
        
        // Determing single column width class
        // if( count($pages) === 2 || count($pages) > 3 ) {
            $column = 'one-half';
            $classes .= ' one-half med-one-half';
        // }
        //  elseif( count($pages) === 3 ) {
        //     $column = 'one-third';
        //     $classes .= ' one-third';
        // }

        $cx = 0;
        foreach( $pages as $page ) :
            $cx++;
            $image = $page['card_image']; // image
            $title = $page['card_title']; // text
            $links = $page['links']; // link

            $column_class = $classes;

            // Check for first column in row
            if( $column === 'one-half' ) {
                $column_class .= $cx % 2 === 1 ? ' first med-first' : '';
            } elseif( $column === 'one-third' ) {
                $column_class .= $cx % 3 === 1 ? ' first' : '';
            }

            if( !$image ) {
                $column_class .= ' no-image';
            }
            ?>
            <li class="<?= $column_class; ?> card-style">
                <?php
                if( $image ) :
                    ?>
                    <picture class="service-card__image">
                        <img src="<?= $image['url']; ?>" alt="<?= $image['alt']; ?>" />
                    </picture>
                    <?php
                endif;
                ?>
                <div class="service-card__content">
                    <h3 class="service-card__title"><?= $title; ?></h3>
                    <ul class="basic-list">
                        <?php foreach($links as $link): ?>
                            <li>
                                <a href="<?= $link['page']; ?>">
                                    <span class="inner-text"><?= $link['title']; ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </li>
            <?php
        endforeach; 
        ?>
        </ul>
        <?php
    endif;
    ?>
    </div>
</section>