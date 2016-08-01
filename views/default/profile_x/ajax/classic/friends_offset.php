<?php
/**
 * Profile X
 * 
 */

$offset = get_input('offset');
$owner_guid = get_input('owner_guid');

$friends = elgg_list_entities_from_relationship(array(
	'relationship' => 'friend',
	'relationship_guid' => $owner_guid,
	'inverse_relationship' => false,
	'type' => 'user',
	'pagination' => false,
	'offset' => $offset
));

echo json_encode(
	array(
		'offset' => $offset + 5,
		'friends' => $friends
	)
);