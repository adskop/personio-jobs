<?php

function custom_create_db() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    $table_name = $wpdb->prefix . 'personio2wordpress';
    $wpdb->query("CREATE TABLE $table_name (
 id INTEGER NOT NULL AUTO_INCREMENT,
 personioid  INTEGER NOT NULL,
 wordpressid INTEGER NOT NULL,
 subcompany varchar(255) NOT NULL,
 office varchar(255) NOT NULL,
 recruitingCategory varchar(255) NOT NULL,
 employmentType varchar(255) NOT NULL,
 schedule varchar(255) NOT NULL,
 PRIMARY KEY (id)
 ) $charset_collate;");

}


function custom_delete_db() {
    global $wpdb;
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    $table_name = $wpdb->prefix . 'personio2wordpress';
    $wpdb->query("DROP TABLE '$table_name'");
}

