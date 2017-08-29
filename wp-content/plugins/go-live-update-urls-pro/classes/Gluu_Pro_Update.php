<?php
//define('CHECK_VERSION', true);


/**
 * Main Update Class
 *
 * @author Mat Lipe <mat@matlipe.com>
 *
 */
class GLuu_Pro_Update{

	public $api_url = 'https://matlipe.com/plugins/';
	public $plugin_slug = 'go-live-update-urls-pro';

	function __construct() {
		add_filter('pre_set_site_transient_update_plugins', array( $this, 'checkForUpdate' ));
		add_filter('plugins_api', array( $this, 'plugin_api_call'), 10, 3);

		if( defined('CHECK_VERSION') ){
			set_site_transient('update_plugins', null);
		}
	}


	/**
	 * Checks our custom location for an available update
	 *
	 * @uses added to the pre_set_site_transient_update_plugins filter by self::__construct();
	 */
	function checkForUpdate($checked_data) {
		global $wp_version;

		#Comment these two lines out during testing
		if (empty($checked_data->checked))
			return $checked_data;

		$args = array(
			'slug' => $this->plugin_slug,
			'version' => $checked_data->checked[$this->plugin_slug . '/' . $this->plugin_slug . '.php'],
		);
		$request_string = array(
			'body' => array(
				'action' => 'basic_check',
				'request' => serialize($args),
				'api-key' => md5(get_bloginfo('url'))
			),
			'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
		);

		// Start checking for an update
		$raw_response = wp_remote_post($this->api_url, $request_string);
		if (!is_wp_error($raw_response) && ($raw_response['response']['code'] == 200))
			$response = unserialize($raw_response['body']);

		if (is_object($response) && !empty($response))// Feed the update data into WP updater
			$checked_data->response[$this->plugin_slug . '/' . $this->plugin_slug . '.php'] = $response;

		return $checked_data;
	}


	/**
	 * switch the api call to the custom location
	 *
	 * @since 1.0
	 *
	 * @uses added to the 'plugins_api' filter by self::__construct()
	 */
	function plugin_api_call($def, $action, $args) {
		global $wp_version;
		if ( empty( $this->plugin_slug ) || empty($args->slug) || $args->slug != $this->plugin_slug)
			return false;

		// Get the current version
		$plugin_info = get_site_transient('update_plugins');
		$current_version = $plugin_info->checked[$this->plugin_slug .'/'. $this->plugin_slug .'.php'];
		$args->version = $current_version;

		$request_string = array(
			'body' => array(
				'action' => $action,
				'request' => serialize($args),
				'api-key' => md5(get_bloginfo('url'))
			),
			'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
		);

		$request = wp_remote_post($this->api_url, $request_string);

		if (is_wp_error($request)) {
			$res = new WP_Error('plugins_api_failed', __('An Unexpected HTTP Error occurred during the API request.</p> <p><a href="?" onclick="document.location.reload(); return false;">Try again</a>'), $request->get_error_message());
		} else {
			$res = unserialize($request['body']);

			if ($res === false)
				$res = new WP_Error('plugins_api_failed', __('An unknown error occurred'), $request['body']);
		}

		return $res;
	}

}

new Gluu_Pro_Update();