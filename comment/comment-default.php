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

global $comment;

?>
<div id="comment-<?php comment_ID(); ?>" class="<?php cfct_comment_class(); ?>">
<?php
if ($comment->comment_approved == '0') {
?>
	<div class="notification"><strong><?php _e('Your comment is awaiting moderation.', 'carrington'); ?></strong></div>
<?php 
}
?>

	<div class="info">
		<address class="vcard author entry-title comment-author">
<?php 
if (function_exists('get_avatar')) { 
?>
			<span class="photo"><?php echo get_avatar($comment, 36) ?></span>
<?php
}
add_filter('get_comment_author_link', 'cfct_hcard_comment_author_link');

printf(__('%s <span class="said">said</span>', 'carrington'), get_comment_author_link());

remove_filter('get_comment_author_link', 'cfct_hcard_comment_author_link');
?>
		</address><!--.vcard-->
		<div class="date comment-date">
<?php
printf(
	__('<span class="on">on</span> <abbr class="published" title="%s"><a title="Permanent link to this comment" rel="bookmark" href="%s#comment-%s">%s</a></abbr>'
	, 'carrington'
	)
	, get_comment_date('Y-m-d\TH:i:sO')
	, get_permalink()
	, get_comment_ID()
	, get_comment_date()
);
?>
		</div><!--.date-->
	</div><!--.info-->

	<div class="entry-content comment-content">
		<?php comment_text() ?>
	</div><!--.entry-content-->
	<?php edit_comment_link(__('Edit This', 'carrington'), '<div class="comment-editlink">', '</div>'); ?>
</div><!--.comment-->