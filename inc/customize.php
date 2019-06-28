<?php
/**
 * _ferret's customiz settings
 * @package _ferret
 */


add_action('customize_register', '_ferret_customize_register');

add_action('wp_footer', '_ferret_format_wp_head::open', 1);
add_action('wp_footer', '_ferret_format_wp_head::stop', 1000);
add_action('wp_head', '_ferret_format_wp_head::open', 1);
add_action('wp_head', '_ferret_format_wp_head::stop', 1000);
/**
 * customize page init settings
 *
 * @param $wp_customize
 */
if ( !function_exists('_ferret_customize_register') ):
    function _ferret_customize_register( $wp_customize )
    {
        $wp_customize->get_setting('blogname')->transport = 'postMessage';
        $wp_customize->get_setting('blogdescription')->transport = 'postMessage';
        $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

        if ( isset($wp_customize->selective_refresh) ) {
            $wp_customize->selective_refresh->add_partial('blogname', array(
                'selector' => '.site-title a',
                'render_callback' => '_ferret_customize_partial_blogname',
            ));
            $wp_customize->selective_refresh->add_partial('blogdescription', array(
                'selector' => '.site-description',
                'render_callback' => '_ferret_customize_partial_blogdescription',
            ));
        }


        // SEO keywords
        $wp_customize->add_setting(
            'seo_keywords', array(
                              'default' => '',
                              'transport' => 'postMessage',
                              'sanitize_callback' => '_ferret_sanitize_seo_keywords',
                          )
        );

        $wp_customize->add_control(
            'seo_keywords', array(
                              'type' => 'text',
                              'label' => __('SEO keywords', '_ferret'),
                              'description' => __('SEO keywords mainly for the frontpage', '_ferret'),
                              'section' => 'title_tagline',
                              'priority' => 57,
                          )
        );

        // SEO description
        $wp_customize->add_setting(
            'seo_description', array(
                                 'default' => '',
                                 'transport' => 'postMessage',
                                 'sanitize_callback' => '_ferret_sanitize_seo_description',
                             )
        );

        $wp_customize->add_control(
            'seo_description', array(
                                 'type' => 'text',
                                 'label' => __('SEO description', '_ferret'),
                                 'description' => __('SEO description mainly for the frontpage', '_ferret'),
                                 'section' => 'title_tagline',
                                 'priority' => 58,
                             )
        );

        /**
         * add default view for widget
         */

        $wp_customize->add_panel( '_ferret_theme_options', array(
            'priority'       => 500,
            'theme_supports' => '',
            'title'          => __( 'Theme Options', '_ferret' ),
            'description'    => __( 'set something for the theme.', '_ferret' ),
        ) );

        $wp_customize->add_section( '_ferret_theme_options_widget_section', array(
            'title' => __( 'Widget','_ferret' ),
            'description' => __( 'custom theme widget options in here' ),
            'panel' => '_ferret_theme_options', // Not typically needed.
        ) );

        $wp_customize->add_setting(
            '_ferret_widget_default_view', array(
                                     'default' => 'value2',
                                     'transport' => 'postMessage',
                                     'sanitize_callback' => '_ferret_widget_default_view',
                                 )
        );

        $wp_customize->add_control(new WP_Customize_Control(
                                       $wp_customize,
                                       '_ferret_widget_default_view',
                                       array(
                                           'label'    => __( 'Default sidebar in all post type', '_ferret' ),
                                           'section'  => '_ferret_theme_options_widget_section',
                                           'settings' => '_ferret_widget_default_view',
                                           'type'     => 'select',
                                           'choices'    => array(
                                               'value1' => 'Choice 1',
                                               'value2' => 'Choice 2',
                                               'value3' => 'Choice 3',
                                           ),
                                       )
                                   )
        );
    }
endif;

function _ferret_customize_partial_blogname()
{
    bloginfo('name');
}

function _ferret_customize_partial_blogdescription()
{
    bloginfo('description');
}

// Sanitize SEO keywords input
function _ferret_sanitize_seo_keywords( $input )
{
    return esc_attr($input);
}

// Sanitize SEO description input
function _ferret_sanitize_seo_description( $input )
{
    return esc_attr($input);
}

// End more customization options
function _ferret_create_title_tag()
{
    echo '<title>';
    if ( is_front_page() ) {
        bloginfo('name');
        echo ' - ';
        bloginfo('description');
    } else {
        if ( function_exists('is_tag') && is_tag() ) {
            echo __('Tag Archive for') . ' &quot;' . $tag . '&quot; - ';
        } elseif ( is_archive() ) {
            wp_title('');
            echo __('Archive') . ' - ';
        } elseif ( is_search() ) {
            echo __('Search for') . '  &quot;' . wp_specialchars($s) . '&quot; - ';
        } elseif ( !(is_404()) && (is_single()) || (is_page()) ) {
            wp_title('');
            echo ' - ';
        } elseif ( is_404() ) {
            echo __('Not Found') . ' - ';
        } else {
            bloginfo('name');
        }
    }
    echo '</title>' . "\n";
}


function _ferret_create_seo_meta()
{
    global $post;
    $blogname = get_bloginfo('name');
    $blogdescription = get_bloginfo('description');
    $keywords = get_theme_mod("seo_keywords", $blogname);
    $description = get_theme_mod("seo_description", $blogdescription);

    if ( !is_front_page() ) {
        if ( $post->post_excerpt ) {
            $description = $post->post_excerpt;
        } else {
            $description = $blogdescription;
        }

        if ( function_exists('is_product') and is_product() ) { // Addd product tags if this page is a woocommerce product page
            $product_tags = get_the_terms($product->ID, 'product_tag');
            foreach ( $product_tags as $product_tag ) {
                $keywords = $keywords . $product_tag->name . ', ';
            }
        } else { // Not a product page
            $tags = wp_get_post_tags($post->ID);
            foreach ( $tags as $tag ) {
                $keywords = $keywords . $tag->name . ', ';
            }
        }
        $keywords = $keywords . $blogname;
        $description = $description . $blogdescription;
    }
    print_r('<meta name="keywords" content="' . $keywords . '">' . "\n");
    print_r("\t" . '<meta name="description" content="' . $description . '">' . "\n");
}

class _ferret_format_wp_head
{
    /**
     * Start the output buffer.
     */
    static function open()
    {
        ob_start();
    }

    /**
     * Get the contents of the buffer and spring clean.
     */
    static function stop()
    {
        $lines = [];

        foreach ( preg_split('/[\n\r]+/', ob_get_clean()) as $line ) {
            if ( trim($line) !== '' ) {
                if ( strpos($_line = ltrim($line), '<') !== 0 ) {
                    $_line = $line;
                }

                $lines[] = $_line;
            }
        }

        echo "\t" . implode("\n\t", $lines) . "\n";
    }
}

function _ferret_widget_default_view( $input )
{
    return esc_attr($input);
}