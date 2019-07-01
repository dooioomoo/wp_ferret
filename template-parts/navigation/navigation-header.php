<?php
/**
 * _ferret' navigation
 * @package _ferret
 */
?>
<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Top Menu', '_ferret' ); ?>">
	<button class="menu-toggle" aria-controls="top-menu" aria-expanded="false">
		<?php
		echo _ferret_get_svg( array( 'icon' => 'bars' ) );
		echo _ferret_get_svg( array( 'icon' => 'close' ) );
		_e( 'Menu', '_ferret' );
		?>
	</button>

	<?php wp_nav_menu( array(
		'theme_location' => 'top',
		'menu_id'        => 'top-menu',
	) ); ?>

</nav><!-- #site-navigation -->