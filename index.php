<?php

require 'service.php';

$data_directory     = 'data'; // directory to get & store data, must be writable and readable
$old_file_name      = 'messages.php'; // Main file to be updated
$new_file_name      = 'messages.csv'; // New file to be merged
$exported_file_name = 'merged.php'; // Name of the exported file

merge( $old_file_name, $new_file_name, $exported_file_name, $data_directory );
