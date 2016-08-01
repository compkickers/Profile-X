<?php
/**
 * Profile X
 * 
 */

elgg_require_js('profile_x/minimal/minimal');
elgg_register_css('profilex-minimal', 'mod/profile_x/views/default/css/profile_x/minimal.css');
elgg_load_css('profilex-minimal');
elgg_register_js('colorpicker', 'mod/profile_x/vendor/colorpicker/js/colorpicker.js');
elgg_load_js('colorpicker');
elgg_register_css('colorpicker', 'mod/profile_x/vendor/colorpicker/css/colorpicker.css');
elgg_load_css('colorpicker');
elgg_extend_view('page/elements/topbar', 'profile_x/themes/minimal/topbar', 0);

$profilex_minimal = unserialize(elgg_get_plugin_user_setting('profilex_minimal', elgg_get_page_owner_guid(), 'profile_x'));

$entity = get_entity(elgg_get_page_owner_guid());
$access = $entity->canEdit();
$icon = $entity->getIconURL('large');
$name = $entity->name;
$brief = $entity->briefdescription;
$add = elgg_view('input/button', array(
	'value' => 'Add Friend',
	'class' => 'elgg-button',
	'id' => 'profilex-minimal-add'
));
if (elgg_get_page_owner_guid() != elgg_get_logged_in_user_guid()) {
	$message = elgg_view('input/button', array(
		'value' => elgg_echo('profilex:message'),
		'class' => 'elgg-button',
		'id' => 'profilex-message'
	));
}
$bg_url = $profilex_minimal['bg']['url'];
$bg_color = $profilex_minimal['bg']['color'];
$font = $profilex_minimal['bg']['font'];
$friend = elgg_get_page_owner_guid();
$friend_add = '';
$friend_remove = '';

// Checks if you are friends with the user
if (elgg_is_logged_in() && get_entity(elgg_get_logged_in_user_guid())->isFriendsWith($friend)) {
	if (elgg_get_page_owner_guid() != elgg_get_logged_in_user_guid()) {
		$friend_remove = elgg_view('input/button', array(
			'value' => elgg_echo('profilex:minimal:unfriend'),
			'data-id' => $friend,
			'class' => 'elgg-button',
			'id' => 'profilex-minimal-remove',
		));
		$friend_add = elgg_view('input/button', array(
			'value' => elgg_echo('profilex:minimal:addfriend'),
			'data-id' => $friend,
			'class' => 'elgg-button hidden',
			'id' => 'profilex-minimal-add',
		));
	}
}
else {
	if (elgg_get_page_owner_guid() != elgg_get_logged_in_user_guid()) {
		$friend_remove = elgg_view('input/button', array(
			'value' => elgg_echo('profilex:minimal:unfriend'),
			'data-id' => $friend,
			'class' => 'elgg-button hidden',
			'id' => 'profilex-minimal-remove',
		));
		$friend_add = elgg_view('input/button', array(
			'value' => elgg_echo('profilex:minimal:addfriend'),
			'data-id' => $friend,
			'class' => 'elgg-button',
			'id' => 'profilex-minimal-add',
		));
	}
}
$friends = $friend_add . $friend_remove;
if ($access) {
	elgg_extend_view('page/default', 'profile_x/themes/minimal/settings');
	elgg_register_menu_item('topbar', array(
		'name' => 'profilex_minimal_settings',
		'text' => 'Settings',
		'href' => "#profilex-minimal-settings",
		'priority' => 10,
		'section' => 'alt',
		'id' => 'profilex-minimal-settings'
	));
}

//echo '<pre>';
//var_export($profilex_minimal);
//echo '</pre>';

echo <<<HTML
	<div class="profilex-minimal-container">
		<h1 class="profilex-minimal-name">$name</h1>
		<div class="profilex-minimal-avatar" style="background-image: url($icon)"></div>
		<div class="profilex-minimal-brief">$brief</div>
		<div class="profilex-minimal-user">
			$friends $message
		</div>
	</div>
	<style>
		body, .profilex-minimal-background {
			background-color: #$bg_color;
			background-image: url($bg_url);
		}
		.profilex-minimal-user input, .profilex-minimal-user input:hover {
			background: #$bg_color;
			border-color: #$bg_color;
		}
		.profilex-minimal-background-actions i {
			background: #$bg_color;
		}
		.profilex-minimal-name, .profilex-minimal-brief {
			color: #$font;
		}
	</style>
HTML;


