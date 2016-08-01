<?php
/**
 * Profile X
 * 
 */

$owner = get_input('owner_guid');
$bg = get_input('bg');
$profilex_minimal = unserialize(elgg_get_plugin_user_setting('profilex_minimal', $owner, 'profile_x'));
$array = array('bg' => $bg);

elgg_set_plugin_user_setting('profilex_minimal', serialize($array), $owner, 'profile_x');

echo json_encode(
	array(
		'bg_url' => $bg['url'],
		'bg_color' => $bg['color']
	)
);