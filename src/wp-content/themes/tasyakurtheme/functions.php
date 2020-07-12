<?php
/**
 * Main point of the theme.
 * This file is responsible to call all required files and main theme class file.
 * In order to structure the theme more neatly, this file is not supposed to do anything else other than calling main theme class file.
 *
 */

/**
 * Scan the api path, recursively including all PHP files
 *
 * @param string  $dir
 * @param int     $depth (optional)
 */
function _require_all($dir, $depth=0) {
    // require all php files
    $scan = glob("$dir/*");
    foreach ($scan as $path) {
        if (preg_match('/\.php$/', $path)) {
            require_once $path;
        }
        elseif (is_dir($path)) {
            _require_all($path, $depth+1);
        }
    }
}
_require_all( get_template_directory() . "/inc" );

/**
 * Init main theme app class
 */
new TasyakurTheme;
