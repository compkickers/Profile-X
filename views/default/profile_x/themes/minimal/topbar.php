<?php
/**
 * Profile X
 * 
 */

$site = elgg_get_site_entity();
$name = $site->name;
$url = elgg_get_site_url();
$search = elgg_view('search/search_box');

echo <<<HTML
	<div class="profilex-minimal-logo">
		<a href="$url">
			$name
		</a>
	</div>
HTML;
