<?php

/**
 * Fired during plugin activation
 *
 * @link       hkvlaanderen.nl
 * @since      1.0.0
 *
 * @package    Personio_Jobs
 * @subpackage Personio_Jobs/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Personio_Jobs
 * @subpackage Personio_Jobs/includes
 * @author     Hendrik Vlaanderen <h.k.vlaanderen@gmail.com>
 */
class Personio_Jobs_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
    public static function activate() {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/crate-custom-table.php';
     custom_create_db();

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/cron-job-xml.php';
        cronstarter_activation();
    }


}
