<?php
$section_id = get_sub_field('section_id');
$section_classes = get_sub_field('section_classes');
$pages = get_sub_field('pages'); // repeater
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
<section <?= $id; ?> class="section-wrap pages <?= $section_classes; ?>">
    <div class="pages__container container">
    <?php 
    if( $pages ) :
        ?>
        <ul class="pages__list">
        <?php
        $classes = 'pages__list-item page';
        
        // Determing single column width class
        if( count($pages) === 2 || count($pages) > 3 ) {
            $column = 'one-half';
            $classes .= ' one-half';
        } elseif( count($pages) === 3 ) {
            $column = 'one-third';
            $classes .= ' one-third';
        }

        $cx = 0;
        foreach( $pages as $page ) :
            $cx++;
            $image = $page['page_image']; // image
            $title = $page['page_title']; // text
            $link = $page['page_link']; // link
            $button_text = $page['button_text'];

            $column_class = $classes;

            // Check for first column in row
            if( $column === 'one-half' ) {
                $column_class .= $cx % 2 === 1 ? ' first' : '';
            } elseif( $column === 'one-third' ) {
                $column_class .= $cx % 3 === 1 ? ' first' : '';
            }

            if( !$image ) {
                $column_class .= ' no-image';
            }
            ?>
            <li class="<?= $column_class; ?> card-style mr-card">
                <?php
                if( $display_type === 'List' ) :
                    if( $image ) :
                        ?>
                        <picture class="page__picture">
                            <img src="<?= $image['url']; ?>" alt="<?= $image['alt']; ?>" />
                        </picture>
                        <?php
                    endif;
                    ?>
                    <div class="page__content">
                        <h2 class="page__content__title"><?= $title; ?></h2>
                        <a class="page__content__button button mr-card-link" href="<?= $link; ?>"><?= $button_text; ?></a>
                    </div>
                    <?php
                else :
                    ?>
                    <a class="page__link" href="<?= $link; ?>">
                        <?php 
                        if( $image ) :
                            ?>
                            <picture class="page__picture">
                                <img src="<?= $image['url']; ?>" alt="<?= $image['alt']; ?>" />
                            </picture>
                            <?php
                        endif;
                        ?>
                        <div class="page__content">
                            <h2 class="page__content__title"><?= $link; ?>"><?= $title; ?></h2>
                            <span class="page__content__button button"><?= $button_text; ?></span>
                        </div>
                    </a>
                    <?php
                endif;
                ?>
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