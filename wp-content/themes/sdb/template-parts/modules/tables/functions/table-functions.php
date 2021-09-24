<?php

/**
 * Generate Module Table repeater rows by CSV file
 */
add_action( 'save_post', 'acf_fc_table_repeater_rows', 10, 3 );
function acf_fc_table_repeater_rows( $id, $post, $update ){
    $field_object = get_field_object('page_layouts', $id);
    $fields = $field_object['value'];
    $field_key = $field_object['key'];
    $cx = 0;

    if( $fields ){
        $has_updated = false;

        foreach( $fields as $field ){
            if( $field['acf_fc_layout'] == 'module_table' ) {
                $csv = $field['import_data'];
                $table_columns = (int)$field['table_columns'];
                $table_rows = $field['table_rows'];
                $results = false;
                
                // Process CSV and build multidimensional array for repeater field
                if( $csv ){
                    $results = csv_build_table_array( $csv );
                }

                // Overwrite current repeater values w/ new array
                if( $results !== false ) {
                    $fields[$cx]['table_rows'] = $results; 
                    $fields[$cx]['import_data'] = ''; // Remove CSV file

                    $has_updated = true;
                }
            }
            
            $cx++;
        }

        // Update flex content layout w/ added module_table subfield rows
        if( $has_updated ) {
            update_field( $field_key, $fields, $id );
        }
    }
}

/**
 * Create and format array for repeater field value(s)
 * 
 * @param String $file CSV file string
 * 
 */
function csv_build_table_array( $file ){
    $row = 0;
    $new_array = array();

    if( ( $csv = fopen( $file, 'r' ) ) !== false ) {
        while ( ( $data = fgetcsv( $csv, 9999, ',' ) ) !== false ) {
            $row++;

            $new_array[] = array(
                'table_column_1' => filter_var( $data[0], FILTER_SANITIZE_STRING ),
                'table_column_2' => filter_var( $data[1], FILTER_SANITIZE_STRING ),
                'table_column_3' => filter_var( $data[2], FILTER_SANITIZE_STRING ),
                'table_column_4' => filter_var( $data[3], FILTER_SANITIZE_STRING ),
                'table_column_5' => filter_var( $data[4], FILTER_SANITIZE_STRING ),
                'table_column_6' => filter_var( $data[5], FILTER_SANITIZE_STRING ),
                'table_column_7' => filter_var( $data[6], FILTER_SANITIZE_STRING ),
                'table_column_8' => filter_var( $data[7], FILTER_SANITIZE_STRING ),
            );
        }

        fclose( $csv );

        return $new_array;
    }
}