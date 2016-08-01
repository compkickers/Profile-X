<?php
/**
 * Profile X
 * 
 */

$offset = get_input('offset');
$owner_guid = get_input('owner_guid');

$messageboard = elgg_list_annotations(array(
	'annotations_name' => 'messageboard',
	'guid' => $owner_guid,
	'reverse_order_by' => true,
	'preload_owners' => true,
	'limit' => 5,
	'offset' => $offset,
	'pagination' => false
));

echo json_encode(
	array(
		'offset' => $offset + 5,
		'messageboard' => $messageboard
	)
);