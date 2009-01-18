<?php

// This file is part of the Carrington Blog Theme for WordPress
// http://carringtontheme.com
//
// Copyright (c) 2008-2009 Crowd Favorite, Ltd. All rights reserved.
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
	
	<link href="<?php bloginfo('url') ?>" rel="home" />
	
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url') ?>" title="<?php printf( __( '%s latest posts', 'sandbox' ), wp_specialchars( get_bloginfo('name'), 1 ) ) ?>" />
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php printf( __( '%s latest comments', 'sandbox' ), wp_specialchars( get_bloginfo('name'), 1 ) ) ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url') ?>" />
	
	<link rel="stylesheet" type="text/css" media="screen, print, handheld" href="<?php bloginfo('template_url') ?>/css/typography.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('template_directory') ?>/css/image.css" />
	<!--[if lte IE 6]>
		<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('template_directory') ?>/css/image-ie6.css" />
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body class="<?php sandbox_body_class() ?>">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div id="header">
	<a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment">&larr; back to &#8220;<?php echo get_the_title($post->post_parent); ?>&#8221;</a>
</div>

<div id="content" class="figure">
	<div class="entry-attachment">
		<a title="Link to original file" href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'full' ); ?></a>
	</div>
 	<div class="figure-info">
		<div class="caption">
			<h1 class="title"><?php the_title(); ?></h1>
			<?php if ( !empty($post->post_excerpt) ) the_excerpt(); // this is the "caption" ?>
		</div>
		<div class="description">
			<?php the_content() ?>
		</div>
	</div>

<?php
	if(cfct_get_adjacent_image_link(false) != '') {
		echo '<div class="next-attachment"><span>',next_image_link(),'</span></div>';
	}
	if(cfct_get_adjacent_image_link(true) != '') {
		echo '<div class="previous-attachment"><span>',previous_image_link(),'</span></div>';
	}
	
?>
</div>

<?php endwhile; else: ?>

		<p>Sorry, no attachments matched your criteria.</p>

<?php endif; ?>

<?php wp_footer() ?>
</body>
</html>