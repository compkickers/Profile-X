<?php
/**
 * Profile X
 * 
 */

$owner = get_input('owner');
$profilex_themes = unserialize(elgg_get_plugin_user_setting('profilex_theme', $owner, 'profile_x'));
$array = array();

foreach ($profilex_themes as $value) {
	if (in_array('1', $value)) {
		$theme = $value['theme'];
	}
}

echo json_encode(
	array(
		'theme' => $theme,
	)
);