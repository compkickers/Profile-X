<?php
/**
 * Profile X
 * 
 */

$owner_guid = get_input('owner_guid');
$profilex_classic = unserialize(elgg_get_plugin_user_setting('profilex_classic', $owner_guid, 'profile_x'));
$entity = get_entity($owner_guid);

$activity = elgg_list_river(array(
	'subject_guids' => $owner_guid, 
	'limit' => '5',
	'pagination' => false)
);
$activity_load = elgg_view('input/button', array(
	'value' => 'Load More',
	'data-id' => '5',
	'class' => 'elgg-button-action',
	'id' => 'profilex-classic-activity-load'
));

if (elgg_is_logged_in() && elgg_get_logged_in_user_guid() != elgg_get_page_owner_guid()) {
	$right = '<h3>'.elgg_echo('profilex:classic:activity:messageboard').'</h3>' . elgg_view_form('messageboard/add');
}
else {
	$right = '<h3>'.elgg_echo('profilex:classic:activity:thewire').'</h3>' . elgg_view_form('thewire/add');
}

echo <<<HTML
	<div class="profilex-classic-activity-post profilex-classic-entry">
		$right
		$activity
		<div class="profilex-classic-activity-load-container">
			$activity_load
		</div>
	</div>
HTML;



