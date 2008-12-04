<?php

// This file is part of the Carrington Theme for WordPress
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

load_theme_textdomain('carrington');

define('CFCT_DEBUG', false);
define('CFCT_PATH', trailingslashit(TEMPLATEPATH));
define('CFCT_HOME_LIST_LENGTH', 5);
define('CFCT_HOME_LATEST_LENGTH', 250);

$cfct_options = array(
	'cfct_home_column_1_cat'
	, 'cfct_home_column_1_content'
	, 'cfct_latest_limit_1'
	, 'cfct_list_limit_1'
	, 'cfct_home_column_2_cat'
	, 'cfct_home_column_2_content'
	, 'cfct_latest_limit_2'
	, 'cfct_list_limit_2'
	, 'cfct_home_column_3_cat'
	, 'cfct_home_column_3_content'
	, 'cfct_latest_limit_3'
	, 'cfct_list_limit_3'
	, 'cfct_about_text'
	, 'cfct_ajax_load'
	, 'cfct_credit'
	, 'cfct_posts_per_archive_page'
	, 'cfct_wp_footer'
);

include_once(CFCT_PATH.'functions/carrington.php');


?>