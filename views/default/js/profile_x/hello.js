define(['require', 'jquery', 'elgg'], function(require, $, elgg) {
	elgg.get('ajax/view/profile_x/ajax/init', {
		data: {
			owner: elgg.get_page_owner_guid()
		},
		success: function(data) {
			var response = $.parseJSON(data);
			if (response.theme != 'default') {
				$('.elgg-page-default').addClass('profilex-' + response.theme);
				$('.elgg-page-header, .elgg-page-navbar').remove();
			}
			$('.elgg-page-body, .profilex-preload').toggle();
		}
	});
	$('.profilex-container-close').on('click', function() {
		$('.profilex-container, .elgg-page-default').fadeToggle();
	});
	$('#profilex-init').on('click', function() {
		$('.profilex-container, .elgg-page-default').fadeToggle();
	});
	$('a#profilex-select').on('click', function(e) {
		var data_id = $(this).attr('data-id');
		var status = $(this).attr('data-status');
		$(this).closest('li').find('a').removeAttr('id');
		$(this).closest('li').find('h2').html('<i class="fa fa-gear fa-spin fa-2x"></i>');
		elgg.get('ajax/view/profile_x/ajax/themes', {
			data: {
				theme: data_id,
				owner: elgg.get_page_owner_guid()
			},
			success: function(data) {
				location.reload();
			}
		});
		e.preventDefault();
	});
	$('#profilex-message-send').on('click', function() {
		$('#profilex-message-send').val(elgg.echo('profilex:message:sending')).prop('disabled', true);
		elgg.action('action/messages/send', {
			data: {
				recipients: elgg.get_page_owner_guid(),
				subject: $('.profilex-message input[name=subject]').val(),
				body: $('.profilex-message textarea[name=body]').val()
			},
			success: function(data) {
				$('#profilex-message-send').val(elgg.echo('profilex:message:send')).prop('disabled', false);
				$('.profilex-message input[name=subject], .profilex-message textarea[name=body]').val('');	
				$('.profilex-message input[name=subject]').focus();
			}
		});
	});
	$('#profilex-message-close').on('click', function() {
		$('.profilex-message-container').toggle();
	});
	$('#profilex-message').on('click', function() {
		$('.profilex-message-container').toggle();
		$('input[name=subject]').focus();
	});
	function responsive() {
        if ($(window).width() < 1024) {
        }

        if ($(window).width() > 1024) {
        }
    }
    responsive();
    $(window).resize(function() {
        responsive();
    });
});