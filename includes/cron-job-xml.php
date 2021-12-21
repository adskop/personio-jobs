<?php
// create a scheduled event (if it does not exist already)
function cronstarter_activation() {
    if( !wp_next_scheduled( 'mycronjob' ) ) {
        wp_schedule_event( time(), 'everyminute', 'mycronjob' );
    }
}
// and make sure it's called whenever WordPress loads
add_action('wp-xml', 'cronstarter_activation');

// unschedule event upon plugin deactivation
function cronstarter_deactivate() {
// find out when the last event was scheduled
    $timestamp = wp_next_scheduled ('mycronjob');
// unschedule previous event if any
    wp_unschedule_event ($timestamp, 'mycronjob');
}
register_deactivation_hook (__FILE__, 'cronstarter_deactivate');

// here's the function we'd like to call with our cron job
function my_repeat_function() {
// do here what needs to be done automatically as per your schedule
// in this example we're sending an email
// components for our email
    $recepients = 'bob.limbach@skopos.de';
    $subject = 'Hello from your Cron Job';
    $message = 'This is a test mail sent by WordPress automatically as per your schedule.';
// let's send it
    mail($recepients, $subject, $message);
}
// hook that function onto our scheduled event:
add_action ('mycronjob', 'my_repeat_function');

// add custom interval
function cron_add_minute( $schedules ) {
// Adds once every minute to the existing schedules.
    $schedules['everyminute'] = array(
        'interval' => 60,
        'display' => __( 'Once Every Minute' )
    );
    return $schedules;
}
add_filter( 'cron_schedules', 'cron_add_minute' );

