<?php
/**
 * Displays header site branding
 *
 * @subpackage _ferret
 */

?>
<div class="site-branding">
    <div class="wrap container">
        <div class="row">
            <div class="site-logo col-md-4">
                <?php
                $custom_logo_id = get_theme_mod('custom_logo_sp');
                if ( wp_is_mobile() && $custom_logo_id ):
                    $custom_logo_attr = array (
                        'class' => 'custom-logo custom-logo-sp' ,
                    );

                    /*
                     * If the logo alt attribute is empty, get the site title and explicitly
                     * pass it to the attributes used by wp_get_attachment_image().
                     */
                    $image_alt = get_post_meta($custom_logo_id , '_wp_attachment_image_alt' , TRUE);
                    if ( empty($image_alt) ) {
                        $custom_logo_attr['alt'] = get_bloginfo('name' , 'display');
                    }

                    /*
                     * If the alt attribute is not empty, there's no need to explicitly pass
                     * it because wp_get_attachment_image() already adds the alt attribute.
                     */
                    $html = sprintf(
                        '<a href="%1$s" class="custom-logo-link" rel="home">%2$s</a>' ,
                        esc_url(home_url('/')) ,
                        wp_get_attachment_image($custom_logo_id , 'full' , FALSE , $custom_logo_attr)
                    );
                    echo $html;
                else:
                    the_custom_logo();
                endif;
                ?>
            </div>
            <div class="col-md-8">
                <div class="site-branding-text">
                    <?php if(!is_active_sidebar('header-sidebar')):?>
                    <?php if ( _ferret_is_frontpage() ) : ?>
                        <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"
                                                  rel="home"><?php bloginfo('name'); ?></a></h1>
                    <?php else : ?>
                        <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"
                                                 rel="home"><?php bloginfo('name'); ?></a></h1>
                    <?php endif; ?>

                    <?php
                    $description = get_bloginfo('description', 'display');

                    if ( $description || is_customize_preview() ) :
                        ?>
                        <p class="site-description"><?php echo $description; ?></p>
                    <?php endif; ?>
                    <?php else:
                        dynamic_sidebar('header-sidebar');
                        ?>
                    <?php endif;?>
                </div><!-- .site-branding-text -->
            </div>
        </div>
    </div><!-- .wrap -->
</div><!-- .site-branding -->
