<?php
/**
 * Profile X
 * 
 */

$owner = get_input('owner_guid');
$cover = get_input('cover');
$photos = get_input('photos');
$profilex_classic = unserialize(elgg_get_plugin_user_setting('profilex_classic', $owner, 'profile_x'));

if ($cover) {
	$cover_new = $cover;
}
else {
	$cover_new = $profilex_classic['cover'];
}
if (is_array($photos)) {
	$photos_new = $photos;
}
elseif ($photos == '0') {
	$photos_new = '0';
}
else {
	$photos_new = $profilex_classic['photos'];
}

$array = array('cover' => $cover_new, 'photos' => $photos_new);
elgg_set_plugin_user_setting('profilex_classic', serialize($array), $owner, 'profile_x');