<?php

// This file is part of the Carrington Blog Theme for WordPress
// http://carringtontheme.com
//
// Copyright (c) 2008 Crowd Favorite, Ltd. All rights reserved.
// http://crowdfavorite.com
//
// Released under the GPL license
// http://www.opensource.org/licenses/gpl-license.php
//
// **********************************************************************
// This program is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
// **********************************************************************

if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }

load_theme_textdomain('carrington-blog');

define('CFCT_DEBUG', false);
define('CFCT_PATH', trailingslashit(TEMPLATEPATH));
define('CFCT_HOME_LIST_LENGTH', 5);
define('CFCT_HOME_LATEST_LENGTH', 250);

$cfct_options = array(
	'cfct_home_column_1_cat',
	'cfct_home_column_1_content',
	'cfct_latest_limit_1',
	'cfct_list_limit_1',
	'cfct_home_column_2_cat',
	'cfct_home_column_2_content',
	'cfct_latest_limit_2',
	'cfct_list_limit_2',
	'cfct_home_column_3_cat',
	'cfct_home_column_3_content',
	'cfct_latest_limit_3',
	'cfct_list_limit_3',
	'cfct_ajax_load',
	'cfct_posts_per_archive_page',
	'cfct_custom_colors',
	'cfct_header_image_type',
	'cfct_footer_image_type',
);

$cfct_color_options = array(
	'cfct_header_background_color' => '51555c',
	'cfct_header_text_color' => 'cecfd1',
	'cfct_header_link_color' => 'ffffff',
	'cfct_header_nav_background_color' => 'e9eaea',
	'cfct_header_nav_link_color' => 'a00004',
	'cfct_header_nav_text_color' => '51555c',
	'cfct_page_title_color' => '51555c',
	'cfct_page_subtitle_color' => '51555c',
	'cfct_link_color' => 'a00004',
	'cfct_footer_background_color' => '51555c',
	'cfct_footer_text_color' => '999999',
	'cfct_footer_link_color' => 'CECFD1',
);

foreach ($cfct_color_options as $k => $default) {
	$cfct_options[] = $k;
}

function cfct_blog_option_defaults($options) {
	$options['cfct_list_limit_1'] = CFCT_HOME_LIST_LENGTH;
	$options['cfct_latest_limit_1'] = CFCT_HOME_LATEST_LENGTH;
	$options['cfct_list_limit_2'] = CFCT_HOME_LIST_LENGTH;
	$options['cfct_latest_limit_2'] = CFCT_HOME_LATEST_LENGTH;
	$options['cfct_list_limit_3'] = CFCT_HOME_LIST_LENGTH;
	$options['cfct_latest_limit_3'] = CFCT_HOME_LATEST_LENGTH;
	$options['cfct_ajax_load'] = 'yes';
	$options['cfct_custom_colors'] = 'no';
	return $options;
}
add_filter('cfct_option_defaults', 'cfct_blog_option_defaults');


function cfct_blog_init() {
	if (cfct_get_option('cfct_ajax_load') == 'yes') {
		cfct_ajax_load();
	}
}
add_action('init', 'cfct_blog_init');

if (function_exists('register_sidebar')) {
	register_sidebar(
		array(
			'name' => 'Primary Sidebar',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h2 class="title">',
			'after_title' => '</h2>'
		)
	);
	register_sidebar(
		array(
			'name' => 'Secondary Sidebar',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h2 class="title">',
			'after_title' => '</h2>'
		)
	);
}

wp_enqueue_script('jquery');
wp_enqueue_script('carrington', get_bloginfo('template_directory').'/js/carrington.js', 'jquery', '1.0');

function cfct_blog_head() {
	cfct_get_option('cfct_ajax_load') == 'no' ? $ajax_load = 'false' : $ajax_load = 'true';
	echo '
<script type="text/javascript">
var CFCT_URL = "'.get_bloginfo('url').'";
var CFCT_AJAX_LOAD = '.$ajax_load.';
</script>
	';
	if (cfct_get_option('cfct_custom_colors') == 'yes') {
		get_option('cfct_header_image_type') == 'light' ? $img_type = 'light' : $img_type = 'dark';
?>
<style type="text/css">
#header {
	background-color: #<?php echo get_option('cfct_header_background_color'); ?>;
	background-image: url(<?php bloginfo('template_directory'); ?>/images/header/gradient-<?php echo $img_type; ?>.png);
	color: #<?php echo get_option('cfct_header_text_color'); ?>;
}
#header a,
#header a:visited {
	color: #<?php echo get_option('cfct_header_link_color'); ?>;
}
#header .wrapper {
	background-image: url(<?php bloginfo('template_directory'); ?>/images/header/texture-<?php echo $img_type; ?>.png);
}
#sub-header {
	background-color: #<?php echo get_option('cfct_header_nav_background_color'); ?>;
	color: #<?php echo get_option('cfct_header_nav_text_color'); ?>;
}
#sub-header a,
#sub-header a:visited {
	color: #<?php echo get_option('cfct_header_nav_link_color'); ?>;
}
h1,
h1 a,
h1 a:hover,
h1 a:visited {
	color: #<?php echo get_option('cfct_page_title_color'); ?>;
}
h2,
h2 a,
h2 a:hover,
h2 a:visited {
	color: #<?php echo get_option('cfct_page_subtitle_color'); ?>;
}
a,
a:hover,
a:visited {
	color: #<?php echo get_option('cfct_link_color'); ?>;
}
#footer {
	background-color: #<?php echo get_option('cfct_footer_background_color'); ?>;
	background-image: url(<?php bloginfo('template_directory'); ?>/images/footer/gradient-<?php echo $img_type; ?>.png);
	color: #<?php echo get_option('cfct_footer_text_color'); ?>;
}
#footer a,
#footer a:visited {
	color: #<?php echo get_option('cfct_footer_link_color'); ?>;
}
#footer p#developer-link a,
#footer p#developer-link a:visited {
	background-image: url(<?php bloginfo('template_directory'); ?>/images/footer/by-crowd-favorite-<?php echo $img_type; ?>.png);
}
</style>
<?php
	}
}
add_action('wp_head', 'cfct_blog_head');

function cfct_blog_settings_form() {
	global $cfct_color_options;
	$options = array(
		'yes' => __('Yes', 'carrington-blog'),
		'no' => __('No', 'carrington-blog'),
	);
	$ajax_load_options = '';
	$color_options = '';
	foreach ($options as $k => $v) {
		if ($k == cfct_get_option('cfct_ajax_load')) {
			$ajax_load_selected = 'selected="selected"';
		}
		else {
			$ajax_load_selected = '';
		}
		$ajax_load_options .= "\n\t<option value='$k' $ajax_load_selected>$v</option>";
		if ($k == cfct_get_option('cfct_custom_colors')) {
			$color_options_selected = 'selected="selected"';
		}
		else {
			$color_options_selected = '';
		}
		$color_options .= "\n\t<option value='$k' $color_options_selected>$v</option>";
	}
	$cfct_posts_per_archive_page = get_option('cfct_posts_per_archive_page');
	if (intval($cfct_posts_per_archive_page) == 0) {
		$cfct_posts_per_archive_page = 25;
	}
	cfct_get_option('cfct_custom_colors') == 'no' ? $colors_class = 'hidden' : $colors_class = '';
	$html = '
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row">'.sprintf(__('Design', 'carrington-blog'), $key).'</td>
					<td>
						<fieldset>
							<p>
								<label for="cfct_custom_colors">'.__('Customize Colors:', 'carrington-blog').'</label>
								<select name="cfct_custom_colors" id="cfct_custom_colors">'.$color_options.'</select>
							</p>
							<fieldset class="'.$colors_class.'" id="cfct_color_options_panel">
								<legend>Custom Colors</legend>
	';
	foreach ($cfct_color_options as $option => $default) {
		$value = get_option($option);
		$value == '' ? $value = $default : $value = attribute_escape($value);
		$label = ucwords(str_replace(
			array('cfct_', '_'),
			array('', ' '),
			$option
		));
		$html .= '
								<p>
									<label for="'.$option.'">'.__($label.':', 'carrington-blog').'</label>
									#<input type="text" name="'.$option.'" id="'.$option.'" value="'.$value.'" size="6" maxlength="6" class="cfct_colorpicker" />
								</p>
		';
	}
	$html .= '
								<p class="submit">
									<input type="hidden" name="cfct_header_image_type" id="cfct_header_image_type" value="dark" />
									<input type="hidden" name="cfct_footer_image_type" id="cfct_footer_image_type" value="dark" />
									<input id="reset_colors" type="reset" name="reset_button" value="'.__('Reset to Default Colors', 'carrington-blog').'" />
								</p>
							</fieldset>
							<p>TODO: Header Image</p>
						</fieldset>
					</td>
				</tr>
			</tbody>
		</table>
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row">'.sprintf(__('Behavior', 'carrington-blog'), $key).'</td>
					<td>
						<fieldset>
							<p>
								<label for="cfct_ajax_load">'.__('Load archives and comments with AJAX:', 'carrington-blog').'</label>
								<select name="cfct_ajax_load" id="cfct_ajax_load">'.$ajax_load_options.'</select>
							</p>
							<p>
								<label for="cfct_posts_per_archive_page">'.__('Posts shown on archives pages:', 'carrington-blog').'</label>
								<input type="text" name="cfct_posts_per_archive_page" id="cfct_posts_per_archive_page" value="'.$cfct_posts_per_archive_page.'" size="3" />
							</p>
						</fieldset>
					</td>
				</tr>
			</tbody>
		</table>
	';
	echo $html;
}
add_action('cfct_settings_form_top', 'cfct_blog_settings_form');

function cfct_blog_admin_js() {
	global $cfct_color_options;
?>
<script type="text/javascript">
jQuery(function($) {
	$('input.cfct_colorpicker').each(function() {
		cfct_color_preview($(this), $(this).val());
		var id = $(this).attr('id');
		$('#' + id).ColorPicker({
			onSubmit: function(hsb, hex, rgb) {
				$('#' + id).val(hex.toLowerCase()).each(function() {
					cfct_color_preview($(this), hex, rgb);
				});
			},
			onChange: function(hsb, hex, rgb) {
				$('#' + id).val(hex.toLowerCase()).each(function() {
					cfct_color_preview($(this), hex, rgb);
				});
			},
			onBeforeShow: function () {
				$(this).ColorPickerSetColor(this.value);
			}
		})
		.bind('keyup', function() {
			$(this).val($(this).val().toLowerCase()).ColorPickerSetColor(this.value).each(function() {
				cfct_color_preview($(this), this.value);
			});
		});
	});
	$('#cfct_custom_colors').change(function() {
		if ($(this).val() == 'yes') {
			$('#cfct_color_options_panel').slideDown();
		}
		else {
			$('#cfct_color_options_panel').slideUp();
		}
	});
	$('#reset_colors').click(function() {
		cfct_reset_colors();
		return false;
	});
});
cfct_reset_colors = function() {
<?php
	foreach ($cfct_color_options as $key => $default) {
		echo '	jQuery("#'.$key.'").val("'.$default.'").each(function() { cfct_color_preview(jQuery(this), "'.$default.'"); });'."\n";
	}
?>
}
cfct_set_image_types = function() {
	areas = ['header', 'footer'];
	for (var i = 0; i < areas.length; i++) {
		var area = areas[i];
		var rgb = getRGB(jQuery('#cfct_' + area + '_background_color').val());
		var brightness = (rgb.r + rgb.g + rgb.b) / 3;
		brightness > 127 ? img = 'light' : img = 'dark';
		jQuery('#cfct_' + area + '_image_type').val(img);
	}
}
cfct_color_preview = function(elem, hex) {
	var rgb = getRGB(hex);
	var brightness = (rgb.r + rgb.g + rgb.b) / 3;
	brightness > 127 ? color = '#000' : color = '#fff';
	jQuery(elem).css({
		backgroundColor: '#' + hex,
		color: color
	});
	cfct_set_image_types();
}
</script>
<?php
}
add_action('admin_head', 'cfct_blog_admin_js');

function cfct_blog_admin_css() {
// override default WP admin setting
?>
<style type="text/css">
.colorpicker input[type="text"] {
	-moz-box-sizing:content-box;
}
#cfct_color_options_panel {
	border: 1px solid #ccc;
	padding: 0 20px;
}
#cfct_color_options_panel legend {
	padding: 0 5px;
}
</style>
<?php
}
add_action('admin_head', 'cfct_blog_admin_css');
include_once(CFCT_PATH.'functions/carrington.php');

?>