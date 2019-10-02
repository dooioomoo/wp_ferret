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
    wp_enqueue_style('shihaku-style-common', __shihaku_theme_uri__.'/assets/css/common.min.css');
    wp_enqueue_style('shihaku-style-base', __shihaku_theme_uri__.'/assets/css/dooioomoo.css');
    wp_enqueue_style('shihaku-style-customize', __shihaku_theme_uri__.'/assets/css/custom.css');

    wp_enqueue_style( 'shihaku-style', get_stylesheet_uri() );
    /**
     * scripts
     */
    wp_enqueue_script('shihaku-navigation-js', __shihaku_theme_uri__ . '/assets/js/navigation.min.js', array(), __shihaku_theme_ver__, true);
    wp_enqueue_script('shihaku-common-js', __shihaku_theme_uri__ . '/assets/js/common.min.js', array(), __shihaku_theme_ver__, true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
