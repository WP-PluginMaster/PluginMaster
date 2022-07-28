<?php


/**
 * Plugin Name: Plugin Master
 * Plugin URI: https://wppluginmaster.com
 * Description: PluginMaster is a Plugin Development Framework
 * Version: 1.0.1
 * Author: Plugin Master
 * Author URI: https://wppluginmaster.com
 * License:  GPL-3.0
 * License URI:  http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain: Plugin Master
 */


// Exit if accessed directly.
if ( !defined( 'ABSPATH' ) ) exit;


require_once  plugin_dir_path( __FILE__ ) . '/vendor/autoload_packages.php';


use PluginMaster\Bootstrap\Bootstrap;

/**
 * Run Application
 */



 Bootstrap::boot( __FILE__ );



