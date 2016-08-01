<?php
/**
 * Profile X
 * 
 */

$owner_guid = get_input('owner_guid');
$profilex_classic = unserialize(elgg_get_plugin_user_setting('profilex_classic', $owner_guid, 'profile_x'));
$entity = get_entity($owner_guid);
$access = $entity->canEdit();
$messageboard = elgg_list_annotations(array(
	'annotations_name' => 'messageboard',
	'guid' => $owner_guid,
	'reverse_order_by' => true,
	'preload_owners' => true,
	'limit' => 5,
	'pagination' => false
));
$mb_load = elgg_view('input/button', array(
	'value' => 'Load More',
	'data-id' => '5',
	'class' => 'elgg-button-action',
	'id' => 'profilex-classic-messageboard-load'
));

echo <<<HTML
	<div class="profilex-classic-messageboard profilex-classic-entry">
		<i class="fa fa-comments"></i><h3>Message Board</h3>
		$messageboard
		<div class="profilex-classic-messageboard-load-container">
			$mb_load
		</div>
	</div>
HTML;


