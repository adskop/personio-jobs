<?php

function custom_create_db() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    $table_name = $wpdb->prefix . 'personio2wordpress';
    $sql = "CREATE TABLE $table_name (
 id INTEGER NOT NULL AUTO_INCREMENT,
 personioid  INTEGER NOT NULL,
 wordpressid INTEGER NOT NULL,
 PRIMARY KEY (id)
 ) $charset_collate;";
    dbDelta( $sql );
}


function custom_delete_db() {
    global $wpdb;
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    $table_name = $wpdb->prefix . 'personio2wordpress';
    $sql = "DROP TABLE $table_name  ";
    dbDelta( $sql );
}

