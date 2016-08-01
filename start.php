<?php
/**
 * Profile X initialize
 * 
 */

elgg_register_event_handler('init', 'system', 'profile_x_init');

function profile_x_init() {
	// Register the general ajax views
	elgg_register_ajax_view('profile_x/ajax/init');
	elgg_register_ajax_view('profile_x/ajax/themes');

	// Ajax views for classic theme
	elgg_register_ajax_view('profile_x/ajax/classic/container');
	elgg_register_ajax_view('profile_x/ajax/classic/imgur');
	elgg_register_ajax_view('profile_x/ajax/classic/info');
	elgg_register_ajax_view('profile_x/ajax/classic/activity');
	elgg_register_ajax_view('profile_x/ajax/classic/classic');
	elgg_register_ajax_view('profile_x/ajax/classic/photos');
	elgg_register_ajax_view('profile_x/ajax/classic/feed');
	elgg_register_ajax_view('profile_x/ajax/classic/about');
	elgg_register_ajax_view('profile_x/ajax/classic/messageboard');
	elgg_register_ajax_view('profile_x/ajax/classic/mb');
	elgg_register_ajax_view('profile_x/ajax/classic/friends');
	elgg_register_ajax_view('profile_x/ajax/classic/friends_offset');

	// Ajax views for minimal theme
	elgg_register_ajax_view('profile_x/ajax/minimal/minimal');
	elgg_register_ajax_view('profile_x/ajax/minimal/imgur');

	if (elgg_get_context() == 'profile') {
		// Output the Profile X containers
		elgg_extend_view('page/default', 'profile_x/container');
		elgg_extend_view('page/default', 'profile_x/message');
		elgg_extend_view('page/elements/html', 'profile_x/preload', 0);

		// Set default values
		$profilex_themes = elgg_get_plugin_user_setting('profilex_theme', elgg_get_logged_in_user_guid(), 'profile_x');
		$profilex_classic = elgg_get_plugin_user_setting('profilex_classic', elgg_get_logged_in_user_guid(), 'profile_x');
		$profilex_minimal = elgg_get_plugin_user_setting('profilex_minimal', elgg_get_logged_in_user_guid(), 'profile_x');
		$themes_array = array(
			array('theme' => 'default', 'status' => '1'),
			array('theme' => 'classic', 'status' => '0'),
			array('theme' => 'minimal', 'status' => '0')
		);
		$classic_array = array(
			'cover' => array(
					'cover_url' => '',
					'cover_position' => '',
				), 
			'photos' => '0'
		);
		if (!$profilex_themes) {
			elgg_set_plugin_user_setting('profilex_theme', serialize($themes_array), elgg_get_logged_in_user_guid(), 'profile_x');
		}
		if (!$profilex_classic) {
			elgg_set_plugin_user_setting('profilex_classic', serialize($classic_array), elgg_get_logged_in_user_guid(), 'profile_x');
		}
		if (!$profilex_minimal) {
			elgg_set_plugin_user_setting('profilex_minimal', serialize(array()), elgg_get_logged_in_user_guid(), 'profile_x');
		}
	}
}