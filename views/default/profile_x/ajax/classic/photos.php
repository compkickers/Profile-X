<?php
/**
 * Profile X
 * 
 */

$owner_guid = get_input('owner_guid');
$profilex_classic = unserialize(elgg_get_plugin_user_setting('profilex_classic', $owner_guid, 'profile_x'));
$entity = get_entity($owner_guid);

$photo_edit = '';
$photo_add = '';
$photo_temp = '';
$photo_item = '';
$photo_button = '';

$access = $entity->canEdit();
$photos = $profilex_classic['photos'];

if ($access) {
	$photo_edit = '<i class="fa fa-pencil" id="profilex-classic-activity-photos-edit"></i>';
	$photo_add = '<i class="fa fa-plus hidden" id="profilex-classic-photos-add"></i>';
	$photo_temp = elgg_view('input/file', array(
		'name' => 'profilex_classic_photo',
		'class' => 'hidden'
	));
	$photo_item = elgg_view('input/text', array(
		'name' => 'profilex_classic_photo_item',
		'value' => '',
		'class' => 'hidden'
	));
	$photo_button = elgg_view('input/button', array(
		'value' => elgg_echo('profilex:save'),
		'class' => 'elgg-button-submit hidden',
		'id' => 'profilex-classic-activity-photos-save'
	));
}

$lang_title = elgg_echo('profilex:classic:photos:title');

echo <<<HTML
	<i class="fa fa-picture-o"></i><h3>$lang_title</h3>
	$photo_edit $photo_add
	<ul id="grid">
HTML;

if ($photos != '0') {
	foreach ($photos as $photo) {
		echo '<li data-id="" style="background-image: url('.$photo.')"><i class="fa fa-minus-circle hidden"></i><a href="'.$photo.'" class="elgg-lightbox"></a></li>';
	}
}

echo <<<HTML
	</ul>
	$photo_temp
	$photo_item
	$photo_button
	<i class="fa fa-spinner fa-spin profilex-classic-photo-loader hidden"></i>
HTML;


