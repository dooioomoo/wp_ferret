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

    foreach ( $wp_registered_sidebars as $sidebar ) {
        if ( is_active_sidebar($sidebar['name']) or is_active_sidebar($sidebar['id']) ) {
            return true;
        }
    }
    return false;
}

function _ferret_get_all_sidebar()
{
    global $wp_registered_sidebars;
    $allsidebar = array();
    $allsidebar['none'] = __('no sidebar', '_ferret');
    foreach ( $wp_registered_sidebars as $sidebar ) {
        $allsidebar[$sidebar['id']] = $sidebar['name'];
    }
    return $allsidebar;

}

/**
 * return all post type
 * @return array
 */
function _ferret_get_all_posttype()
{

    $checkgroup = array(
        'post',
        'page'
    );
    $args = array(
        'public' => true,
        '_builtin' => false
    );
    $output = 'names'; // 'names' or 'objects' (default: 'names')
    $operator = 'and'; // 'and' or 'or' (default: 'and')
    $post_types = get_post_types($args, $output, $operator);
    if ( $post_types ) { // If there are any custom public post types.
        foreach ( $post_types as $post_type ) {
            array_push($checkgroup, $post_type);
        }
    }
    return $checkgroup;
}

/**
 * Checks to see if we're on the homepage or not.
 */
function _ferret_is_frontpage()
{
    return (is_front_page() && !is_home());
}

/**
 * widget helper
 */
if ( !function_exists('_ferret_display_widget') ):

    function _ferret_display_widget()
    {
        global $post;
        $val = ($val = get_post_meta($post->ID, "_ferret_display_post_sidebar", true)) ? $val : get_theme_mod('_ferret_widget_default_view_' . get_post_type(), 'master-sidebar');
        if ( $val != 'none' )
            dynamic_sidebar($val);

    }
endif;

if ( !function_exists('_ferret_check_widget') ):

    function _ferret_check_widget()
    {
        global $post;
        $val = ($val = get_post_meta($post->ID, "_ferret_display_post_sidebar", true)) ? $val : get_theme_mod('_ferret_widget_default_view_' . get_post_type(), 'master-sidebar');
        if ( $val != 'none' and $val !='default' ):
            return true;
        else:
            return false;
        endif;

    }
endif;

