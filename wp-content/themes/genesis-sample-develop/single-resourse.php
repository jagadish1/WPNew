<?php

/** Customize the post info function. */
add_filter( 'genesis_post_info', 'wpse_108715_post_info_filter' );

/** Customize the post meta function. */
add_filter( 'genesis_post_meta', 'wpse_108715_post_meta_filter' );

genesis();

/**
 * Change the default post information line.
 */
function wpse_108715_post_info_filter( $post_info ) {
    $post_info = '[post_author_posts_link] [post_date]';
    return $post_info;
}

/**
 * Change the default post meta line.
 */
function wpse_108715_post_meta_filter( $post_meta ) {
    $post_meta = '[post_categories] [post_edit] [post_tags] [post_comments]';
    return $post_meta;
}
?>

