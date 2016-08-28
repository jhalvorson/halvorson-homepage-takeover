<?php

/*
Plugin Name: Halvorson Homepage Takeover
Plugin URI: http://halvorson.digital
Description: Display a simple modal popup on your homepage
Version: 0.1
Author: Halvorson Digital
Author URI: http://halvorson.digital
License: GPL2
*/

add_action('wp_enqueue_scripts', 'halvorson_homepage_takeover_assets');

function halvorson_homepage_takeover_assets() {
	wp_enqueue_script( 'js.cookie.js', plugin_dir_url( __FILE__ ) . 'assets/js.cookie.js', '1.0', true);
	wp_enqueue_script( 'modal', plugin_dir_url( __FILE__ ) . 'assets/jquery.modal.min.js',  array('jquery'), '1.0', true);
	wp_enqueue_script( 'main', plugin_dir_url( __FILE__ ) . 'assets/main.js', array( 'jquery' ), '1.0', true );
	wp_enqueue_style( 'styles', plugin_dir_url( __FILE__ ) . 'assets/style.css', '1.0', true );
}

add_action('wp_head', 'halvorson_homepage_takeover');
function halvorson_homepage_takeover() {
	if( is_front_page() ) {
		echo ' <div class="takeover-modal"><a href="'. esc_attr( get_option('modal_url') ) .'"><img src="'. esc_attr( get_option('modal_image') ) .'"></a></div>';
	}
}

add_action('admin_menu', 'halvorson_homepage_takeover_menu');

function halvorson_homepage_takeover_menu() {
	add_menu_page('Homepage Takeover Settings', 'Page Takeover', 'administrator', 'halvorson-homepage-takeover-settings', 'halvorson_homepage_takeover_settings_page', 'dashicons-admin-generic');
}

function halvorson_homepage_takeover_settings_page() { ?>

	<div class="wrap">

		<h1><?php esc_attr_e( 'Homepage Takeover', 'halvorson_homepage_takeover' ); ?></h1>

		<div id="poststuff">

			<div id="post-body" class="metabox-holder columns-2">

				<!-- main content -->
				<div id="post-body-content">

					<div class="meta-box-sortables ui-sortable">

						<div class="postbox">

							<div class="inside">

								<form method="post" action="options.php">
									<?php settings_fields( 'halvorson-homepage-takeover-settings-group' ); ?>
									<?php do_settings_sections( 'halvorson-homepage-takeover-settings-group' ); ?>
									<table class="form-table">
										<tr valign="top">
											<th scope="row">Modal URL</th>
											<td>
												<input type="url" name="modal_url" class="regular-text" value="<?php echo esc_attr( get_option('modal_url') ); ?>"/><br>
											</td>
										</tr>

										<tr valign="top">
											<th scope="row">Modal Background Image</th>
											<td><input type="text" name="modal_image" class="regular-text" value="<?php echo esc_attr( get_option('modal_image') ); ?>" /></td>
										</tr>
										
									</table>

									<?php submit_button(); ?>

								</form>

							</div>
							<!-- .inside -->

						</div>
						<!-- .postbox -->

					</div>
					<!-- .meta-box-sortables .ui-sortable -->



					<div class="meta-box-sortables ui-sortable">

						<table class="widefat">
							<tr>
								<th class="row-title"><?php esc_attr_e( 'Development Plan', 'halvorson_homepage_takeover' ); ?></th>
								<th><?php esc_attr_e( 'Release Number', 'halvorson_homepage_takeover' ); ?></th>
							</tr>
							<tr>
								<td class="row-title"><label for="tablecell"><?php esc_attr_e(
											'Add option to open in new tab', 'halvorson_homepage_takeover'
										); ?></label></td>
								<td><?php esc_attr_e( '0.2', 'halvorson_homepage_takeover' ); ?></td>
							</tr>
							<tr class="alternate">
								<td class="row-title"><label for="tablecell"><?php esc_attr_e(
											'Allow admin to control delay', 'halvorson_homepage_takeover'
										); ?></label></td>
								<td><?php esc_attr_e( '0.2', 'halvorson_homepage_takeover' ); ?></td>
							</tr>
							<tr>
								<td class="row-title"><label for="tablecell"><?php esc_attr_e(
											'Add drag and drop image selector', 'halvorson_homepage_takeover'
										); ?></label></td>
								<td><?php esc_attr_e( '0.2', 'halvorson_homepage_takeover' ); ?></td>
							</tr>
							<tr class="alternate">
								<td class="row-title"><label for="tablecell"><?php esc_attr_e(
											'Add option to either upload an image or use text', 'halvorson_homepage_takeover'
										); ?></label></td>
								<td><?php esc_attr_e( '0.3', 'halvorson_homepage_takeover' ); ?></td>
							</tr>
							<tr>
								<td class="row-title"><label for="tablecell"><?php esc_attr_e(
											'Add feedback form', 'halvorson_homepage_takeover'
										); ?></label></td>
								<td><?php esc_attr_e( '0.4', 'halvorson_homepage_takeover' ); ?></td>
							</tr>
						</table>

					</div>
					<!-- .meta-box-sortables .ui-sortable -->

				</div>
				<!-- post-body-content -->

				<!-- sidebar -->
				<div id="postbox-container-1" class="postbox-container">

					<div class="meta-box-sortables">

						<div class="postbox">

							<h2><span><?php esc_attr_e(
										'About Homepage Takeover', 'halvorson_homepage_takeover'
									); ?></span></h2>

							<div class="inside">
								<p><?php esc_attr_e(
										'This plugin has been developed for Scottish Golf by Halvorson Digital. We look to open source this plugin in the future so your feedback would be greatly appreciated.',
										'halvorson_homepage_takeover'
									); ?></p>
								<p><?php esc_attr_e(
										'Please do note that this plugin is in BETA. Do not use beyond Scottish Golf.',
										'halvorson_homepage_takeover'
									); ?></p>
								<p><?php esc_attr_e(
										'&copy; Copyright Jamie Halvorson',
										'halvorson_homepage_takeover'
									); ?></p>
							</div>
							<!-- .inside -->

						</div>
						<!-- .postbox -->

					</div>
					<!-- .meta-box-sortables -->

				</div>
				<!-- #postbox-container-1 .postbox-container -->

			</div>
			<!-- #post-body .metabox-holder .columns-2 -->

			<br class="clear">
		</div>
		<!-- #poststuff -->

	</div> <!-- .wrap -->

<?php }

add_action( 'admin_init', 'halvorson_homepage_takeover_settings');

function halvorson_homepage_takeover_settings() {
	register_setting( 'halvorson-homepage-takeover-settings-group', 'modal_url' );
	register_setting( 'halvorson-homepage-takeover-settings-group', 'modal_image' );
}