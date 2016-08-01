<?php
/**
 * Profile X
 * 
 */

$profilex_themes = unserialize(elgg_get_plugin_user_setting('profilex_theme', elgg_get_page_owner_guid(), 'profile_x'));
$welcome = elgg_echo('profilex:container:welcome');
$select = elgg_echo('profilex:container:select');

echo <<<HTML

<div class="profilex-container hidden">
	<span class="profilex-container-close">X</span>
	<h1>$welcome</h1>
	<h2>$select</h2>
	<div class="profilex-options">
		<ul class="profilex-layouts">

HTML;

if (elgg_is_logged_in() && $profilex_themes) {
	foreach ($profilex_themes as $value) {
		if (in_array('1', $value)) {
			echo '<li><img src="'.elgg_get_site_url().'mod/profile_x/_graphics/thumb-'.$value['theme'].'.png"><h2><span>'.ucfirst($value['theme']).'</span></h2></li>';
		}
		else {
			echo '<li><a href="#'.$value['theme'].'" id="profilex-select" data-id="'.$value['theme'].'" data-status="0"><img src="'.elgg_get_site_url().'mod/profile_x/_graphics/thumb-'.$value['theme'].'.png"><h2>'.ucfirst($value['theme']).'</h2></a>';
		}
	}
}

echo <<<HTML

		</ul>
	</div>
</div>

HTML;

