define(['require', 'jquery', 'elgg'], function(require, $, elgg) {
	/**
	 * Cover
	 * 
	 */
    var intVar;                
    var minimal_interval = 1000; 

    $('.profilex-container').css('height', $(window).height() + 40);
    $('#profilex-minimal-settings').on('click', function() {
        $('.profilex-minimal-settings').toggleClass('profilex-minimal-settings-open');
        $('body').toggleClass('profilex-minimal-open');
    });
    $('textarea[name=briefdescription]').on('keyup', function () {
        $('.profilex-minimal-brief').text($(this).val());
        clearTimeout(intVar);
        intVar = setTimeout(brief_done, minimal_interval);
    });
    $('.profilex-minimal-brief-access').on('change', function () {
        clearTimeout(intVar);
        intVar = setTimeout(brief_done, minimal_interval);
    });
    $('.profilex-minimal-background-actions .fa-minus').on('click', function() {
        $('.profilex-minimal-background-loader').toggle();
        elgg.get('ajax/view/profile_x/ajax/minimal/minimal', {
            data: {
                owner_guid: elgg.get_page_owner_guid(),
                bg: {
                    url: '',
                    color: rgb2hex($('body').css('backgroundColor'))
                }
            },
            success: function(data) {
                var response = $.parseJSON(data);
                $('.profilex-minimal-background-loader').toggle();
                $('body').css('background-image', 'url()');
                $('.profilex-minimal-background').css('background-image', 'url()');
            }
        });
    });
    $('.profilex-minimal-background-actions .fa-picture-o').on('click', function() {
        $('input[name=profilex_minimal_bg]').click();
    });
    $('input[name=profilex_minimal_bg]').liteUploader({
        script: elgg.normalize_url('ajax/view/profile_x/ajax/minimal/imgur'),
        rules: {
            allowedFileTypes: 'image/jpeg,image/png,image/gif',
        }
    })
    .on('lu:before', function (e, files) {
        $('.profilex-minimal-background-loader').toggle();
    })
    .on('lu:success', function (e, response) {
        var imgr = $.parseJSON(response);
        elgg.get('ajax/view/profile_x/ajax/minimal/minimal', {
            data: {
                owner_guid: elgg.get_page_owner_guid(),
                bg: {
                    url: imgr.url,
                    color: rgb2hex($('body').css('background-color'))
                }
            },
            success: function(data) {
                var response = $.parseJSON(data);
                $('body, .profilex-minimal-background').css('background-image', 'url('+imgr.url+')');
                $('.profilex-minimal-background-loader').toggle();
            }
        });
    });
    $('#test').on('click', function() {
        $('.profilex-minimal-background-loader').toggle();
        elgg.get('ajax/view/profile_x/ajax/minimal/minimal', {
            data: {
                owner_guid: elgg.get_page_owner_guid(),
                bg: {
                    url: $('.profilex-minimal-background').css('background-image').replace(/^url\(['"](.+)['"]\)/, '$1'),
                }
            },
            success: function(data) {
                var response = $.parseJSON(data);
                $('body').css('background-image', 'url('+response.bg_url+')');
                $('.profilex-minimal-background-loader').toggle();
            }
        });
    });
    $('.fa-table').ColorPicker({
        onShow: function (colpkr) {
            $(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(500);
            return false;
        },
        onChange: function (hsb, hex, rgb) {
            $('body').css('backgroundColor', '#' + hex);
            $('.profilex-minimal-user input, .profilex-minimal-user input:hover').css({
                'background': '#' + hex,
                'border-color': '#' + hex,
            });
            $('.profilex-minimal-background-actions i').css('background', '#' + hex);
            clearTimeout(intVar);
            intVar = setTimeout(function() {
                $('.profilex-minimal-background-loader').toggle();
                elgg.get('ajax/view/profile_x/ajax/minimal/minimal', {
                    data: {
                        owner_guid: elgg.get_page_owner_guid(),
                        bg: {
                            url: $('.profilex-minimal-background').css('background-image').replace(/^url\(['"](.+)['"]\)/, '$1'),
                            color: hex
                        }
                    },
                    success: function(data) {
                        var response = $.parseJSON(data);
                        $('.profilex-minimal-background-loader').toggle();
                    }
                });
            }, minimal_interval);
        }
    });
    $('.fa-font').ColorPicker({
        onShow: function (colpkr) {
            $(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(500);
            return false;
        },
        onChange: function (hsb, hex, rgb) {
            $('.profilex-minimal-name, .profilex-minimal-brief').css('color', '#' + hex);
            clearTimeout(intVar);
            intVar = setTimeout(function() {
                $('.profilex-minimal-background-loader').toggle();
                elgg.get('ajax/view/profile_x/ajax/minimal/minimal', {
                    data: {
                        owner_guid: elgg.get_page_owner_guid(),
                        bg: {
                            url: $('.profilex-minimal-background').css('background-image').replace(/^url\(['"](.+)['"]\)/, '$1'),
                            color: $('body').css('background-color'),
                            font: hex
                        }
                    },
                    success: function(data) {
                        var response = $.parseJSON(data);
                        $('.profilex-minimal-background-loader').toggle();
                    }
                });
            }, minimal_interval);
        }
    });
    $('#profilex-minimal-add').on('click', function() {
        elgg.action('action/friends/add', {
            data: {
                friend: $(this).attr('data-id'),
            },
            success: function(data) {
                $('#profilex-minimal-add, #profilex-minimal-remove').toggle();
            }
        });
    });
    $('#profilex-minimal-remove').on('click', function() {
        elgg.action('action/friends/remove', {
            data: {
                friend: $(this).attr('data-id'),
            },
            success: function(data) {
                $('#profilex-minimal-add, #profilex-minimal-remove').toggle();
            }
        });
    });
    //Function to convert hex format to a rgb color
    function rgb2hex(rgb){
        rgb = rgb.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);
        return (rgb && rgb.length === 4) ?
        ("0" + parseInt(rgb[1],10).toString(16)).slice(-2) +
        ("0" + parseInt(rgb[2],10).toString(16)).slice(-2) +
        ("0" + parseInt(rgb[3],10).toString(16)).slice(-2) : '';
    }
    function brief_done() {
       $('.profilex-minimal-intro-loader').toggle();
        elgg.action('action/profile/edit', {
            data: {
                guid: elgg.get_page_owner_guid(),
                briefdescription: $('textarea[name=briefdescription]').val(),
                accesslevel: {briefdescription: $('.profilex-minimal-brief-access').val()}
            },
            success: function(data) {
                $('.profilex-minimal-intro-loader').toggle();
            }
        });
    }
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