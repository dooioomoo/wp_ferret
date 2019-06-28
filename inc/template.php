<?php
/**
 * _ferret's template setting
 * @package _ferret
 */

add_filter('body_class', '_ferret_body_classes');


/**
 * @param $classes
 *
 * @return array
 */
if ( !function_exists('_ferret_body_classes') ):
    function _ferret_body_classes( $classes )
    {

        if ( !is_singular() ) {

            $classes[] = 'non-singular';
        }
        if ( !_ferret_sidebar_is_active() ) {
            $classes[] = 'no-sidebar';
        } else {
            $classes[] = 'has-sidebar';
        }

        return $classes;
    }
endif;

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