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

global $post, $wp_query, $comments, $comment;
if (empty($post->post_password) || $_COOKIE['wp-postpass_' . COOKIEHASH] == $post->post_password) {
	$comments = $wp_query->comments;
	$comment_count = count($comments);
	$comment_count == 1 ? $comment_title = __('One Response', 'carrington') : $comment_title = sprintf(__('%d Responses', 'carrington'), $comment_count);
}

?>

<h2 class="comments"><?php echo $comment_title; ?></h2>

<?php

__('Stay in touch with the conversation, subscribe to the <a href="'.get_post_comments_feed_link($post->ID, '').'">RSS feed for the comments on this post</a>.'),'carrington');

?>

<?php 

if ($comments) {
	$comment_count = 0;
	$ping_count = 0;
	foreach ($comments as $comment) {
		if (get_comment_type() == 'comment') {
			$comment_count++;
		}
		else {
			$ping_count++;
		}
	}
	if ($comment_count) {
		cfct_template_file('comments', 'comments-loop');
	}
	if ($ping_count) {

?>
<h3 class="pings"><?php _e('Continuing the Discussion', 'carrington'); ?></h3>
<?php

		cfct_template_file('comments', 'pings-loop');
	}
}

cfct_form('comment'); 

?>