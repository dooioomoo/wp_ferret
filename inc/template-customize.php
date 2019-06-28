<?php
/**
 * _ferret's template customize
 * @package _ferret
 */

add_action('customize_register', '_ferret_template_customize_register');

if ( !function_exists('_ferret_template_customize_register') ):
    function _ferret_template_customize_register( $wp_customize )
    {
        /**
         * add default view for widget
         */

        $wp_customize->add_panel('_ferret_theme_options', array(
            'priority' => 500,
            'theme_supports' => '',
            'title' => __('Theme Options', '_ferret'),
            'description' => __('set something for the theme.', '_ferret'),
        ));

        $wp_customize->add_section('_ferret_theme_options_widget_section', array(
            'title' => __('Widget', '_ferret'),
            'description' => __('custom theme widget options in here'),
            'panel' => '_ferret_theme_options', // Not typically needed.
        ));

//        $wp_customize->add_setting(
//            '_ferret_widget_default_view', array(
//                                             'default' => 'master-sidebar',
//                                             'transport' => 'postMessage',
//                                         )
//        );
//        $wp_customize->add_control(new WP_Customize_Control(
//                                       $wp_customize,
//                                       '_ferret_widget_default_view',
//                                       array(
//                                           'label' => __('Default sidebar in all post type', '_ferret'),
//                                           'section' => '_ferret_theme_options_widget_section',
//                                           'settings' => '_ferret_widget_default_view',
//                                           'type' => 'select',
//                                           'choices' => _ferret_get_all_sidebar()
//                                       )
//                                   )
//        );
        _ferret_widget_default_view_by_posttype($wp_customize);

    }
endif;


/**
 * create default sidebar view by post type
 *
 * @param $wp_customize
 */
function _ferret_widget_default_view_by_posttype( $wp_customize )
{
    $post_type = _ferret_get_all_posttype();
    foreach ( $post_type as $index => $type ) {
        $wp_customize->add_setting(
            '_ferret_widget_default_view_' . $type, array(
                                                      'default' => 'master-sidebar',
                                                      'transport' => 'postMessage',
                                                  )
        );
        $wp_customize->add_control(new WP_Customize_Control(
                                       $wp_customize,
                                       '_ferret_widget_default_view_' . $type,
                                       array(
                                           'label' => __('Default sidebar for', '_ferret') . ' \'' . $type . '\'',
                                           'section' => '_ferret_theme_options_widget_section',
                                           'settings' => '_ferret_widget_default_view_' . $type,
                                           'type' => 'select',
                                           'choices' => _ferret_get_all_sidebar()
                                       )
                                   )
        );
    }
}

function _ferret_display_widget_in_post_type()
{
    $type = get_post_type() ? get_post_type() : '';
    $sidebar_name = get_theme_mod('_ferret_widget_default_view_' . $type, 'master-sidebar');
    dynamic_sidebar($sidebar_name);

}