<?php
$section_id = get_sub_field('section_id');
$section_classes = get_sub_field('section_classes');

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

?>
<section <?= $id; ?> class="section-wrap standard-callout  <?= $section_classes; ?>">
    <div class="standard-callout__container container">
        <div class="standard-callout__wrap callout-card-style">
            <h2><?= get_sub_field('title'); ?></h2>
            <p><?= get_sub_field('message'); ?></p>
            <?= mr_display_button(get_sub_field('button_text'),get_sub_field('button_link')); ?>
        </div>
    </div>
</section>