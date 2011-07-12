<?php

// This file is part of the Carrington Blog Theme for WordPress
// http://carringtontheme.com
//
// Copyright (c) 2008-2010 Crowd Favorite, Ltd. All rights reserved.
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

load_theme_textdomain('carrington-blog');

define('CFCT_DEBUG', false);
define('CFCT_PATH', trailingslashit(TEMPLATEPATH));
define('CFCT_HOME_LIST_LENGTH', 5);
define('CFCT_HOME_LATEST_LENGTH', 250);

include_once(CFCT_PATH.'functions/admin.php');
include_once(CFCT_PATH.'functions/sidebars.php');
include_once(CFCT_PATH.'carrington-core/carrington.php');

$cfct_options = array(
	'cfct_home_column_1_cat',
	'cfct_home_column_1_content',
	'cfct_latest_limit_1',
	'cfct_list_limit_1',
	'cfct_home_column_2_cat',
	'cfct_home_column_2_content',
	'cfct_latest_limit_2',
	'cfct_list_limit_2',
	'cfct_home_column_3_cat',
	'cfct_home_column_3_content',
	'cfct_latest_limit_3',
	'cfct_list_limit_3',
	'cfct_ajax_load',
	'cfct_lightbox',
	'cfct_posts_per_archive_page',
	'cfct_custom_colors',
	'cfct_custom_header_image',
	'cfct_header_image_type',
	'cfct_footer_image_type',
	'cfct_header_image',
	'cfct_css_background_images',
);

$cfct_color_options = array(
	'cfct_header_background_color' => '51555c',
	'cfct_header_text_color' => 'cecfd1',
	'cfct_header_link_color' => 'ffffff',
	'cfct_header_nav_background_color' => 'e9eaea',
	'cfct_header_nav_link_color' => 'a00004',
	'cfct_header_nav_text_color' => '51555c',
	'cfct_page_title_color' => '51555c',
	'cfct_page_subtitle_color' => '51555c',
	'cfct_link_color' => 'a00004',
	'cfct_footer_background_color' => '51555c',
	'cfct_footer_text_color' => '999999',
	'cfct_footer_link_color' => 'CECFD1',
);

foreach ($cfct_color_options as $k => $default) {
	$cfct_options[] = $k;
}

function cfct_blog_option_defaults($options) {
	$options['cfct_list_limit_1'] = CFCT_HOME_LIST_LENGTH;
	$options['cfct_latest_limit_1'] = CFCT_HOME_LATEST_LENGTH;
	$options['cfct_list_limit_2'] = CFCT_HOME_LIST_LENGTH;
	$options['cfct_latest_limit_2'] = CFCT_HOME_LATEST_LENGTH;
	$options['cfct_list_limit_3'] = CFCT_HOME_LIST_LENGTH;
	$options['cfct_latest_limit_3'] = CFCT_HOME_LATEST_LENGTH;
	$options['cfct_ajax_load'] = 'yes';
	$options['cfct_custom_colors'] = 'no';
	$options['cfct_custom_header_image'] = 'no';
	$options['cfct_css_background_images'] = 'yes';
	return $options;
}
add_filter('cfct_option_defaults', 'cfct_blog_option_defaults');


function cfct_blog_init() {
	if (cfct_get_option('cfct_ajax_load') == 'yes') {
		cfct_ajax_load();
	}
	if (cfct_get_option('cfct_lightbox') != 'no' && !is_admin()) {
		wp_enqueue_script('cfct_thickbox', get_bloginfo('template_directory').'/carrington-core/lightbox/thickbox.js', array('jquery'), '1.0');
// in the future we'll use this, but for now we want 2.5 compatibility
//		wp_enqueue_style('jquery-lightbox', get_bloginfo('template_directory').'/carrington-core/lightbox/css/lightbox.css');
	}
}
add_action('init', 'cfct_blog_init');

wp_enqueue_script('jquery');
wp_enqueue_script('carrington', get_bloginfo('template_directory').'/js/carrington.js', array('jquery'), '1.0');

// Filter comment reply link to work with namespaced comment-reply javascript.
add_filter('cancel_comment_reply_link', 'cfct_get_cancel_comment_reply_link', 10, 3);

function cfct_blog_head() {
// see enqueued style in cfct_blog_init, we'll activate that in the future
	if (cfct_get_option('cfct_lightbox') != 'no') {
		echo '
<link rel="stylesheet" type="text/css" media="screen" href="'.get_bloginfo('template_directory').'/carrington-core/lightbox/css/thickbox.css" />
		';
	}
	cfct_get_option('cfct_ajax_load') == 'no' ? $ajax_load = 'false' : $ajax_load = 'true';
	echo '
<script type="text/javascript">
var CFCT_URL = "'.get_bloginfo('url').'";
var CFCT_AJAX_LOAD = '.$ajax_load.';
</script>
	';
	if (cfct_get_option('cfct_lightbox') != 'no') {
		echo '
<script type="text/javascript">
tb_pathToImage = "' . get_bloginfo('template_directory') . '/carrington-core/lightbox/img/loadingAnimation.gif";
jQuery(function($) {
	$("a.thickbox").each(function() {
		var url = $(this).attr("rel");
		var post_id = $(this).parents("div.post, div.page").attr("id");
		$(this).attr("href", url).attr("rel", post_id);
	});
});
</script>
		';
	}
// preview
	if (isset($_GET['cfct_action']) && $_GET['cfct_action'] == 'custom_color_preview' && current_user_can('manage_options')) {
		cfct_blog_custom_colors('preview');
	}
	else if (cfct_get_option('cfct_custom_colors') == 'yes') {
		cfct_blog_custom_colors();
	}
	if (cfct_get_option('cfct_custom_header_image') == 'yes') {
		$header_image = cfct_get_option('cfct_header_image');
		if ($header_image != 0 && $img = wp_get_attachment_image_src($header_image, 'large')) {
?>
<style type="text/css">
#header .wrapper {
	background-image: url(<?php echo $img[0]; ?>);
	background-repeat: no-repeat;
	min-height: <?php echo $img[2]; ?>px;
}
</style>
<?php
		}
		else {
?>
<style type="text/css">
#header .wrapper {
	background-image: url();
}
</style>
<?php
		}
	}
}
add_action('wp_head', 'cfct_blog_head');

function cfct_blog_custom_colors($type = 'option') {
	$colors = cfct_get_custom_colors($type);
	if (get_option('cfct_header_image_type') == 'light') {
		$header_img_type = 'light';
		$header_grad_type = 'dark';
	}
	else {
		$header_img_type = 'dark';
		$header_grad_type = 'light';
	}
	get_option('cfct_footer_image_type') == 'light' ? $footer_img_type = 'light' : $footer_img_type = 'dark';
?>
<style type="text/css">
#header {
	background-color: #<?php echo $colors['cfct_header_background_color']; ?>;
	color: #<?php echo $colors['cfct_header_text_color']; ?>;
}
#header a,
#header a:visited {
	color: #<?php echo $colors['cfct_header_link_color']; ?>;
}
#sub-header,
.nav ul{
	background-color: #<?php echo $colors['cfct_header_nav_background_color']; ?>;
	color: #<?php echo $colors['cfct_header_nav_text_color']; ?>;
}
#sub-header a,
#sub-header a:visited,
.nav li li a,
.nav li li a:visited {
	color: #<?php echo $colors['cfct_header_nav_link_color']; ?> !important;
}
h1,
h1 a,
h1 a:hover,
h1 a:visited {
	color: #<?php echo $colors['cfct_page_title_color']; ?>;
}
h2,
h2 a,
h2 a:hover,
h2 a:visited {
	color: #<?php echo $colors['cfct_page_subtitle_color']; ?>;
}
a,
a:hover,
a:visited {
	color: #<?php echo $colors['cfct_link_color']; ?>;
}
.hentry .edit,
.hentry .edit a,
.hentry .edit a:visited,
.hentry .edit a:hover,
.comment-reply-link,
.comment-reply-link:visited,
.comment-reply-link:hover {
	background-color: #<?php echo $colors['cfct_link_color']; ?>;
}
#footer {
	background-color: #<?php echo $colors['cfct_footer_background_color']; ?>;
	color: #<?php echo $colors['cfct_footer_text_color']; ?>;
}
#footer a,
#footer a:visited {
	color: #<?php echo $colors['cfct_footer_link_color']; ?>;
}
#footer p#developer-link a,
#footer p#developer-link a:visited {
	background-image: url(<?php bloginfo('template_directory'); ?>/img/footer/by-crowd-favorite-<?php echo $footer_img_type; ?>.png);
}
<?php
	if (cfct_get_option('cfct_css_background_images') != 'no') {
?>
#header {
	background-image: url(<?php bloginfo('template_directory'); ?>/img/header/gradient-<?php echo $header_grad_type; ?>.png);
}
#header .wrapper {
	background-image: url(<?php bloginfo('template_directory'); ?>/img/header/texture-<?php echo $header_img_type; ?>.png);
}
#footer {
	background-image: url(<?php bloginfo('template_directory'); ?>/img/footer/gradient-<?php echo $footer_img_type; ?>.png);
}
<?php
	}
?>
</style>
<?php

}

/**
 * Start and end an output buffer at specific actions that you specify.
 * Warning: this is a bit of a tricky thing to do, but it works in a pinch.
 * Basically, don't use this unless you really have to.
 */
class CFCT_OB_On_Action {
	protected $ob_started = false;
	protected $hooks_attached = false;
	protected $callback;
	
	public function __construct($start_action, $end_action, $callback = null, $priority = 10) {
		if ($callback === null) {
			$callback = array($this, 'callback');
		}
		
		$this->start_action = $start_action;
		$this->end_action = $end_action;
		$this->callback = $callback;
		$this->priority = $priority;
		
		$this->attach_hooks();
	}
	
	/**
	 * If you specialize this class, you can customize this function to do something
	 * with the buffer. Otherwise, just pass your callback in using the $callback param in __construct().
	 */
	public function callback($buffer) {
		// Do something...
	}
	
	/**
	 * Attach hooks for actions. Only runs once.
	 */
	protected function attach_hooks() {
		if ($this->hooks_attached === true) {
			return;
		}
		add_action($this->start_action, array($this, 'start'));
		add_action($this->end_action, array($this, 'end'));
		$this->hooks_attached = true;
	}
	
	protected function remove_hooks() {
		remove_action($this->start_action, array($this, 'start'));
		remove_action($this->end_action, array($this, 'end'));
	}
	
	public function start() {
		ob_start($this->callback);
		$this->ob_started = true;
	}
	
	public function end() {
		/* Check if this function is running before $this->start() gets a chance to run.
		This could happen if the end action passed runs before the start action. Under
		no circumstances do you want that to happen. If it does, throw a traceable error
		so we know what's going on. */
		if ($this->ob_started !== true) {
			throw new Exception("Uh-oh! Method end() ran before start(). This can happen if the end action you provided runs before the start action. Make sure you specify an end action that always runs after the start action.", 1);
		}
		ob_end_flush();
	}
}

/**
 * A collection of filters for comment_form().
 * Usage: CFCT_Comment_Form::setup();
 */
class CFCT_Comment_Form {
	public static $i18n = 'carrington-blog';
	protected static $instance;
	protected static $hooks_attached = false;
	
	/**
	 * Singleton factory method
	 * @return object instance of CFCT_Comment_Form
	 */
	public static function get_instance() {
		if (!self::$instance) {
			self::$instance = new CFCT_Comment_Form();
		}
		return self::$instance;
	}
	
	/**
	 * Convenient factory method that instantiates single instance and
	 * attaches hooks automatically.
	 * @return object instance of CFCT_Comment_Form
	 */
	public static function setup() {
		$ins = self::get_instance();
		$ins->attach_hooks();
		return $ins;
	}
	
	/**
	 * Attach hooks to WordPress. Runs only once.
	 * @uses CFCT_OB_On_Action
	 */
	public function attach_hooks() {
		if (self::$hooks_attached === true) {
			return false;
		}
		add_action('comment_form_defaults', array($this, 'configure_args'));
		add_filter('comment_id_fields', array($this, 'comment_id_fields'), 10, 3);
		
		// Set up an output buffer so we can do string replacements on areas that aren't filterable.
		new CFCT_OB_On_Action('comment_form_before', 'comment_form_after', array($this, 'ob_callback'));
		
		self::$hooks_attached = true;
	}
	
	public function ob_callback($buffer) {
		global $post;
		$mod = 'p'.$post->ID;
		$buffer = strtr($buffer, array(
			'id="respond"' => 'id="respond-'.$mod.'" class="respond"',
			'id="commentform"' => 'class="comment-form"',
			'id="reply-title"' => 'class="comment-form-title"',

			'id="author"' => 'id="author-'.$mod.'"',
			'for="author"' => 'for="author-'.$mod.'"',
			
			'id="email"' => 'id="email-'.$mod.'"',
			'for="email"' => 'for="email-'.$mod.'"',

			'id="url"' => 'id="url-'.$mod.'"',
			'for="url"' => 'for="url-'.$mod.'"',
			
			'id="comment"' => 'id="comment-'.$mod.'"'
		));
		
		return $buffer;
	}
	
	public function comment_id_fields($result, $id, $replytoid) {
		// Remove default WP comment ID fields
		$result = '';
		
		// Add trackback link, since this function renders right next to the submit button
		$result .= ' <span class="comment-form-trackback">'.sprintf(__('or, reply to this post via <a rel="trackback" href="%s">trackback</a>.', self::$i18n), get_trackback_url()).'</span>';
		
		// Add our customized comment ID fields
		$result .= cfct_get_comment_id_fields($id, $replytoid);
		return $result;
	}
	
	/**
	 * Attach to 'configure_args' hook
	 */
	public function configure_args($default_args) {
		$commenter = wp_get_current_commenter();
		$req = get_option( 'require_name_email' );
		
		$author_help = ($req ? __('(required)', self::$i18n) : '');
		$email_help = ($req ? __('(required, but never shared)', self::$i18n) : __('(never shared)', self::$i18n));
		
		$fields = array(
			'author' => self::to_input_block(__( 'Name', self::$i18n ), 'author', $commenter['comment_author'], $req, $author_help),
			'email' => self::to_input_block(__( 'Email', self::$i18n ), 'email', $commenter['comment_author_email'], $req, $email_help),
			'url' => self::to_input_block(__( 'Web', self::$i18n ), 'url', $commenter['comment_author_url'])
		);
		
		$textarea = self::to_tag('textarea', '', array(
			'name' => 'comment',
			'id' => 'comment',
			'rows' => 6,
			'cols' => 60,
			'required' => 'required'
		));
		
		$comment_field = self::to_tag('p', $textarea, array('class' => 'comment-form-comment'));
		
		$html_tags = sprintf(__('You can use: %s', self::$i18n), esc_attr(allowed_tags()));
		
		$args = array(
			'fields' => $fields,
			'comment_field' => $comment_field,
			'label_submit' => __('Post Comment', self::$i18n),
			'cancel_reply_link' => __('Cancel reply', self::$i18n),
			'comment_notes_after' => '<small class="help some-html-is-ok"><abbr title="'.$html_tags.'">'.__('Some HTML is OK', 'carrington-text').'</abbr></small>',
			'comment_notes_before' => ''
		);
		return array_merge($default_args, $args);
	}
	
	/**
	 * Helper: Turn an array or two into HTML attribute string
	 */
	public static function to_attr($arr1 = array(), $arr2 = array()) {
		$attrs = array();
		$arr = array_merge($arr1, $arr2);
		foreach ($arr as $key => $value) {
			if (function_exists('esc_attr')) {
				$key = esc_attr($key);
				$value = esc_attr($value);
			}
			$attrs[] = $key.'="'.$value.'"';
		}
		return implode(' ', $attrs);
	}
	
	/**
	 * Helper for creating HTML tag from strings and arrays of attributes.
	 */
	public static function to_tag($tag, $text = '', $attr1 = array(), $attr2 = array()) {
		if (function_exists('esc_attr')) {
			$tag = esc_attr($tag);
		}
		$attrs = self::to_attr($attr1, $attr2);
		if ($text !== false) {
			$tag = '<'.$tag.' '.$attrs.'>'.$text.'</'.$tag.'>';
		}
		// No text == self closing tag
		else {
			$tag = '<'.$tag.' '.$attrs.' />';
		}
		
		return $tag;
	}
	
	public static function to_input_block($label, $id, $value, $req = null, $help_text = '') {
		$label = self::to_tag('label', $label, array('for' => $id));
		
		$maybe_req = ($req ? array('required' => 'required') : array() );
		$input_defaults = array(
			'id' => $id,
			'name' => $id,
			'class' => 'type-text',
			'value' => $value
		);
		$input = self::to_tag('input', false, $input_defaults, $maybe_req);
		
		$help = '';
		if ($help_text) {
			$help = self::to_tag('small', $help_text, array('class' => 'help'));
		}
		
		return self::to_tag('p', $input . ' ' . $label . ' ' . $help, array(
			'class' => 'comment-form-user-info tight'
		));
	}
}
CFCT_Comment_Form::setup();
?>