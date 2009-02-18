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

global $comment;

?>
<div id="div-comment-<?php comment_ID(); ?>" <?php comment_class('hentry'); ?>>
<?php
if ($comment->comment_approved == '0') {
?>
	<div class="notification"><strong><?php _e('Your comment is awaiting moderation.', 'carrington-blog'); ?></strong></div>
<?php 
}
?>

	<address class="vcard author entry-title comment-author">
<?php 
if (function_exists('get_avatar')) { 
?>
		<span class="photo avatar"><?php echo get_avatar($comment, 36) ?></span>
<?php
}

printf(__('%s <span class="says">says</span>', 'carrington-blog'), '<cite class="fn">'.get_comment_author_link().'</cite>');
?>
	</address><!--.vcard-->

	<div class="entry-content comment-content">
		<?php comment_text() ?>
	</div><!--.entry-content-->
	
	<div class="comment-meta commentmetadata small">
		<span class="date comment-date">
<?php
printf(
	__('<span class="on">on</span> <abbr class="published" title="%s">%s <span class="at">at</span> <a title="Permanent link to this comment" rel="bookmark" href="%s#comment-%s">%s</a></abbr>'
	, 'carrington'
	)
	, get_comment_date('Y-m-d\TH:i:sO')
	, get_comment_date()
	, get_permalink()
	, get_comment_ID()
	, get_comment_time()
);
?>
		</span><!--.date-->
<?php
		edit_comment_link(__('Edit This', 'carrington-blog'), '<div class="edit-comment edit">', '</div>');
?>
	</div>
</div><!--.comment-->