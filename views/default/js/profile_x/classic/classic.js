define(['require', 'jquery', 'elgg'], function(require, $, elgg) {
	/**
	 * Cover
	 * 
	 */
	$('.profilex-classic-cover-button').on('click', function() {
		$('.profilex-classic-cover-options, .profilex-classic-user').toggle();
		$('.profilex-classic-cover').backgroundDraggable('disable').css({
			'cursor': ''
		});
		$('.profilex-classic-cover-message, .profilex-classic-cover-link, .profilex-classic-cover-button').hide();
	});
	$('#cover-option-save').on('click', function() {
		$(this).val(elgg.echo('profilex:saving'));
		elgg.get('ajax/view/profile_x/ajax/classic/classic', {
			data: {
				owner_guid: elgg.get_page_owner_guid(),
				cover: {
					cover_position: $('.profilex-classic-cover').css('background-position'),
					cover_url: $('input[name=profilex_cover_url]').val()
				},
			},
			success: function(data) {
				var cover_link = $('.profilex-classic-cover-link');
				$('.profilex-classic-cover').backgroundDraggable('disable').css('cursor', '');
				$('.profilex-classic-cover-message, .profilex-classic-cover-options').hide();
				$('.profilex-classic-user, .profilex-classic-cover-button').toggle();
				$('#cover-option-save').val('Save');
				if (cover_link.attr('href') == '#') {
					cover_link.hide();
				}
				else {
					cover_link.show();
				}
			}
		});
	});
	$('#cover-option-delete').on('click', function() {
		$(this).val(elgg.echo('profilex:deleting'));
		elgg.get('ajax/view/profile_x/ajax/classic/classic', {
			data: {
				owner_guid: elgg.get_page_owner_guid(),
				cover: {
					cover_position: '',
					cover_url: ''
				},
			},
			success: function(data) {
				$('.profilex-classic-cover').backgroundDraggable('disable').css({
					'background-image': '',
					'background-position': '',
					'cursor': ''
				});
				$('#cover-option-delete').val(elgg.echo('profilex:delete'));
				$('.profilex-classic-cover-link').attr('href', '#').hide();
			}
		});
	});
	$('#cover-option-upload').on('click', function() {
		$('input[name=profilex_cover]').click();
	});
	$('#cover-option-drag').on('click', function() {
		$('.profilex-classic-cover-message').show();
		$('.profilex-classic-cover').css({
			'cursor': 'ns-resize'
		}).backgroundDraggable();
	});
	$('input[name=profilex_cover]').liteUploader({
		script: elgg.normalize_url('ajax/view/profile_x/ajax/classic/imgur'),
		params: {
			type: 'cover'
		},
		rules: {
			allowedFileTypes: 'image/jpeg,image/png,image/gif',
	    }
	})
	.on('lu:before', function (e, files) {
		elgg.system_message(elgg.echo('profilex:uploading'));
	})
	.on('lu:success', function (e, response) {
		var response = $.parseJSON(response);
		$('.profilex-classic-cover-message').show();
		$('.elgg-state-success').click();
		$('.profilex-classic-cover').css({
			'background-image': 'url('+response.url+')',
			'background-position': 'center top',
			'cursor': 'ns-resize'
		}).backgroundDraggable();
		$('.profilex-classic-cover-link').attr('href', response.url);
		$('input[name=profilex_cover_url]').val(response.url);
	});
	/**
	 * User
	 * 
	 */
	$('#profilex-classic-add').on('click', function() {
		elgg.action('action/friends/add', {
			data: {
				friend: $(this).attr('data-id'),
			},
			success: function(data) {
				$('#profilex-classic-add, #profilex-classic-remove').toggle();
			}
		});
	});
	$('#profilex-classic-remove').on('click', function() {
		elgg.action('action/friends/remove', {
			data: {
				friend: $(this).attr('data-id'),
			},
			success: function(data) {
				$('#profilex-classic-add, #profilex-classic-remove').toggle();
			}
		});
	});
	/**
	 * Container
	 * 
	 */
	elgg.get('ajax/view/profile_x/ajax/classic/container', {
		data: {
			owner_guid: elgg.get_page_owner_guid()
		},
		success: function(data) {
			$('.profilex-classic-content').html(data);
			classic_container();
		}
	});
	$('.profilex-classic-user-activity').on('click', function() {
		var right = $('.profilex-classic-right');
		
		right.html('<div class="profilex-classic-entry"><i class="fa fa-spinner fa-spin"></i></div>');
		elgg.get('ajax/view/profile_x/ajax/classic/activity', {
			data: {
				owner_guid: elgg.get_page_owner_guid()
			},
			success: function(data) {
				right.html(data);
				classic_activity();
			}
		});
	});
	$('.profilex-classic-user-about').on('click', function() {
		var right = $('.profilex-classic-right');
		right.html('<div class="profilex-classic-entry"><i class="fa fa-spinner fa-spin"></i></div>');
		elgg.get('ajax/view/profile_x/ajax/classic/about', {
			data: {
				owner_guid: elgg.get_page_owner_guid()
			},
			success: function(data) {
				right.html(data);
				classic_about();
			}
		});
	});
	$('.profilex-classic-user-messageboard').on('click', function() {
		var right = $('.profilex-classic-right');
		right.html('<div class="profilex-classic-entry"><i class="fa fa-spinner fa-spin"></i></div>');
		elgg.get('ajax/view/profile_x/ajax/classic/messageboard', {
			data: {
				owner_guid: elgg.get_page_owner_guid()
			},
			success: function(data) {
				right.html(data);
				classic_messageboard();
			}
		});
	});
	$('.profilex-classic-user-friends').on('click', function() {
		var right = $('.profilex-classic-right');
		right.html('<div class="profilex-classic-entry"><i class="fa fa-spinner fa-spin"></i></div>');
		elgg.get('ajax/view/profile_x/ajax/classic/friends', {
			data: {
				owner_guid: elgg.get_page_owner_guid()
			},
			success: function(data) {
				right.html(data);
				classic_friends();
			}
		});
	});
	$('.profilex-classic-user-menu li a').on('click', function() {
		$('.profilex-classic-user-menu li a').removeClass('profilex-classic-user-menu-active');
		$(this).addClass('profilex-classic-user-menu-active');
	});
	/**
	 * Functions
	 * 
	 */
	function photos_layout() {
		var photo = $('#grid li').length;
		var photos = $('#grid li');
		switch(photo){
			case 1:
				photos.addClass('profilex-classic-photos-1-layout');
				photos.removeClass('profilex-classic-photos-2-layout');
			break;
			case 2:
				photos.addClass('profilex-classic-photos-2-layout');
				photos.removeClass('profilex-classic-photos-1-layout');
			break;
			case 3:
				photos.addClass('profilex-classic-photos-3-layout');
				photos.removeClass('profilex-classic-photos-1-layout profilex-classic-photos-2-layout');
			break;
			case 4:
				photos.addClass('profilex-classic-photos-4-layout');
				photos.removeClass('profilex-classic-photos-1-layout profilex-classic-photos-2-layout profilex-classic-photos-3-layout');
			break;
			case 5:
				photos.addClass('profilex-classic-photos-5-layout');
				photos.removeClass('profilex-classic-photos-1-layout profilex-classic-photos-2-layout profilex-classic-photos-3-layout profilex-classic-photos-4-layout');
			break;
			case 7:
				photos.addClass('profilex-classic-photos-7-layout');
				photos.removeClass('profilex-classic-photos-1-layout profilex-classic-photos-2-layout profilex-classic-photos-3-layout profilex-classic-photos-4-layout profilex-classic-photos-5-layout');
			break;
			case 8:
				photos.addClass('profilex-classic-photos-8-layout');
				photos.removeClass('profilex-classic-photos-1-layout profilex-classic-photos-2-layout profilex-classic-photos-3-layout profilex-classic-photos-4-layout profilex-classic-photos-5-layout profilex-classic-photos-7-layout');
			break;
		}
	}
	function photos_update() {
		var photo_id = 1;
		$('#grid li').each(function() {
        	$(this).attr('data-id', photo_id++);
        });
        photo_id = 1;
	}
	function classic_activity() {
		$('#profilex-classic-activity-load').on('click', function() {
			$(this).val(elgg.echo('profilex:classic:activity:loading'));
			elgg.get('ajax/view/profile_x/ajax/classic/feed', {
				data: {
					offset: $(this).attr('data-id'),
					owner: elgg.get_page_owner_guid()
				},
				success: function(data) {
					var response = $.parseJSON(data);
					$('#profilex-classic-activity-load').attr('data-id', response.offset);
					if (response.activity == '') {
						$('#profilex-classic-activity-load').remove();
					}
					else {
						$(response.activity).insertBefore('.profilex-classic-activity-load-container');
					}
					$('#profilex-classic-activity-load').val(elgg.echo('profilex:classic:activity:load'));
				}
			});
		});
	}
	function classic_messageboard() {
		$('#profilex-classic-messageboard-load').on('click', function() {
			$(this).val(elgg.echo('profilex:classic:activity:loading'));
			elgg.get('ajax/view/profile_x/ajax/classic/mb', {
				data: {
					offset: $(this).attr('data-id'),
					owner_guid: elgg.get_page_owner_guid()
				},
				success: function(data) {
					var response = $.parseJSON(data);
					$('#profilex-classic-messageboard-load').attr('data-id', response.offset);
					if (response.messageboard == '') {
						$('#profilex-classic-messageboard-load').remove();
					}
					else {
						$(response.messageboard).insertBefore('.profilex-classic-messageboard-load-container');
					}
					$('#profilex-classic-messageboard-load').val(elgg.echo('profilex:classic:activity:load'));
				}
			});
		});
	}
	function classic_friends() {
		$('#profilex-classic-friends-load').on('click', function() {
			$(this).val(elgg.echo('profilex:classic:activity:loading'));
			elgg.get('ajax/view/profile_x/ajax/classic/friends_offset', {
				data: {
					offset: $(this).attr('data-id'),
					owner_guid: elgg.get_page_owner_guid()
				},
				success: function(data) {
					var response = $.parseJSON(data);
					$('#profilex-classic-friends-load').attr('data-id', response.offset);
					if (response.friends == '') {
						$('#profilex-classic-friends-load').remove();
					}
					else {
						$(response.friends).insertBefore('.profilex-classic-friends-load-container');
					}
					$('#profilex-classic-friends-load').val(elgg.echo('profilex:classic:activity:load'));
				}
			});
		});
	}
	function classic_left() {
		/**
		 * Intro
		 * 
		 */
		$('#profilex-classic-activity-intro-save').on('click', function() {
			$(this).val(elgg.echo('profilex:saving'));
			elgg.action('action/profile/edit', {
				data: {
					guid: elgg.get_page_owner_guid(),
					briefdescription: $('textarea[name=briefdescription]').val(),
					accesslevel: {briefdescription: $('.profilex-classic-briefdescription-access').val()}
				},
				success: function(data) {
					if (data.status != '-1') {
						$('.profilex-classic-activity-intro li.intro p').text($('textarea[name=briefdescription]').val());
						$('#profilex-classic-activity-intro-edit').click();
					}
					$('#profilex-classic-activity-intro-save').val(elgg.echo('profilex:save'));
				}
			});
		});
		$('#profilex-classic-activity-intro-edit').on('click', function() {
			$('.profilex-classic-activity-intro li.intro p, textarea[name=briefdescription], #profilex-classic-activity-intro-save, .profilex-classic-briefdescription-access').toggle();
			$('textarea[name=briefdescription]').val($('.intro p').html());
		});
		/**
		 * Photos
		 * 
		 */
		photos_layout();
		$('.photo-item .fa-upload').one('click', function() {
			$('input[name=profilex_classic_photo]').click();
		});
		$('#profilex-classic-photos-add').on('click', function() {
			if ($('.profilex-classic-photos ul > li').length >= 9) {
				elgg.register_error('The limit is 9 photos');
			}
			else {
				$('input[name=profilex_classic_photo]').click();
			}
		});
		$('#grid .fa-minus-circle').on('click', function() {
			$(this.closest('li')).remove();
		});
		$('#profilex-classic-activity-photos-edit').on('click', function() {
			photos_update();
			$('#grid li').removeClass();
			$('#grid li a').toggle();
			$('.profilex-classic-photos .fa-plus, #profilex-classic-activity-photos-save, .profilex-classic-photos .fa-minus-circle').toggle();
			$('#grid li').toggleClass('profilex-classic-photos-move');
			if ($('#grid i').is(':visible')) {
				$('#grid').sortable({
					  disabled: false,
					  update: function(event, ui) {
				            photos_update();
				        }
					});
			}
			else {
				$('#grid').sortable({
				  disabled: true
				});
				$('#grid li').toggleClass('profilex-classic-photos-move');
				photos_layout();
			}
		});
		$('#profilex-classic-activity-photos-save').on('click', function() {
			$(this).val(elgg.echo('profilex:saving'));
			if ($('#grid li').length == '0') {
				var url = '0';
			}
			else {
				var images = $('#grid li').map(function() { return $(this).css('background-image').replace(/^url\(['"](.+)['"]\)/, '$1'); });
				var url = images.toArray();
			}
			elgg.get('ajax/view/profile_x/ajax/classic/classic', {
				data: {
					owner_guid: elgg.get_page_owner_guid(),
					photos: url
				},
				success: function(data) {
					photos_layout();
					$('#profilex-classic-activity-photos-save').val(elgg.echo('profilex:save'));
					$('.profilex-classic-photos .fa-plus, #profilex-classic-activity-photos-save, .profilex-classic-photos .fa-minus-circle').toggle();
					$('.profilex-classic-photos ul li').toggleClass('profilex-classic-photos-move');
					$('#grid').sortable({
					  disabled: true
					});
					$('#grid li a').toggle();
				}
			});
		});
		$('input[name=profilex_classic_photo]').liteUploader({
			script: elgg.normalize_url('ajax/view/profile_x/ajax/classic/imgur'),
			params: {
				type: 'photo'
			}
		})
		.on('lu:before', function (e, files) {
			$('#profilex-classic-photos-add, #profilex-classic-photos i, .profilex-classic-photo-loader').toggle();
		})
		.on('lu:success', function (e, response) {
			var response = $.parseJSON(response);
			$('#profilex-classic-photos-add, .profilex-classic-photo-loader').toggle();
			$('#grid').append('<li data-id="" class="profilex-classic-photos-move" style="background-image: url('+response.url+')"><i class="fa fa-minus-circle"></i><a href="'+response.url+'" class="elgg-lightbox" style="display:none;"></a></li>');
			$('#grid .fa-minus-circle').on('click', function() {
				$(this.closest('li')).remove();
			});
		});
	}
	function classic_about() {
		$('.profilex-classic-about textarea').val($('.profilex-classic-about-text').text());
		$('#profilex-classic-about-edit').on('click', function() {
			$('.profilex-classic-about-text, .profilex-about-input, .profilex-classic-about span, #profilex-classic-about-save, .profilex-about-access').toggle();
		});
		$('#profilex-classic-about-save').on('click', function() {
			elgg.action('action/profile/edit', {
				data: {
					guid: elgg.get_page_owner_guid(),
					description: $('textarea[name=description]').val(),
					location: $('input[name=location]').val(),
					website: $('input[name=website]').val(),
					accesslevel: {
						description: $('.profilex-classic-description-access').val(),
						location: $('.profilex-classic-location-access').val(),
						website: $('.profilex-classic-website-access').val(),
					}
				},
				success: function(data) {
					$('.profilex-classic-about-text').text($('.profilex-classic-about textarea').val());
					$('.profilex-classic-about-location').text($('input[name=location]').val());
					$('.profilex-classic-about-website').html('<a href="'+$('input[name=website]').val()+'" target="_blank">'+$('input[name=website]').val()+'</a>');
					if (data.status != '-1') {
						$('#profilex-classic-about-edit').click();
					}
				}
			});
		});
	}
	function classic_container() {
		$(window).scroll(function() {
			if($(window).scrollTop() + $(window).height() == $(document).height()) {
			   $('#profilex-classic-activity-load').click();
			   $('#profilex-classic-messageboard-load').click();
			   $('#profilex-classic-friends-load').click();
			}
		});
		var intro = $('.profilex-classic-activity-intro');
		var photos = $('.profilex-classic-photos');
		intro.html('<i class="fa fa-spinner fa-spin"></i>');
		photos.html('<i class="fa fa-spinner fa-spin"></i>');
		elgg.get('ajax/view/profile_x/ajax/classic/info', {
			data: {
				owner_guid: elgg.get_page_owner_guid()
			},
			success: function(data) {
				intro.html(data);
				classic_left();
			}
		});
		elgg.get('ajax/view/profile_x/ajax/classic/photos', {
			data: {
				owner_guid: elgg.get_page_owner_guid()
			},
			success: function(data) {
				photos.html(data);
			}
		});
		var right = $('.profilex-classic-right');
		right.html('<div class="profilex-classic-entry"><i class="fa fa-spinner fa-spin"></i></div>');
		elgg.get('ajax/view/profile_x/ajax/classic/activity', {
			data: {
				owner_guid: elgg.get_page_owner_guid()
			},
			success: function(data) {
				right.html(data);
				classic_activity();
			}
		});
	}
	function responsive() {
        if ($(window).width() < 1024) {
        	var name = $('.profilex-classic-name');
        	name.css({
        		'width': name.width() + 1,
        		'margin-left': - name.width() / 2
        	});
        }

        if ($(window).width() > 1024) {
        	var name = $('.profilex-classic-name');
        	name.removeAttr('style');
        }
    }
    responsive();
    $(window).resize(function() {
        responsive();
    });
});