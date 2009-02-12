jQuery.noConflict();

cfct = {}

cfct.loading = function() {
	return '<div class="loading"><span>Loading...</span></div>';
}

cfct.ajax_post_content = function() {
	jQuery('ol.archive .excerpt .entry-title a').unbind().click(function() {
		var post_id = jQuery(this).attr('rev').replace('post-', '');
		var excerpt = jQuery('#post-excerpt-' + post_id);
		var target = jQuery('#post-content-' + post_id + '-target');
		excerpt.hide();
		target.hide().html(cfct.loading()).load(CFCT_URL + '/index.php?cfct_action=post_content&id=' + post_id, function() {
			cfct.ajax_post_comments();
			jQuery('#post_close_' + post_id + ' a').click(function() {
				target.slideUp(function() {
					excerpt.show();
				});
				return false;
			});
			jQuery(this).slideDown();
		});
		return false;
	});
}

cfct.ajax_post_comments = function() {
	jQuery('p.comments-link a').unbind().click(function() {
		var a = jQuery(this);
		var post_id = a.attr('rev').replace('post-', '');
		var target = jQuery('#post-comments-' + post_id + '-target');
		target.hide().html(cfct.loading()).load(CFCT_URL + '/index.php?cfct_action=post_comments&id=' + post_id, function() {
			jQuery(this).slideDown(function() {
				a.attr('rel', a.html()).html('Hide Comments').unbind().click(function() {
					target.slideUp(function() {
						a.html(a.attr('rel'));
						cfct.ajax_post_comments();
					});
					return false;
				});
			});
		});
		return false;
	});
}

jQuery(document).ready(function($) {
	// :first-child fix for IE
	$('#navigation li li:first-child, #all-categories li li:first-child').addClass('first');
	// :hover fix for full articles in IE
	$('.full').mouseover(function() {
		$(this).addClass('hover');
	});
	$('.full').mouseout(function() {
		$(this).removeClass('hover');
	});
	if ((!$.browser.msie || $.browser.version.substr(0,1) != '6') && typeof CFCT_AJAX_LOAD != 'undefined' && CFCT_AJAX_LOAD) {
		cfct.ajax_post_content();
		cfct.ajax_post_comments();
	}
	$('#navigation li a, #all-categories li a').removeAttr('title');
});