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

include_once(CFCT_PATH.'functions/admin.php');
include_once(CFCT_PATH.'functions/sidebars.php');

include_once(CFCT_PATH.'carrington-core/carrington.php');

?>