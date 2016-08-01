<?php
/**
 * Profile X
 * 
 */

$profilex_classic = unserialize(elgg_get_plugin_user_setting('profilex_classic', elgg_get_page_owner_guid(), 'profile_x'));

$owner_guid = elgg_get_page_owner_guid();

if ($owner_guid) {
	$entity = get_entity($owner_guid);
}
else {
	$entity = get_entity(get_input('owner_guid'));
}

$intro = '';
$intro_edit = '';
$intro_button = '';
$access_briefdescription = '';

$briefdescription_access_id = elgg_get_metadata(array(
	'guid' => $owner_guid,
	'metadata_name' => 'briefdescription',
	'limit' => false
));

$access = $entity->canEdit();
$intro_input = elgg_view('input/plaintext', array(
	'name' => 'briefdescription',
	'value' => $intro,
	'class' => 'hidden'
));

if ($briefdescription_access_id[0]['access_id']) {
	$intro = $entity->briefdescription;
}

if ($access) {
	$intro_edit = '<i class="fa fa-pencil" id="profilex-classic-activity-intro-edit"></i>';
	$intro_button = elgg_view('input/button', array(
		'value' => elgg_echo('profilex:save'),
		'class' => 'elgg-button-submit hidden',
		'id' => 'profilex-classic-activity-intro-save'
	));
	$access_briefdescription = elgg_view('input/access', [
		'name' => 'accesslevel[briefdescription]',
		'value' => $briefdescription_access_id[0]['access_id'],
		'class' => 'hidden mtm float-alt profilex-classic-briefdescription-access'
	]);
}

$lang_title = elgg_echo('profilex:classic:intro:title');

echo <<<HTML
	<ul>
		<li class="edit">
			<i class="fa fa-globe"></i><h3>$lang_title</h3>
			$intro_edit
		</li>
		<li class="intro">
			<p>$intro</p>	
			$intro_input
		</li>
		<li class="save">
			$intro_button
			$access_briefdescription
		</li>
	</ul>
HTML;


