<?php
/**
 * Displays header site branding
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?>
<div class="site-branding">
    <div class="wrap">
        <div class="row">
            <div class="col-md-4">
                <?php the_custom_logo(); ?>
            </div>
            <div class="col-md-8">
                <div class="site-branding-text">
                    <?php if (_ferret_is_frontpage()) : ?>
                        <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"
                                                  rel="home"><?php bloginfo('name'); ?></a></h1>
                    <?php else : ?>
                        <p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"
                                                 rel="home"><?php bloginfo('name'); ?></a></p>
                    <?php endif; ?>

                    <?php
                    $description = get_bloginfo('description', 'display');

                    if ($description || is_customize_preview()) :
                        ?>
                        <p class="site-description"><?php echo $description; ?></p>
                    <?php endif; ?>
                </div><!-- .site-branding-text -->
            </div>
        </div>
    </div><!-- .wrap -->
</div><!-- .site-branding -->
