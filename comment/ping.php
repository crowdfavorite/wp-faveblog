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
<div id="comment-<?php comment_ID(); ?>" class="<?php cfct_comment_class(); ?>">
<?php

add_filter('get_comment_author_link', 'cfct_hcard_ping_author_link');

printf(__('<cite class="vcard author entry-title">%s <span class="linked-to-this-post">linked to this post</span></cite>', 'carrington'), get_comment_author_link());

remove_filter('get_comment_author_link', 'cfct_hcard_ping_author_link');

?> 
	<span class="date">
		<span class="on"><?php _e('on'); ?></span> <abbr class="published" title="<?php comment_date('Y-m-d\TH:i:sO'); ?>"><?php comment_date(); ?></abbr>
	</span>
	<blockquote class="entry-summary" cite="<?php comment_author_url(); ?>"><?php comment_text() ?></blockquote> 
	<?php edit_comment_link(__('Edit This', 'carrington'), '<div class="comment-editlink">', '</div>'); ?>
</div><!--.ping-->