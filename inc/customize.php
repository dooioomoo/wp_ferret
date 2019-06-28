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
function _ferret_customize_register( $wp_customize )
{
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
                          'description' => __('SEO keywords mainly for the frontpage, separated by comma', 'twentyseventeen'),
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
    print_r("\t".'<meta name="description" content="' . $description . '">' . "\n");
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