<?php
/**
 * Profile X
 * 
 */

$owner_guid = get_input('owner_guid');
$profilex_classic = unserialize(elgg_get_plugin_user_setting('profilex_classic', $owner_guid, 'profile_x'));
$entity = get_entity($owner_guid);
$access = $entity->canEdit();
$about = $entity->description;
$location = $entity->location;
$website = $entity->website;
$about_input = '';
$about_edit = '';
$location_input = '';
$website_input = '';
$about_save = '';
$access_description = '';
$access_location = '';
$access_website = '';
$description_access_id = elgg_get_metadata(array(
	'guid' => $owner_guid,
	'metadata_name' => 'description',
	'limit' => false
));
$location_access_id = elgg_get_metadata(array(
	'guid' => $owner_guid,
	'metadata_name' => 'location',
	'limit' => false
));
$website_access_id = elgg_get_metadata(array(
	'guid' => $owner_guid,
	'metadata_name' => 'website',
	'limit' => false
));
$blogs = elgg_list_river(array(
	'subject_guids' => $owner_guid, 
	'subtype' => 'blog',
	'limit' => '5',
	'pagination' => false)
);

if ($access) {
	$about_edit = '<i class="fa fa-pencil" id="profilex-classic-about-edit"></i>';
	$about_input = elgg_view('input/plaintext', array(
		'name' => 'description',
		'class' => 'hidden profilex-about-input profilex-about-description'
	));
	$location_input = elgg_view('input/text', array(
		'name' => 'location',
		'value' => $location,
		'class' => 'hidden profilex-about-input'
	));
	$website_input = elgg_view('input/text', array(
		'name' => 'website',
		'value' => $website,
		'class' => 'hidden profilex-about-input'
	));
	$access_description = elgg_view('input/access', [
		'name' => 'accesslevel[description]',
		'value' => $description_access_id[0]['access_id'],
		'class' => 'hidden mtm float-alt profilex-classic-description-access profilex-about-access'
	]);
	$access_location = elgg_view('input/access', [
		'name' => 'accesslevel[location]',
		'value' => $location_access_id[0]['access_id'],
		'class' => 'hidden mtm float-alt profilex-classic-location-access profilex-about-access'
	]);
	$access_website = elgg_view('input/access', [
		'name' => 'accesslevel[briefdescription]',
		'value' => $website_access_id[0]['access_id'],
		'class' => 'hidden mtm float-alt profilex-classic-website-access profilex-about-access'
	]);
	$about_save = elgg_view('input/button', array(
		'value' => 'Save',
		'class' => 'elgg-button-submit hidden',
		'id' => 'profilex-classic-about-save'
	));
}

echo <<<HTML
	<div class="profilex-classic-about profilex-classic-entry">
		<i class="fa fa-user"></i><h3>About</h3> $about_edit $about_input <p class="profilex-about-align-right">$access_description</p>
		<p class="profilex-classic-about-text">$about</p>
		<i class="fa fa-map-marker"></i><span class="profilex-classic-about-location">$location</span>$location_input 
		<p class="profilex-about-align-right">$access_location</p>
		<div class="profilex-about-gap"></div>
		<i class="fa fa-globe"></i><span  class="profilex-classic-about-website"><a href="$website" target="_blank">$website</a></span>
		$website_input
		<p class="profilex-about-align-right">$access_website</p>
		$about_save
	</div>
	<div class="profilex-classic-about-blog profilex-classic-entry">
		<i class="fa fa-book"></i><h3>Blogs</h3>
		$blogs
	</div>
HTML;


