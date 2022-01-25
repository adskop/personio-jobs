<?php
require_once( ABSPATH . 'wp-content/plugins/personio-jobs/public/post-creator1.php' );
// create a scheduled event (if it does not exist already)
function cronstarter_activation() {
    if( !wp_next_scheduled( 'mycronjob' ) ) {
        wp_schedule_event( time(), 'personio_custom', 'mycronjob' );
    }
}
// and make sure it's called whenever WordPress loads
add_action('wp', 'cronstarter_activation');

// unschedule event upon plugin deactivation
function cronstarter_deactivate() {
// find out when the last event was scheduled
    $timestamp = wp_next_scheduled ('mycronjob');
// unschedule previous event if any
    wp_unschedule_event ($timestamp, 'mycronjob');
}
register_deactivation_hook (__FILE__, 'cronstarter_deactivate');

// here's the function we'd like to call with our cron job
// do here what needs to be done automatically as per your schedule
function my_repeat_function()
{
    $cronONOFF = getCronOnOff();
    if($cronONOFF == 1){

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/post-creator.php';
        cron_job_task();

        $cronEmailONOFF = getCronEmailOnOff();
        if($cronEmailONOFF == 1){
            $cronEmailadress = getCronEmailadress();
            date_default_timezone_set('Europe/Berlin'); // CDT

            $info = getdate();
            $date = $info['mday'];
            $month = $info['mon'];
            $year = $info['year'];
            $hour = $info['hours'];
            $min = $info['minutes'];
            $sec = $info['seconds'];

            $current_date = "$date/$month/$year";
            $current_time = "$hour:$min:$sec (Serverzeit)";

            $recepients = $cronEmailadress;
            $subject = 'Personio CronJob';
            $message = 'Der CronJob wurde erfolgreich am ' . $current_date . ' um '. $current_time .' vollbracht';
            mail($recepients, $subject, $message);
        }
}
}
// hook that function onto our scheduled event:
add_action ('mycronjob', 'my_repeat_function');

// add custom interval
function cron_add_hour( $schedules ) {
    $cronIntervall = getCronIntervall();
    $cronIntervallValue = "";

    if($cronIntervall === 0){
        $cronIntervallValue = "3600";
    }elseif($cronIntervall == "everyminute"){
        $cronIntervallValue = "60";
    }elseif($cronIntervall == "everyhalfhour"){
        $cronIntervallValue = "1800";
    }elseif($cronIntervall == "everyhour"){
        $cronIntervallValue = "3600";
    }elseif($cronIntervall == "twiceday"){
        $cronIntervallValue = "43200";
    }elseif($cronIntervall == "onceday"){
        $cronIntervallValue = "86400";
    }

    $schedules['personio_custom'] = array(
        'interval' => $cronIntervallValue,
        'display' => __( 'Custom Personio Intervall' )
    );
    return $schedules;
}
add_filter( 'cron_schedules', 'cron_add_hour' );

