<?php
$section_id = get_sub_field('section_id');
$section_classes = get_sub_field('section_classes');

$table_rows = get_sub_field('table_rows'); // repeater
$column_count = get_sub_field('table_columns'); // dropdown
$import_data = get_sub_field('import_data'); // file

// Can't just print an empty id and have id="", so build printout here instead
$id = !empty($section_id) ? "id=\"{$section_id}\"" : "";

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

// If array, get that value
if(is_array($column_count)) {
    $column_count = $column_count['value'];
}

$column_count = (int) $column_count;

if( $table_rows && !empty($table_rows) ) :
    ?>
    <section <?= $id; ?> class="section-wrap module-table <?= $section_classes; ?>">
        <div class="module-table__body">
            <div class="module-table__body__container container">
                <table class="module-table__body__table">
                <?php
                if( $import_data ) :
                    process_csv_file( $import_data, 'build_table_columns' );
                else:
                    if( $table_rows ) :
                        $cx = 0;
                        foreach( $table_rows as $row ) :
                            $cx++;
                            ?>
                            <tr class="module-table__body__row">
                                <?php
                                // Iterate through loop and dynamically create columns
                                for( $i = 0; $i <= $column_count; $i++ ) :
                                    $index = $i+1;
                                    $string = ($i > -1) ? "table_column_{$index}" : "table_column_1";
                                    $field = $row[$string];
                                    
                                    if( $cx === 1 ) {
                                        echo "<th class=\"module-table__body__heading\">{$field}</th>";
                                    } else {
                                        echo "<td class=\"module-table__body__data\">{$field}</td>";
                                    }
                                endfor;
                                ?>
                            </tr>
                            <?php
                        endforeach;
                    endif;
                endif;
                ?>
                </table>
            </div>
        </div>
    </section>
    <?php
endif;