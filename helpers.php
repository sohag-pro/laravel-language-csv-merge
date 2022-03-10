<?php

/**
 * @param $key
 * @param $default
 */
function env( $key, $default = null ) {
    return isset( $_ENV[$key] ) ? $_ENV[$key] : $default;
}

function appName() {
    return env( 'APP_NAME', 'Laravel' );
}

/**
 * @param $key
 * @param $default
 */
function setting( $key, $default = null ) {
    return env( $key, $default );
}

/**
 * Log a message to the console
 *
 * @param  $str
 * @param  $type
 * @return void
 */
function logger( $str, $type = 'i' ) {
    switch ( $type ) {
        case 'e': //error
            echo "\033[31m$str \033[0m\n" . PHP_EOL;
            break;
        case 's': //success
            echo "\033[32m$str \033[0m\n" . PHP_EOL;
            break;
        case 'w': //warning
            echo "\033[33m$str \033[0m\n" . PHP_EOL;
            break;
        case 'i': //info
            echo "\033[36m$str \033[0m\n" . PHP_EOL;
            break;
        default:
            echo "\033[36m$str \033[0m\n" . PHP_EOL;
            break;
    }
}
