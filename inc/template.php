<?php
/**
 * _ferret's template setting
 * @package _ferret
 */

add_filter('body_class', '_ferret_body_classes');
add_action( 'add_meta_boxes', '_ferret_add_options_to_all_post_type' );

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

/**
 * add options box to all post type
 */

function _ferret_add_options_to_all_post_type(){
    add_meta_box(
        'custom_sidebar',
        __( 'Options', '_ferret' ),
        '_ferret_add_options_to_all_post_type_callback',
        'post',
        'side'
    );
}

function _ferret_add_options_to_all_post_type_callback($post){

}