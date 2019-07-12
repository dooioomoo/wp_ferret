<?php
/**
 * _ferret's template customize
 * @package _ferret
 */

add_action('customize_register', '_ferret_template_customize_register');

add_filter('comment_form_defaults', '_ferret_comment_form_change');

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
    $wp_customize->add_setting(
        '_ferret_widget_default_order_master', array(
                                                   'default' => 'right',
                                                   'transport' => 'postMessage',
                                               )
    );
    $wp_customize->add_control(new WP_Customize_Control(
                                   $wp_customize,
                                   '_ferret_widget_default_order_master',
                                   array(
                                       'label' => __('Default sidebar for master', '_ferret'),
                                       'section' => '_ferret_theme_options_widget_section',
                                       'settings' => '_ferret_widget_default_order_master',
                                       'type' => 'select',
                                       'choices' => array(
                                           'right' => __('right', '_ferret'),
                                           'left' => __('left', '_ferret'),
                                       )
                                   )
                               )
    );
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
        $wp_customize->add_setting(
            '_ferret_widget_default_order_' . $type, array(
                                                       'default' => 'right',
                                                       'transport' => 'postMessage',
                                                   )
        );
        $wp_customize->add_control(new WP_Customize_Control(
                                       $wp_customize,
                                       '_ferret_widget_default_order_' . $type,
                                       array(
                                           'section' => '_ferret_theme_options_widget_section',
                                           'settings' => '_ferret_widget_default_order_' . $type,
                                           'type' => 'select',
                                           'choices' => array(
                                               'right' => __('right', '_ferret'),
                                               'left' => __('left', '_ferret'),
                                           )
                                       )
                                   )
        );
    }

}

function _ferret_comment_form_change( $form )
{
    global $user_identity, $post_id;
    $form['logged_in_as'] = '<p class="logged-in-as">' . sprintf(
        /* translators: 1: edit user link, 2: accessibility text, 3: user name, 4: logout URL */
            __('<a href="%1$s" aria-label="%2$s" class="btn btn-primary btn-lg">Logged in as %3$s</a>&nbsp;&nbsp;<a href="%4$s" class="btn btn-info btn-lg">Log out?</a>', '_ferret'),
            get_edit_user_link(),
            /* translators: %s: user name */
            esc_attr(sprintf(__('Logged in as %s. Edit your profile.', '_ferret'), $user_identity)),
            $user_identity,
            wp_logout_url(apply_filters('the_permalink', get_permalink($post_id), $post_id))
        ) . '</p>';

    return $form;
}