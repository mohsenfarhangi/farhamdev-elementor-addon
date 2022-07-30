<?php
/**
 * Plugin Name: File print cost calculator
 * Plugin URI:
 * Description: محاسبه کننده هزینه پرینت فایل
 * Author: Mohsen Farhangi
 * Author URI: http://Farhamdev.ir
 * Text Domain: swsplang
 * Domain Path: /languages/
 * Version: 0.1
 */

if (!defined('ABSPATH')){
    exit(404);
}

define('SWPS_PATH',plugin_dir_path(__FILE__));
define('SWPS_URL',plugin_dir_url(__FILE__));
define('SWPS_BASE_NAME',plugin_basename(__FILE__));

/**
 * Load plugin textdomain.
 */
add_action('init', '_swps_load_textdomain');
function _swps_load_textdomain()
{
    load_plugin_textdomain('swsplang', false, dirname(plugin_basename(__FILE__)) . '/languages');
}

include __DIR__."/vendor/autoload.php";
include __DIR__."/admin/functions.php";
include __DIR__."/front/functions.php";
include __DIR__."/inc/functions.php";
