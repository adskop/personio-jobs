<?php

/**
 * Fired during plugin deactivation
 *
 * @link       hkvlaanderen.nl
 * @since      1.0.0
 *
 * @package    Personio_Jobs
 * @subpackage Personio_Jobs/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Personio_Jobs
 * @subpackage Personio_Jobs/includes
 * @author     Hendrik Vlaanderen <h.k.vlaanderen@gmail.com>
 */
class Personio_Jobs_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/cron-job-xml.php';
        cronstarter_deactivate();

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/crate-custom-table.php';
        custom_delete_db();

    }

}
