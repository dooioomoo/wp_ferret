<?php
/**
 * _ferret's helps
 * @package _ferret
 */

/**
 * chekck any sidebar is avtive
 * @return bool
 */
function _ferret_sidebar_is_active()
{
    global $wp_registered_sidebars;

    foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) {
        if ( is_active_sidebar($sidebar['name']) or is_active_sidebar($sidebar['id']) ) {
            return true;
        }
    }
    return false;
}

/**
 * return all post type
 * @return array
 */
function _ferret_get_all_posttype(){

    $checkgroup = array(
        'post',
        'page'
    );
    $args       = array(
        'public' => true,
        '_builtin' => false
    );
    $output     = 'names'; // 'names' or 'objects' (default: 'names')
    $operator   = 'and'; // 'and' or 'or' (default: 'and')
    $post_types = get_post_types($args, $output, $operator);
    if ($post_types) { // If there are any custom public post types.
        foreach ($post_types as $post_type) {
            array_push($checkgroup, $post_type);
        }
    }
    return $checkgroup;
}