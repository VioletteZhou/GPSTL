<?php
/**
 * Upgrade Control for the Customizer
 *
 * @package Donovan
 */

/**
 * Make sure that custom controls are only defined in the Customizer
 */
if ( class_exists( 'WP_Customize_Control' ) ) :

	/**
	 * Displays the upgrade teasers in thhe Pro Version / More Features section.
	 */
	class Donovan_Customize_Upgrade_Control extends WP_Customize_Control {
		/**
		 * Render Control
		 */
		public function render_content() {
			?>

			<div class="upgrade-pro-version">

				<span class="customize-control-title"><?php esc_html_e( 'Pro Version Add-on', 'donovan' ); ?></span>

				<span class="textfield">
					<?php printf( esc_html__( 'Purchase the %s Pro Add-on to get additional features and advanced customization options.', 'donovan' ), 'Donovan' ); ?>
				</span>

				<p>
					<a href="<?php echo esc_url( __( 'https://themezee.com/addons/donovan-pro/', 'donovan' ) ); ?>?utm_source=customizer&utm_medium=button&utm_campaign=donovan&utm_content=pro-version" target="_blank" class="button button-secondary">
						<?php printf( esc_html__( 'Learn more about %s Pro', 'donovan' ), 'Donovan' ); ?>
					</a>
				</p>

			</div>

			<div class="upgrade-plugins">

				<span class="customize-control-title"><?php esc_html_e( 'Recommended Plugins', 'donovan' ); ?></span>

				<span class="textfield">
					<?php esc_html_e( 'Extend the functionality of your WordPress website with our free and easy to use plugins.', 'donovan' ); ?>
				</span>

				<p>
					<a href="<?php echo esc_url( admin_url( 'plugin-install.php?tab=search&type=author&s=themezee' ) ); ?>" class="button button-secondary">
						<?php esc_html_e( 'Install Plugins', 'donovan' ); ?>
					</a>
				</p>

			</div>

			<?php
		}
	}

endif;
