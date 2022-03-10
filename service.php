<?php

require 'helpers.php';

/**
 * Merge new file data into old file
 *
 *
 * @param  $old_file_name
 * @param  $new_file_name
 * @param  $exported_file_name
 * @param  $data_directory
 * @return void
 */
function merge( $old_file_name, $new_file_name, $exported_file_name, $data_directory = 'data' ) {
    logger( 'Starting merge process...', 'w' );

    logger( 'Checking if data directory exists...' );
    if ( !file_exists( $data_directory ) ) {
        logger( 'Data directory does not exist, creating...', 'w' );
        mkdir( $data_directory );
    }

    logger( 'Checking if data directory is writable...' );
    if ( !is_writable( $data_directory ) ) {
        logger( 'Data directory is not writable, exiting...', 'e' );
        exit;
    }

    try {
        logger( 'Checking if old file exists...' );
        $old_data = require $data_directory . '/' . $old_file_name;
        logger( 'Old file exists, merging...', 's' );

        logger( 'Checking if new file exists...' );
        $file  = fopen( $data_directory . '/' . $new_file_name, 'r' );
        $csv = [];
        while (  ( $line = fgetcsv( $file ) ) !== FALSE ) {
            $csv[] = $line;
        }
        fclose( $file );
        logger( 'New file exists, merging...', 's' );
        

        logger( 'Checking if new file is valid...' );
        $formated_data = [];
        foreach ( $csv as $value ) {
            if ( !empty( $value[0] ) ) {
                $formated_data[$value[0]] = $value[2] ?? '';
            }
        }

        logger( 'New file is valid, merging...', 's' );

        foreach ( $old_data as $key => $value ) {

            // check if key is same
            if ( array_key_exists( $key, $formated_data ) ) {
                // check if value is an array
                if ( is_array( $value ) ) {
                    $old_data[$key]['message'] = $formated_data[$key];
                } else {
                    $old_data[$key] = $formated_data[$key];
                }
            }

        }

        logger( 'Old file merged, exporting...' );

        file_put_contents( $data_directory . '/' . $exported_file_name, '<?php ' . PHP_EOL . PHP_EOL . 'return ' . var_export( $old_data, true ) . ';' . PHP_EOL );

        logger( 'Old file exported, process finished!', 's' );
    } catch ( \Throwable$th ) {
        logger( 'Error: ' . $th->getMessage(), 'e' );
    }

}
