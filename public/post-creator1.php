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

function getPostTitle($ID)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'posts';
    $result = $wpdb->get_results ("SELECT post_title FROM $table_name WHERE ID = $ID ");

    $title = $result[0]->post_title;

    return $title;
}

function getPostURL($ID)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'posts';
    $result = $wpdb->get_results ("SELECT guid FROM $table_name WHERE ID = $ID ");

    $url = $result[0]->guid;

    return $url;
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

function getPersonioID($wordpressID)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'personio2wordpress';
    $result = $wpdb->get_results ("SELECT personioid FROM $table_name WHERE wordpressid = $wordpressID");

    $id = $result[0]->personioid;

    return $id;
}

function getSubcompany($wordpressID)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'personio2wordpress';
    $result = $wpdb->get_results ("SELECT `subcompany` FROM  $table_name WHERE `wordpressid` = $wordpressID");

    $id = $result[0]->subcompany;

    return $id;
}

function getOffice($wordpressID)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'personio2wordpress';
    $result = $wpdb->get_results ("SELECT `office` FROM  $table_name WHERE `wordpressid` = $wordpressID");

    $id = $result[0]->office;

    return $id;
}

function getRecruitingCategory($wordpressID)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'personio2wordpress';
    $result = $wpdb->get_results ("SELECT `recruitingCategory` FROM  $table_name WHERE `wordpressid` = $wordpressID");

    $id = $result[0]->recruitingCategory;

    return $id;
}

function getEmploymentType($wordpressID)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'personio2wordpress';
    $result = $wpdb->get_results ("SELECT `employmentType` FROM  $table_name WHERE `wordpressid` = $wordpressID");

    $id = $result[0]->employmentType;

    return $id;
}

function getSchedule ($wordpressID)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'personio2wordpress';
    $result = $wpdb->get_results ("SELECT `schedule` FROM  $table_name WHERE `wordpressid` = $wordpressID");

    $id = $result[0]->schedule;

    return $id;
}

function insertP2W($personioid,$post_id){
    global $wpdb;
    $table_name = $wpdb->prefix . 'personio2wordpress';
    $wpdb->get_results("INSERT INTO $table_name (personioid, wordpressid) VALUES ($personioid,$post_id)");
}

function updateP2W($id,$subcompany,$office,$recruitingCategory,$employmentType,$schedule){
    global $wpdb;
    $table_name = $wpdb->prefix . 'personio2wordpress';
    $wpdb->get_results("UPDATE $table_name SET subcompany = '$subcompany', office = '$office', recruitingCategory  = '$recruitingCategory', employmentType = '$employmentType', schedule = '$schedule' WHERE personioid = $id");
}


function deleteP2W($personioid){
    global $wpdb;
    $table_name = $wpdb->prefix . 'personio2wordpress';
    $wpdb->get_results("DELETE FROM $table_name WHERE personioid = '$personioid'");
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
