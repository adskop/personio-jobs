<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              hkvlaanderen.nl
 * @since             1.0.0
 * @package           Personio_Jobs
 *
 * @wordpress-plugin
 * Plugin Name:       Personio Jobs
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Bob Limbach
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       personio-jobs
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-personio-jobs-activator.php
 */
function activate_personio_jobs() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-personio-jobs-activator.php';
	Personio_Jobs_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-personio-jobs-deactivator.php
 */
function deactivate_personio_jobs() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-personio-jobs-deactivator.php';
	Personio_Jobs_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_personio_jobs' );
register_deactivation_hook( __FILE__, 'deactivate_personio_jobs' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-personio-jobs.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_personio_jobs() {

	$plugin = new Personio_Jobs();
	$plugin->run();

}
run_personio_jobs();
