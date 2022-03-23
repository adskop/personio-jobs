<?php

/**
 * Fired during plugin activation
 */
class Personio_Jobs_Activator {
    public static function activate() {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/crate-custom-table.php';
        custom_create_db();

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/cron-job-xml.php';
        cronstarter_activation();
    }


}
