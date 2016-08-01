<?php
/**
 * Profile X
 * 
 */

$owner_guid = get_input('owner_guid');
$profilex_classic = unserialize(elgg_get_plugin_user_setting('profilex_classic', $owner_guid, 'profile_x'));
$entity = get_entity($owner_guid);
$access = $entity->canEdit();
$friends = elgg_list_entities_from_relationship(array(
	'relationship' => 'friend',
	'relationship_guid' => $owner_guid,
	'inverse_relationship' => false,
	'type' => 'user',
	'pagination' => false,
));
$friends_load = elgg_view('input/button', array(
	'value' => 'Load More',
	'data-id' => '5',
	'class' => 'elgg-button-action',
	'id' => 'profilex-classic-friends-load'
));

echo <<<HTML
	<div class="profilex-classic-friends profilex-classic-entry">
		<i class="fa fa-group"></i><h3>Friends</h3>
		$friends
		<div class="profilex-classic-friends-load-container">
			$friends_load
		</div>
	</div>
HTML;


