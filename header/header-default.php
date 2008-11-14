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
if (CFCT_DEBUG) { cfct_banner(__FILE__); }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes() ?>>
<head profile="http://gmpg.org/xfn/11">
	<title><?php wp_title( '-', true, 'right' ); echo wp_specialchars( get_bloginfo('name'), 1 ); ?></title>
	<meta http-equiv="content-type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>" />
	
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url') ?>" title="<?php printf( __( '%s latest posts', 'sandbox' ), wp_specialchars( get_bloginfo('name'), 1 ) ) ?>" />
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php printf( __( '%s latest comments', 'sandbox' ), wp_specialchars( get_bloginfo('name'), 1 ) ) ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url') ?>" />
	
	<?php wp_get_archives('type=monthly&format=link'); ?>
	
	<link rel="stylesheet" type="text/css" media="screen, print, handheld" href="<?php bloginfo('template_url') ?>/css/typography.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('stylesheet_url') ?>" />
	<!--[if lt IE 8]>
		<link rel="stylesheet" href="<?php bloginfo('template_directory') ?>/css/ie.css" type="text/css" media="screen" charset="utf-8" />
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body class="<?php sandbox_body_class() ?>">
	<div id="page">
		<p id="top"><a id="to-content" href="#content" title="<?php _e( 'Skip to content', 'sandbox' ) ?>"><?php _e( 'Skip to content', 'carrington' ); ?></a></p>
		<div id="header">
			<div class="wrapper">
				<strong id="blog-title"><a href="<?php bloginfo('url') ?>/" title="Home" rel="home"><?php bloginfo('name') ?></a></strong>
				<p id="blog-description"><?php bloginfo('description'); ?></p>
				<div id="navigation">
					<ul>
						<?php wp_list_pages('title_li='); ?>
						<?php
						global $user_ID;
						if($user_ID) {
							echo '<li class="secondary"><a href="' . site_url('wp-login.php?action=logout', 'login') . '">' . __('Log Out', 'carrington') . '</a></li>';
						} else {
							echo '<li class="secondary"><a href="' . site_url('wp-login.php', 'login') . '">' . __('Log In', 'carrington') . '</a></li>';
						}
						 ?>
						<?php wp_register('<li class="secondary">', '</li>'); ?> 
					</ul>
				</div><!-- #navigation -->
			</div><!-- .wrapper -->
		</div><!-- #header -->
		<div id="sub-header">
			<div class="wrapper">
				<?php cfct_form('search'); ?>
				<div id="all-categories">
					<span class="heading">Categories:</span>
					<ul>
						<?php wp_list_categories('title_li='); ?>
					</ul>
				</div><!-- #list-categories -->
			</div><!-- .wrapper -->
		</div><!--#sub-header-->
		<hr class="divider">
		<div class="wrapper">