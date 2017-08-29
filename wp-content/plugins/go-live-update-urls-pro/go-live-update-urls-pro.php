<?php
/*
Plugin Name: Go Live Update URLS Pro
Plugin URI: https://matlipe.com/go-live-update-urls-pro/
Description: Make Go Live Update URLS smarter and easier to use.
Author: Mat Lipe
Author URI: https://matlipe.com/
Version: 1.2.1
*/

function gluup_load(){
	if( !is_admin() && !defined( 'WP_TESTS_DIR' ) ) return;

	load_plugin_textdomain('gluu', false, 'go-live-update-urls-pro/languages');

	if( !defined( 'GLUU_VERSION' ) ){
		add_action('admin_notices', 'gluu_need_base_plugin' );
		return;
	}

	$path = plugin_dir_path( __FILE__ );

	require( $path . '/classes/Gluu_Pro_Update.php' );
	require( $path . '/classes/Gluu_Pro.php' );
	require( $path . '/classes/Gluu_Pro_Checkboxes.php' );
	require( $path . '/classes/Gluu_Serialized.php' );

	Gluu_Pro::init();

}

add_action('plugins_loaded', 'gluup_load', 1 );


function gluu_need_base_plugin(){
	?>
	<div id="message" class="error">
		<p>
			<?php _e( 'Go Live Update Urls Pro requires the Go Live Update Urls plugin of version 2.5.0 or newer.', 'gluu' ); ?>
			<a href="https://wordpress.org/plugins/go-live-update-urls/">https://wordpress.org/plugins/go-live-update-urls/</a>
		</p>
	</div>
	<?php
}