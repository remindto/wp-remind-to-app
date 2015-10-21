<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/RemindToRead/wp-remind-to-read
 * @since             1.0.0
 * @package           Remind_to_read
 *
 * @wordpress-plugin
 * Plugin Name:       Remind to Read
 * Plugin URI:        https://github.com/RemindToRead/wp-remind-to-read
 * Description:       Remind to Read provides your users a reminder to reengage content
 * Version:           1.0.0
 * Author:            Remind to Read
 * Author URI:        https://github.com/RemindToRead/wp-remind-to-read
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       remind-to-read
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-remind-to-read-activator.php
 */
function activate_remind_to_read() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-remind-to-read-activator.php';
	Remind_To_Read_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-remind-to-read-deactivator.php
 */
function deactivate_remind_to_read() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-remind-to-read-deactivator.php';
	Remind_To_Read_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_remind_to_read' );
register_deactivation_hook( __FILE__, 'deactivate_remind_to_read' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-remind-to-read.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_remind_to_read() {

	$remind_to_read = new Remind_To_Read();
	$remind_to_read->run();

}
run_remind_to_read();
