<?php
/**
 * Profile X
 * 
 */

elgg_require_js('profile_x/classic/classic');
elgg_register_css('profilex-classic', 'mod/profile_x/views/default/css/profile_x/classic.css');
elgg_load_css('profilex-classic');
elgg_register_js('drag', 'mod/profile_x/vendor/jquery-draggable-background/draggable_background.js');
elgg_load_js('drag');
elgg_extend_view('page/elements/topbar', 'profile_x/themes/classic/topbar');

$profilex_classic = unserialize(elgg_get_plugin_user_setting('profilex_classic', elgg_get_page_owner_guid(), 'profile_x'));
$message = '';
$friends = '';
$friend_add = '';
$friend_remove = '';
$cover = '';
$cover_option_save = '';
$cover_option_upload = '';
$cover_option_drag = '';
$cover_option_delete = '';
$cover_message = '';
$avatar = '';
$entity = get_entity(elgg_get_page_owner_guid());
$access = $entity->canEdit();
$cover_position = $profilex_classic['cover']['cover_position'];
$cover_url = $profilex_classic['cover']['cover_url'];
$icon = $entity->getIconURL('large');
$name = $entity->name;
$friend = elgg_get_page_owner_guid();
$cover_temp = elgg_view('input/file', array(
	'name' => 'profilex_cover',
	'class' => 'hidden'
));
$cover_url_hidden = elgg_view('input/text', array(
	'name' => 'profilex_cover_url',
	'value' => $cover_url,
	'class' => 'hidden'
));
$friend_counter = elgg_get_entities_from_relationship(array(
	'relationship' => 'friend',
	'relationship_guid' => elgg_get_page_owner_guid(),
	'inverse_relationship' => false,
	'type' => 'user',
	'count' => 'true',
));
if (elgg_get_page_owner_guid() != elgg_get_logged_in_user_guid()) {
	$message = elgg_view('input/button', array(
			'value' => 'Message',
			'data-id' => $friend,
		'class' => 'elgg-button-action',
		'id' => 'profilex-message'
	));
}

// Checks if you are friends with the user
if (elgg_is_logged_in() && get_entity(elgg_get_logged_in_user_guid())->isFriendsWith($friend)) {
	if (elgg_get_page_owner_guid() != elgg_get_logged_in_user_guid()) {
		$friend_remove = elgg_view('input/button', array(
			'value' => 'Unfriend',
			'data-id' => $friend,
			'class' => 'elgg-button-action',
			'id' => 'profilex-classic-remove',
		));
		$friend_add = elgg_view('input/button', array(
			'value' => 'Add Friend',
			'data-id' => $friend,
			'class' => 'elgg-button-action hidden',
			'id' => 'profilex-classic-add',
		));
	}
}
else {
	if (elgg_get_page_owner_guid() != elgg_get_logged_in_user_guid()) {
		$friend_remove = elgg_view('input/button', array(
			'value' => 'Unfriend',
			'data-id' => $friend,
			'class' => 'elgg-button-action hidden',
			'id' => 'profilex-classic-remove',
		));
		$friend_add = elgg_view('input/button', array(
			'value' => 'Add Friend',
			'data-id' => $friend,
			'class' => 'elgg-button-action',
			'id' => 'profilex-classic-add',
		));
	}
}
$friends = $friend_add . $friend_remove;
$lang_cover_update = '';

// Checks if user or admin can make edits
if ($access) {
	$cover = '<i class="fa fa-camera profilex-classic-cover-button"><p>'.elgg_echo('profilex:classic:cover:update').'</p></i>';
	$cover_option_save = elgg_view('input/button', array(
		'value' => elgg_echo('profilex:save'),
		'class' => 'elgg-button-submit',
		'id' => 'cover-option-save'
	));
	$cover_option_upload = elgg_view('input/button', array(
		'value' => elgg_echo('profilex:upload'),
		'class' => 'elgg-button-submit',
		'id' => 'cover-option-upload'
	));
	$cover_option_drag = elgg_view('input/button', array(
		'value' => elgg_echo('profilex:classic:cover:drag'),
		'class' => 'elgg-button-submit',
		'id' => 'cover-option-drag'
	));
	$cover_option_delete = elgg_view('input/button', array(
		'value' => elgg_echo('profilex:classic:cover:delete'),
		'class' => 'elgg-button-delete float-alt',
		'id' => 'cover-option-delete'
	));
	$cover_message = '<div class="profilex-classic-cover-message">'.elgg_echo('profilex:classic:cover:message').'</div>';
	$avatar = '<a href="'.elgg_get_site_url() . 'avatar/edit/' . $entity->username.'"><span class="profilex-classic-user-avatar" style="background-image: url('.$icon.')"></span></a>';
}
else {
	$avatar = '<span class="profilex-classic-user-avatar" style="background-image: url('.$icon.')"></span>';
}
if ($cover_url) {
	$cover_link = '<a href="'.$cover_url.'" class="profilex-classic-cover-link elgg-lightbox"></a>';
}
else {
	$cover_link = '<a href="#" class="profilex-classic-cover-link elgg-lightbox hidden"></a>';
}

// Show user actions only when logged in
if (elgg_is_logged_in()) {
$profilex_classic_user_actions = <<<HTML
	<ul class="profilex-classic-user-actions">
		<li>$friends</li>
		<li>$message</li>
	</ul>
HTML;
}

$lang_activity = elgg_echo('profilex:classic:menu:activity');
$lang_about = elgg_echo('profilex:classic:menu:about');
$lang_messageboard = elgg_echo('profilex:classic:menu:messageboard');
$lang_friends = elgg_echo('profilex:classic:menu:friends');

echo <<<HTML
	<div class="profilex-classic">
		<div class="profilex-classic-cover" style="background-image: url($cover_url); background-position: $cover_position"> $cover_link
			$cover $cover_message $cover_temp $cover_url_hidden
			$avatar
			<div class="profilex-classic-name">
				$name
			</div>
		</div>
		<div class="profilex-classic-cover-bottom">
			<div class="profilex-classic-cover-options">
				$cover_option_upload $cover_option_drag $cover_option_save $cover_option_delete
			</div>
			<div class="profilex-classic-user">
				<ul class="profilex-classic-user-menu">
					<li><a href="#activity" class="profilex-classic-user-activity profilex-classic-user-menu-active">$lang_activity</a></li>
					<li><a href="#about" class="profilex-classic-user-about">$lang_about</a></li>
					<li><a href="#message-board" class="profilex-classic-user-messageboard">$lang_messageboard</a></li>
					<li><a href="#friends" class="profilex-classic-user-friends">$lang_friends ($friend_counter)</a></li>
				</ul>
				$profilex_classic_user_actions
			</div>
		</div>
		<div class="profilex-classic-content">
		</div>
	</div>
HTML;
