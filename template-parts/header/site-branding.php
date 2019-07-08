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
                <?php the_custom_logo(); ?>
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
