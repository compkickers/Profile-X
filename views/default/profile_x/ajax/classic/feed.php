<?php
/**
 * Profile X
 * 
 */

$offset = get_input('offset');
$owner = get_input('owner');

$activity = elgg_list_river(array(
	'subject_guids' => $owner, 
	'limit' => 5,
	'offset' => $offset,
	'pagination' => false)
);

echo json_encode(
	array(
		'offset' => $offset + 5,
		'activity' => $activity
	)
);