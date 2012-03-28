<?php
$url = trailingslashit(get_template_directory_uri());
define('CFCT_ASSETS_URL', $url.'assets/');

wp_enqueue_style(
	'carrington',
	CFCT_ASSETS_URL.'css/css.php',
	array(),
	CFCT_URL_VERSION
);

wp_enqueue_script('jquery');
wp_enqueue_script( 'comment-reply' );
wp_enqueue_script(
	'carrington',
	CFCT_ASSETS_URL.'js/carrington.js',
	array('jquery'),
	CFCT_URL_VERSION
);

if (cfct_get_option('cfct_ajax_load') == 'yes') {
	cfct_ajax_load();
}
if (cfct_get_option('cfct_lightbox') != 'no') {
	wp_enqueue_script(
		'cfct_thickbox',
		$url.'carrington-core/lightbox/thickbox.js',
		array('jquery'),
		CFCT_URL_VERSION
	);
	
	wp_enqueue_style(
		'cfct_thickbox',
		$url.'carrington-core/lightbox/css/thickbox.css',
		array(),
		CFCT_URL_VERSION
	);
}

/* Additional stuff to put in wp_head */

function cfct_blog_head() {
	cfct_get_option('cfct_ajax_load') == 'no' ? $ajax_load = 'false' : $ajax_load = 'true';
	
	echo '
<script type="text/javascript">
var CFCT_URL = "'.home_url().'";
var CFCT_AJAX_LOAD = '.$ajax_load.';
</script>
	';
	
	if (cfct_get_option('cfct_lightbox') != 'no') {
		echo '
<script type="text/javascript">
tb_pathToImage = "' . get_template_directory_uri() . '/carrington-core/lightbox/img/loadingAnimation.gif";
jQuery(function($) {
	$("a.thickbox").each(function() {
		var url = $(this).attr("rel");
		var post_id = $(this).parents("div.post, div.page").attr("id");
		$(this).attr("href", url).attr("rel", post_id);
	});
});
</script>';
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
	background-image: url(<?php echo CFCT_ASSETS_URL; ?>img/footer/by-crowd-favorite-<?php echo $footer_img_type; ?>.png);
}
<?php
	if (cfct_get_option('cfct_css_background_images') != 'no') {
?>
#header {
	background-image: url(<?php echo CFCT_ASSETS_URL; ?>img/header/gradient-<?php echo $header_grad_type; ?>.png);
}
#header .wrapper {
	background-image: url(<?php echo CFCT_ASSETS_URL; ?>img/header/texture-<?php echo $header_img_type; ?>.png);
}
#footer {
	background-image: url(<?php echo CFCT_ASSETS_URL; ?>img/footer/gradient-<?php echo $footer_img_type; ?>.png);
}
<?php
	}
?>
</style>
<?php
}
?>