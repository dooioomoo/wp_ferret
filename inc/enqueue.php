<?php
/**
 * _ferret's enqueue
 * @package _ferret
 */

/**
 * Enqueue scripts and styles.
 */

add_action('wp_enqueue_scripts', '_ferret_scripts');

/**
 * wordpress enqueue script and css  function
 */

function _ferret_scripts()
{
    /**
     * css
     */
    wp_enqueue_style('_ferret-style-common', get_stylesheet_uri().'/assets/css/common.min.css');
    wp_enqueue_style('_ferret-style-base', get_stylesheet_uri().'/assets/css/dooioomoo.css');
    wp_enqueue_style('_ferret-style-customize', get_stylesheet_uri().'/assets/css/custom.css');

    /**
     * scripts
     */
    wp_enqueue_script('_ferret-navigation', get_template_directory_uri() . '/assets/js/xzoom.min.js', array('jquery'), ___ferretthemever__, false);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}