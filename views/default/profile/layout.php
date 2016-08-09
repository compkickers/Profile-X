<?php
/**
 * Profile layout
 * 
 * @uses $vars['entity']  The user
 */

elgg_require_js('profile_x/hello');
elgg_register_css('profilex-css', 'mod/profile_x/views/default/css/profile_x/css.css');
elgg_load_css('profilex-css');
elgg_load_js('lightbox');
elgg_load_css('lightbox');
elgg_register_js('liteuploader', 'mod/imgur/vendor/liteuploader.js');
elgg_load_js('liteuploader');
$entity = get_entity(elgg_get_page_owner_guid());
$access = $entity->canEdit();
$profilex_themes = unserialize(elgg_get_plugin_user_setting('profilex_theme', elgg_get_page_owner_guid(), 'profile_x'));

// Output the Profile X containers
elgg_extend_view('page/default', 'profile_x/container');
elgg_extend_view('page/default', 'profile_x/message');
elgg_extend_view('page/elements/html', 'profile_x/preload', 0);

if ($access) {
	elgg_register_menu_item('topbar', array(
		'name' => 'profilex',
		'text' => 'Profile X',
		'href' => "#profilex",
		'priority' => 10,
		'section' => 'alt',
		'id' => 'profilex-init'
	));
}
if ($profilex_themes) {
	foreach ($profilex_themes as $value) {
		if (in_array('1', $value)) {
			if ($value['theme'] != 'default') {
				echo elgg_view('profile_x/themes/' . $value['theme'] . '/' . $value['theme']);
			}
			else {
				// main profile page
				$params = array(
					'content' => elgg_view('profile/wrapper'),
					'num_columns' => 3,
				);
				echo elgg_view_layout('widgets', $params);
				break;
			}
		}
	}
}
else {
	// main profile page
	$params = array(
		'content' => elgg_view('profile/wrapper'),
		'num_columns' => 3,
	);
	echo elgg_view_layout('widgets', $params);
}