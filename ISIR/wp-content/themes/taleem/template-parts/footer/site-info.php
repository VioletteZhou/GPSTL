<?php
/**
 * Displays footer site info
 *
 * @package WordPress
 * @subpackage taleem
 * @since 1.0
 * @version 1.0
 */

?>
<div class="site-info">
	<small><?php echo taleem_get_copylight_credit() ?></small><br><!-- Theme taleem by GP Themes https://gpthemes.com -->
	<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'taleem' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'taleem' ), 'WordPress' ); ?></a>
</div><!-- .site-info -->
