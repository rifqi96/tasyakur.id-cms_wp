<?php
/**
 * Plugin Name: Tasyakur App
 * Version: 0.0.1
 * Description: This is the main tasyakur app entry point. It uses PSR-4 and OOP logic instead of procedural coding. Every function, hook and action is properly divided and organized inside related folders and files.
 * Author: Tasyakur
 * Author URI: https://tasyakur.com
 * Text Domain: tasyakur-app
 *
 * @author  Tasyakur <hello@tasyakur.com>
 * @package tasyakur-app
 */

// Make sure autoload is there
if ( !file_exists( __DIR__ . '/vendor/autoload.php' ) )
    throw new Exception('Autoload is not found. Make sure to do composer install.');
// Load the autoload
require_once __DIR__ . '/vendor/autoload.php';

// Make sure app main class is there
if ( !class_exists( 'Tasyakur\\App' ) )
    throw new Exception('App main class is not found');

// Bootstrap it!
$app = new Tasyakur\App(
    __DIR__ . '/inc'
);

return $app;