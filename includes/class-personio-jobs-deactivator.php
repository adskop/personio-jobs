<?php

/**
 * Fired during plugin deactivation
 */
class Personio_Jobs_Deactivator {
	public static function deactivate() {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/cron-job-xml.php';
        cronstarter_deactivate();

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/crate-custom-table.php';
        custom_delete_db();
        delete_plugin_posts();
    }
}
