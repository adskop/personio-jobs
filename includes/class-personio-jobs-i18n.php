<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       hkvlaanderen.nl
 * @since      1.0.0
 *
 * @package    Personio_Jobs
 * @subpackage Personio_Jobs/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Personio_Jobs
 * @subpackage Personio_Jobs/includes
 * @author     Hendrik Vlaanderen <h.k.vlaanderen@gmail.com>
 */
class Personio_Jobs_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'personio-jobs',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
