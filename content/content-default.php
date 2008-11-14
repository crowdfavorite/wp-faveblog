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

global $previousday, $authordata;
$previousday = -1;

?>
<div id="post-content-<?php the_ID() ?>" class="hentry full <?php sandbox_post_class() ?>">
	<h1 class="entry-title full-title"><a href="<?php the_permalink() ?>" title="Permanent link to <?php the_title_attribute() ?>" rel="bookmark" rev="post-<?php the_ID(); ?>"><?php the_title() ?></a></h1>
	<div class="entry-content full-content">
		<?php the_content('<span class="more-link">'.__('Continued...', 'carrington').'</span>'); link_pages('<p class="pages-link">'.__('Pages: ', 'carrington'), "</p>\n", 'number'); ?>
	</div><!--/entry-content-->
	<p class="filed">
		<span class="categories"><?php printf(__('Posted in %s.', 'carrington'), get_the_category_list(', ')) ?></span> 
		<?php the_tags(__('<span class="tags">Tagged with ', 'carrington'), ', ', '.</span>'); ?>
	</p><!--/filed-->
	<div class="by-line">
		<address class="author vcard full-author">
			<?php printf(__('<span class="by">By</span> %s', 'carrington'), '<a class="url fn" href="'.get_author_link(false, get_the_author_ID(), $authordata->user_nicename).'" title="View all posts by ' . attribute_escape($authordata->display_name) . '">'.get_the_author().'</a>') ?>
		</address>
		<span class="date full-date"><abbr class="published" title="<?php the_time('Y-m-d\TH:i:sO'); ?>"><?php the_date(); ?></abbr></span>
	</div><!--/by-line-->
	<p class="comments-link"><?php comments_popup_link(__('No comments', 'carrington'), __('1 comment', 'carrington'), __('% comments', 'carrington')); ?></p>
	<div class="clear"></div>
	<div id="post-comments-<?php the_ID(); ?>-target"></div>
	<?php edit_post_link(__('Edit This', 'carrington'), '<div class="entry-editlink">', '</div>'); ?>
</div><!-- .post -->