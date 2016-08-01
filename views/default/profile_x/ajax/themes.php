<?php
/**
 * Profile X
 * 
 */

$profilex_themes = unserialize(elgg_get_plugin_user_setting('profilex_theme', elgg_get_page_owner_guid(), 'profile_x'));

$theme_input = get_input('theme');
$owner = get_input('owner');
$array = array();

foreach ($profilex_themes as $value) {
	if (in_array($theme_input, $value)) {
		$status = '1';
	}
	else {
		$status = '0';
	}
	$array[] = array_merge(
		array('theme' => $value['theme']), 
		array('status' => $status)
	);
	elgg_set_plugin_user_setting('profilex_theme', serialize($array), $owner, 'profile_x');
}