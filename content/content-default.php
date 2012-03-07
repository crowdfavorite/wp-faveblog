<?php

// This file is part of the FaveBlog Theme for WordPress
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
?>
<div id="post-content-<?php the_ID() ?>" <?php post_class('full'); ?>>
	
	<h1 class="entry-title full-title"><a href="<?php the_permalink() ?>" title="Permanent link to <?php the_title_attribute() ?>" rel="bookmark" rev="post-<?php the_ID(); ?>"><?php the_title() ?></a></h1>
	
	<div class="entry-content full-content">
<?php 
		the_content('<span class="more-link">'.__('Continued...', 'carrington-blog').'</span>'); 
		$args = array(
			'before' => '<p class="pages-link">'. __('Pages: ', 'carrington-blog'),
			'after' => "</p>\n",
			'next_or_number' => 'number'
		);
		wp_link_pages($args);
?>
		<div class="clear"></div>
	</div><!-- .entry-content-->
	
	<p class="filed categories alt-font tight"><?php printf(__('Posted in %s.', 'carrington-blog'), get_the_category_list(', ')); ?></p>
	<?php the_tags(__('<p class="filed tags alt-font tight">Tagged with ', 'carrington-blog'), ', ', '.</p>'); ?>

	<?php if (!is_singular()) { ?>
		<p class="comments-link"><?php comments_popup_link(__('No comments', 'carrington-blog'), __('1 comment', 'carrington-blog'), __('% comments', 'carrington-blog')); ?></p>
	<?php } ?>

	<p class="by-line">
		<span class="author vcard full-author">
			<?php printf(__('<span class="by alt-font">By</span> %s', 'carrington-blog'), '<a class="url fn" href="'.get_author_posts_url(get_the_author_meta('ID')).'" title="View all posts by ' . attribute_escape(get_the_author()) . '">'.get_the_author().'</a>') ?>
		</span>
		<span class="date full-date"><span class="ndash alt-font">&ndash;</span> <abbr class="published" title="<?php the_time('c'); ?>"><?php the_time('F j, Y'); ?></abbr></span>
	</p><!--/by-line-->

	<div id="post-comments-<?php the_ID(); ?>-target"></div>
	<div class="clear"></div>
	
	<?php edit_post_link(__('Edit', 'carrington-blog'), '<div class="edit-post edit">', '</div>'); ?>
</div><!-- .post -->