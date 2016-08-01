<?php
/**
 * Profile X
 * 
 */

$entity = get_entity(elgg_get_page_owner_guid());
$recipient_icon = $entity->getIconURL('large');
$recipient_name = $entity->name;
$subject = elgg_view('input/text', array(
	'name' => 'subject',
	'placeholder' => elgg_echo('profilex:message:subject'),
));
$body = elgg_view('input/plaintext', array(
	'name' => 'body',
	'placeholder' => elgg_echo('profilex:message:body'),
));
$send = elgg_view('input/button', array(
	'value' => elgg_echo('profilex:message:send'),
	'class' => 'elgg-button-submit',
	'id' => 'profilex-message-send'
));
$close = elgg_view('input/button', array(
	'value' => elgg_echo('profilex:message:close'),
	'class' => 'elgg-button-delete float-alt',
	'id' => 'profilex-message-close'
));

if (elgg_is_logged_in()) {

$body = <<<HTML

<div class="profilex-message-to">
	<ul>
		<li><img src="$recipient_icon" /></li>
		<li>$recipient_name</li>
	</ul>
</div>
<div class="profilex-message-body">
	$subject $body
</div>
<div class="profilex-message-footer">
	$send $close
</div>
HTML;
}
else {
	$body = <<<HTML
		Must be logged in to send message.
		<div class="profilex-message-footer">
			$close
		</div>
HTML;
}


echo <<<HTML

<div class="profilex-message-container hidden">
	<div class="profilex-message">
		$body
	</div>
</div>

HTML;

