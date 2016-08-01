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
	<div class="profilex-classic-logo">
		<a href="$url">
			$name
		</a>
	</div>
	<div class="profilex-classic-search">
		$search
	</div>
HTML;
