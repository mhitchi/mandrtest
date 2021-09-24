<?php
$section_id = get_sub_field('section_id');
$section_classes = get_sub_field('section_classes');
$columns = get_sub_field('columns');
$section_classes .= ' columns';

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

// Section styling
$section_style = '';
$apply_text_color = get_sub_field('apply_text_color');
$section_text_color = get_sub_field('section_text_color');

if($apply_text_color && $section_text_color){
    $section_style .= 'color:'.$section_text_color.';';
}

if( $columns ) :
    ?>
    <section 
        <?= $section_id; ?> 
        class="section-wrap <?= $section_classes; ?>"
        style="<?= $section_style; ?>"
    >
    <div class="columns__container container">
        <?php
        if( $primary_title ) :
            ?>
            <header class="columns__header columns-header">
                <h2 class="columns-header__title h1"><?= $primary_title; ?></h2>
            </header>
            <?php
        endif;
        ?>
        
        <div class="columns__content">
        <?php
        foreach( $columns as $row ) :
            $column_count = (int) $row['column_count'];
            $column_heading = $row['column_heading'];
            ?>
            <div class="columns__row">
            <?php
            if( $column_heading && $column_count !== 1 ) :
                ?>
                <h2 class="columns__heading"><?= $column_heading; ?></h2>
                <?php
            endif;
            ?>
            <?php
            // Iterate through loop and dynamically create columns
            for( $i = 0; $i < $column_count; $i++ ) :
                $index = $i+1;
                $string = ($i > -1) ? "column_{$index}" : "column";
                $field = $row[$string];

                // If variable
                if( $column_count === 7 & $i > 1) {
                    continue;
                }
                ?>
                <div class="column <?php module_get_column_width($i, $column_count, $row); ?>">
                    <?= $field; ?>
                </div>
                <?php
            endfor;
            ?>
            </div>
            <?php
        endforeach;
        ?>
        </div>
    </div>
    <span class="columns__background abs-cover bg-image" style="<?= get_section_style(); ?>"></span>
    </section> 
    <?php
endif; 
?>