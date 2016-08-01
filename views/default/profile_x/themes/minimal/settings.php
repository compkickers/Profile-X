<?php
/**
 * Profile X
 * 
 */

$profilex_minimal = unserialize(elgg_get_plugin_user_setting('profilex_minimal', elgg_get_page_owner_guid(), 'profile_x'));

$entity = get_entity(elgg_get_page_owner_guid());
$access = $entity->canEdit();
$icon = $entity->getIconURL('large');
$name = $entity->name;
$brief = $entity->briefdescription;
$bg_temp = elgg_view('input/file', array(
	'name' => 'profilex_minimal_bg',
	'class' => 'hidden'
));
//if ($access) {
	$briefdescription = elgg_view('input/plaintext', array(
		'name' => 'briefdescription',
		'value' => $brief
	));
//}
$test = elgg_view('input/button', array(
			'value' => 'Save',
			'class' => 'elgg-button',
			'id' => 'test',
		));
$brief_access_id = elgg_get_metadata(array(
	'guid' => $entity->guid,
	'metadata_name' => 'briefdescription',
	'limit' => false
));
$access_brief = elgg_view('input/access', [
		'name' => 'accesslevel[briefdescription]',
		'value' => $brief_access_id[0]['access_id'],
		'class' => 'mtm float-alt profilex-minimal-brief-access'
	]);

$lang_intro = elgg_echo('profilex:minimal:intro:title');
$lang_background = elgg_echo('profilex:minimal:background:title');

echo <<<HTML
	<div class="profilex-minimal-settings">
		<h3>$lang_intro <i class="fa fa-spinner fa-spin profilex-minimal-intro-loader float-alt hidden"></i></h3>
		$briefdescription $access_brief
		<div class="profilex-minimal-gap"></div>
		<h3>$lang_background <i class="fa fa-spinner fa-spin  float-alt profilex-minimal-background-loader hidden"></i></h3>
		<div class="profilex-minimal-background">
			<div class="profilex-minimal-background-actions">
				<i class="fa fa-table"></i> <i class="fa fa-font"></i> <i class="fa fa-picture-o"></i> <i class="fa fa-minus"></i>
			</div>
			$bg_temp
		</div>
	</div>

HTML;
