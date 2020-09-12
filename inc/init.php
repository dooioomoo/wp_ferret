<?php
/**
 * _ferret's functions
 * @package _ferret
 */

/**
 * theme init
 */
add_action('after_setup_theme', '_ferret_setup');
add_action('after_setup_theme', '_ferret_content_width', 0);
add_action('after_setup_theme', '_ferret_custom_header_setup');

/**
 * include widget settings
 */
require_once(___ferret_theme_path__ . '/inc/customize.php');

require_once(___ferret_theme_path__ . '/inc/base/add_action.php');
require_once(___ferret_theme_path__ . '/inc/base/helper.php');
require_once(___ferret_theme_path__ . '/inc/base/widget.php');
require_once(___ferret_theme_path__ . '/inc/base/enqueue.php');
require_once(___ferret_theme_path__ . '/inc/base/icon-functions.php');

require_once(___ferret_theme_path__ . '/inc/template/template.php');
require_once(___ferret_theme_path__ . '/inc/template/template-customize.php');
require_once(___ferret_theme_path__ . '/inc/template/template-tags.php');
require_once(___ferret_theme_path__ . '/inc/template/loader.php');

require_once(___ferret_theme_path__ . '/inc/woocommerce/_ferret_shop.php');

if ( class_exists('WooCommerce') ) {
    require_once(___ferret_theme_path__ . '/inc/woocommerce/woocommerce.php');
}

/**
 * theme init functions
 */
if ( !function_exists('_ferret_setup') ) :
    function _ferret_setup()
    {
        load_theme_textdomain('_ferret', ___ferret_theme_path__ . '/languages');

//        add_theme_support( 'automatic-feed-links' );
//        add_theme_support( 'title-tag' );
        add_theme_support('post-thumbnails');
        add_theme_support('customize-selective-refresh-widgets');

        register_nav_menus(array(
                               'PrimaryMenu' => esc_html__('Primary', '_ferret'),
                           ));

        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        add_theme_support('custom-background', apply_filters('_ferret_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));

        //add_theme_support('custom-logo', array(
        //    'height' => 250,
        //    'width' => 250,
        //    'flex-width' => true,
        //    'flex-height' => true,
        //));
    }
endif;

if ( !function_exists('_ferret_content_width') ):
    function _ferret_content_width()
    {
        $GLOBALS['content_width'] = apply_filters('_ferret_content_width', 640);
    }
endif;

if ( !function_exists('_ferret_custom_header_setup') ):
    function _ferret_custom_header_setup()
    {
        add_theme_support('custom-header', apply_filters('_ferret_custom_header_args', array(
            'default-image' => ___ferret_theme_uri__ . '/assets/images/header.jpg',
            'default-text-color' => '000000',
            'width' => 1920,
            'height' => 300,
            'flex-height' => true,
        )));
    }
endif;


add_action('after_setup_theme', '_ferret_cleanup');

if (!function_exists('_ferret_cleanup')) {

	function _ferret_cleanup()
	{
		remove_action('wp_head', 'rsd_link');
		remove_action('wp_head', 'wp_generator');
		remove_action('wp_head', 'feed_links', 2);
		remove_action('wp_head', 'feed_links_extra', 3);
		remove_action('wp_head', 'index_rel_link');
		remove_action('wp_head', 'wlwmanifest_link');
		remove_action('wp_head', 'start_post_rel_link', 10, 0);
		remove_action('wp_head', 'parent_post_rel_link', 10, 0);
		remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
		remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
		remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
		remove_action('wp_head', 'print_emoji_detection_script', 7);
		remove_action('wp_head', 'rel_canonical');
		remove_action('wp_head', 'rel_alternate');
		remove_action('wp_head', 'wp_oembed_add_discovery_links');
		remove_action('wp_head', 'wp_oembed_add_host_js');
		remove_action('wp_head', 'rest_output_link_wp_head');

		remove_action('rest_api_init', 'wp_oembed_register_route');
		remove_action('wp_print_styles', 'print_emoji_styles');

		remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
		remove_filter('pre_oembed_result', 'wp_filter_pre_oembed_result', 10);

		add_filter('embed_oembed_discover', '__return_false');
		add_filter('show_admin_bar', '__return_false');
	}
}
