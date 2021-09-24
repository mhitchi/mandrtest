<?php
$section_id = get_sub_field('section_id');
$section_classes = get_sub_field('section_classes');
$tabs = get_sub_field('tabs'); // repeater

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

$rand = substr(md5(microtime()),rand(0,26),3);
?>
<section <?= $id; ?> class="section-wrap tabs <?= $section_classes; ?>">
    <div class="tabs__container container">
        <div class="tabs__wrapper">
            <div class="tabs__menu tabs-menu">
                <button type="button" class="tabs-menu__pagination tabs-menu__pagination--prev disabled" aria-hidden="true">
                    <span class="ikes-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Scroll to previous tab items</span>
                </button>

                <div class="tabs-menu__tabs">
                    <div class="tabs-menu__navigation">
                        <div class="tabs-menu__list" role="tablist" aria-orientation="horizontal">
                        <?php
                        // Build tab controls
                        $i = 0;
                        $numTabs = count($tabs);
                        foreach( $tabs as $tab ) :
                            $i++;
                            $tab_id = $i.'-'.$rand;

                            $aria = ( $i === 1 ) ? 'true' : 'false';
                            ?>
                            <button type="button" id="tab_<?= $i; ?>" class="tabs-menu__link" data-tab="tab<?= $tab_id; ?>" role="tab" aria-selected="<?= $aria; ?>" aria-controls="tab<?= $tab_id; ?>">
                                <?= $tab['tab_title']; ?>
                            </button>
                            <?php
                        endforeach;
                        ?>
                        </div>
                    </div>
                </div>

                <button type="button" class="tabs-menu__pagination tabs-menu__pagination--next" aria-hidden="true">
                    <span class="ikes-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Scroll to next tab items</span>
                </button>
            </div>
            <div class="tabs__content tabs-content">
            <?php
            //Build content of tabs
            $cx = 0;
            foreach($tabs as $tab) :
                $cx++;
                $key = 'tab' . $cx . '-' . $rand;

                $visibility = ( $cx === 1 ) ? 'false' : 'true';
                ?>
                <div id="<?= $key; ?>" class="tabs-content__panel" role="tabpanel" aria-labelledby="tab_<?= $cx; ?>" aria-hidden="<?= $visibility; ?>">
                    <?= $tab['tab_content']; ?>
                </div>
                <?php
            endforeach;
            ?>
            </div>
        </div>
    </div>
</section>