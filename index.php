<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://alemran.me/
 * @since             1.0.0
 * @package           WP Plugin Development FW
 *
 * @wordpress-plugin
 * Plugin Name:       PluginMaster
 * Plugin URI:        https://github.com/emrancu/wordpressPlugin
 * Description:       This is a framework for developing WordPress Plugin.
 * Version:           1.0.0
 * Author:            AL EMRAN
 * Author URI:        http://alemran.me/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.

if (!defined('WPINC')) {
    die;
}


require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';

use App\system\bootstrap\Boot;
use App\system\core\Settings;

Settings::init(__FILE__);
Boot::init();





