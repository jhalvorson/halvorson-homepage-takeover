<?php

/*
Plugin Name: Homepage Takeover
Plugin URI: http://halvorson.co.uk/plugins
Description: Display a simple modal popup on your homepage
Version: 0.2
Author: Jamie Halvorson
Author URI: http://halvorson.co.uk
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

		if( !esc_attr( get_option('deactivate_homepage_takeover') ) == '1' ) {

		//Check if we are to open in new tab
		if(esc_attr( get_option('open_in_new_tab') ) == '1'){
			$newTab = '_blank';
		} else {
			$newTab = '_self';
		}

		if(esc_attr( get_option('deactivate_cookies') ) == '1'){
			echo '<script type="text/javascript">
			 jQuery(window).load(function(){
			     setTimeout(function(){
			         jQuery(".takeover-modal").modal({
			             fadeDuration: 100
			         });
			     }, 3000);
			 });
			 </script>';
		} else {
			$days = esc_attr( get_option('modal_days') );
			echo '<script type="text/javascript">';
			echo 'jQuery(document).ready(function() {';
			echo  'if (Cookies.get(\'modal_shown\') == null) {';
			echo 'Cookies.set(\'modal_shown\', \'yes\', { expires:';
			if( $days ){ echo $days; } else { echo '3'; }
			echo ', path: \'/\' });
	             setTimeout(function(){
	                 jQuery(".takeover-modal").modal({
	                     fadeDuration: 100
	                 });
	                 }, 3000);
		         }
		     });
				</script>';
		}

		if(esc_attr( get_option('deactivate_homepage_takeover') ) == '1'){
			null;
		} else {
			echo '<div class="takeover-modal">
 					<a target="'. $newTab .'" href="'. esc_attr( get_option('modal_url') ) .'"><img src="'. esc_attr( get_option('modal_image') ) .'"></a>
 		    </div>';

		}

	}

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
												<input type="url" name="modal_url" class="regular-text" value="<?php echo esc_url( get_option('modal_url') ); ?>"/><br>
											</td>
										</tr>

										<tr valign="top">
											<th scope="row">Modal Background Image
											<br>
											<p class="description"><?php esc_attr_e('690px x 690px image.', 'halvorson_homepage_takeover');?></p>
											</th>
											<td><input type="text" name="modal_image" class="regular-text" value="<?php echo esc_attr( get_option('modal_image') ); ?>" /></td>
										</tr>

										<tr valign="top">
											<th scope="row">When to display the modal
											<br>
											<p class="description"><?php esc_attr_e('For example: if you set it to 3, then the modal will show every 3 days.', 'halvorson_homepage_takeover');?></p>
											</th>
											<td><input type="text" placeholder="3" name="modal_days" class="regular-text" value="<?php echo esc_attr( get_option('modal_days') ); ?>" /></td>
										</tr>

									</table>

									<hr />

									<h2 class="h2"><?php esc_attr_e( 'Options', 'halvorson_homepage_takeover' ); ?></h2>

									<table class="form-table">
										<tr valign="top">
											<th scope="row">Open in a new tab<br>
											<p class="description"><?php esc_attr_e('Would you like the link to open in a new tab? If not, then leave the box unchecked', 'halvorson_homepage_takeover');?></p>
											</th>
											<td>
												<fieldset>
													<legend class="screen-reader-text"><span>Open in new tab?</span></legend>
													<label for="open_in_new_tab">
														<?php $options =  get_option( 'open_in_new_tab'); ?>
														<input name="open_in_new_tab" type="checkbox" id="open_in_new_tab" value="1" <?php checked( 1, get_option( 'open_in_new_tab'), true ); ?> />
														<span><?php esc_attr_e( 'Open in new tab', 'halvorson_homepage_takeover' ); ?></span>
													</label>
												</fieldset>
											</td>
										</tr>

										<tr valign="top">
											<th scope="row">Deactivate Cookies?<br>
												<p class="description"><?php esc_attr_e('Check this box to deactivate cookies', 'halvorson_homepage_takeover');?></p>
											</th>
											<td>
												<fieldset>
													<legend class="screen-reader-text"><span>Open in new tab?</span></legend>
													<label for="deactivate_cookies">
														<input name="deactivate_cookies" type="checkbox" id="deactivate_cookies" value="1" <?php checked( 1, get_option( 'deactivate_cookies'), true ); ?> />
														<span><?php esc_attr_e( 'Deactivate Cookies', 'halvorson_homepage_takeover' ); ?></span>
													</label>
												</fieldset>
											</td>
										</tr>

										<tr valign="top">
											<th scope="row">Deactivate Homepage Takeover?<br>
											<p class="description"><?php esc_attr_e( 'Would you like to deactivate Homepage Takeover?', 'halvorson_homepage_takeover' ); ?></p>
											</th>
											<td>
												<fieldset>
													<legend class="screen-reader-text"><span>Deactivate Modal</span></legend>
													<label for="deactivate_homepage_takeover">
														<input name="deactivate_homepage_takeover" type="checkbox" id="deactivate_homepage_takeover" value="1" <?php checked( 1, get_option( 'deactivate_homepage_takeover'), true ); ?> />
														<span><?php esc_attr_e( 'Deactivate Modal', 'halvorson_homepage_takeover' ); ?></span>
													</label>
												</fieldset>
											</td>
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
										'Please do note that this plugin is in BETA. Any feedback would be greatly appreciated.',
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
	register_setting( 'halvorson-homepage-takeover-settings-group', 'open_in_new_tab' );
	register_setting( 'halvorson-homepage-takeover-settings-group', 'deactivate_homepage_takeover' );
	register_setting( 'halvorson-homepage-takeover-settings-group', 'deactivate_cookies' );
	register_setting( 'halvorson-homepage-takeover-settings-group', 'modal_days' );
}
