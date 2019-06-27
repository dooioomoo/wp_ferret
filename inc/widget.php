<?php
/**
 * _ferret's widget setting
 * @package _ferret
 */

add_action('widgets_init', '_ferret_widgets_init');

/**
 * widget function
 */
function _ferret_widgets_init()
{
    register_sidebar(array(
        'name'          => esc_html__('Sidebar', '_ferret'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here.', '_ferret'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Header Sidebar', '_ferret'),
        'id'            => 'header-sidebar',
        'description'   => esc_html__('Add widgets here.', '_ferret'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer Sidebar', '_ferret'),
        'id'            => 'footer-sidebar',
        'description'   => esc_html__('Add widgets here.', '_ferret'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}