<?php

function postcreator($name,$content,$status,$author,$type){

$post_data = array(
    'post_title' => $name,
    'post_content' => $content,
    'post_status' => $status, // Automatically publish the post.
    'post_author' => $author,
    'post_category' => array( 1, 3 ), // Add it two categories.
        'post_type' => $type // defaults to "post". Can be set to CPTs.
    );

    // Lets insert the post now.
     $post_id =  wp_insert_post( $post_data );

    return $post_id;

}

function getPersonioIDs()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'personio2wordpress';
        $result = $wpdb->get_results ("SELECT personioid FROM $table_name ");

 $personioIDs = array();

 foreach ( $result as $ID){
     array_push($personioIDs, $ID->personioid);
 }
        return $personioIDs;
    }

function getWordPressIDs()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'personio2wordpress';
    $result = $wpdb->get_results ("SELECT wordpressid FROM $table_name ");

    $wordpressIDs = array();

    foreach ( $result as $ID){
        array_push($wordpressIDs, $ID->wordpressid);
    }
    return $wordpressIDs;
}

function getPostsIDs()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'posts';
    $result = $wpdb->get_results ("SELECT `ID` FROM  $table_name WHERE post_author = 442123924562346 AND post_status = 'publish'");

    $wordpressIDs = array();
    foreach ( $result as $ID){
        array_push($wordpressIDs, $ID->ID);
    }
    return  $wordpressIDs;
}

function getWordPressID($personioID)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'personio2wordpress';
    $result = $wpdb->get_results ("SELECT wordpressid FROM $table_name WHERE personioid = $personioID");

    $id = $result[0]->wordpressid;

    return $id;
}

function insertP2W($personioid,$post_id){
    global $wpdb;
    $table_name = $wpdb->prefix . 'personio2wordpress';

    $sql = "INSERT INTO $table_name (personioid, wordpressid) VALUES ($personioid,$post_id)";
    dbDelta( $sql );
}


function deleteP2W($personioid,$wordpressid){
    global $wpdb;
    $table_name = $wpdb->prefix . 'personio2wordpress';

    $sql = "DELETE FROM $table_name WHERE personioid = $personioid AND wordpressid = $wordpressid";
    dbDelta( $sql );
}

function getCronOnOff()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'options';
    $result = $wpdb->get_results ("SELECT option_value FROM $table_name WHERE option_name = 'personio-cron-on-off'");

    $option = $result[0]->option_value;

    if ($option == null){
        $option = 0;
    }

    return $option;
}

function getCronIntervall()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'options';
    $result = $wpdb->get_results ("SELECT option_value FROM $table_name WHERE option_name = 'personio-cron-intervall'");

    $option = $result[0]->option_value;

    if ($option == null){
        $option = 0;
    }

    return $option;
}

function getCronEmailOnOff()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'options';
    $result = $wpdb->get_results ("SELECT option_value FROM $table_name WHERE option_name = 'personio-cron-email-on-off'");

    $option = $result[0]->option_value;

    if ($option == null){
        $option = 0;
    }

    return $option;
}

function getCronEmailadress()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'options';
    $result = $wpdb->get_results ("SELECT option_value FROM $table_name WHERE option_name = 'personio-cron-email'");

    $option = $result[0]->option_value;

    if ($option == null){
        $option = 0;
    }

    return $option;
}

?>
