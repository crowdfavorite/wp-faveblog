<?php

// This file is part of the Carrington Blog Theme for WordPress
// http://carringtontheme.com
//
// Copyright (c) 2008-2012 Crowd Favorite, Ltd. All rights reserved.
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
if (CFCT_DEBUG) { cfct_banner(__FILE__); }

$blog_desc = get_bloginfo('description');
(is_home() && !empty($blog_desc)) ? $title_description = ' - '.$blog_desc : $title_description = '';

$use_background_img = cfct_get_option('cfct_css_background_images');
$use_background_img == 'no' ? $css_ext = '?type=noimg' : $css_ext = '';

?>
<!DOCTYPE html>
<html <?php language_attributes() ?>>
<head>
	<meta charset="<?php bloginfo('charset') ?>" />

	<title><?php wp_title( '-', true, 'right' ); echo esc_html( get_bloginfo('name') ).$title_description; ?></title>
	
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div id="page">
		<div id="top"><a class="accessibility" href="#content"><?php _e( 'Skip to content', 'fave-blog' ); ?></a></div>
		<hr class="lofi" />
		<div id="header" class="section">
			<div class="wrapper">
				<strong id="blog-title"><a href="<?php echo home_url() ?>/" rel="home"><?php bloginfo('name') ?></a></strong>
				<p id="blog-description"><?php bloginfo('description'); ?></p>
				<div id="navigation">
					<ul class="nav clearfix">
						<?php wp_list_pages('title_li='); ?>
						<li class="secondary"><?php wp_loginout(); ?></li>
						<?php wp_register('<li class="secondary">', '</li>'); ?> 
					</ul>
				</div><!-- #navigation -->
			</div><!-- .wrapper -->
		</div><!-- #header -->
		<div id="sub-header" class="section">
			<div class="wrapper">
				<?php cfct_form('search'); ?>
				<div id="all-categories">
					<strong id="all-categories-title"><?php _e('Categories:', 'fave-blog'); ?></strong>
					<ul class="nav clearfix">
						<?php wp_list_categories('title_li='); ?>
					</ul>
				</div><!-- #list-categories -->
			</div><!-- .wrapper -->
		</div><!--#sub-header-->
		<hr class="lofi" />
		<div id="main" class="section">
			<div class="wrapper">