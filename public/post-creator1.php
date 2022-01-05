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

?>
