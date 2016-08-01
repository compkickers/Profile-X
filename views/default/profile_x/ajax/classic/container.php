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

echo <<<HTML
	<div class="profilex-classic-container">
		<div class="profilex-classic-left">
			<div class="profilex-classic-activity-intro profilex-classic-entry">
			</div>
			<div class="profilex-classic-photos profilex-classic-entry">
			</div>
		</div>
		<div class="profilex-classic-right">
			<div class="profilex-classic-entry">
			</div>
		</div>
	</div>
HTML;
