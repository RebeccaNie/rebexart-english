<?php
if ( function_exists('register_sidebar') ) {
  register_sidebar(array('name' => 'Header Left Sidebar', 'before_title' => '<h3>', 'after_title' => '</h3>'));
  register_sidebar(array('name' => 'Header Right Sidebar', 'before_title' => '<h3>', 'after_title' => '</h3>'));
  register_sidebar(array('name' => 'Body Right Sidebar', 'before_title' => '<h3>', 'after_title' => '</h3>'));
  register_sidebar(array('name' => 'Post Left Sidebar'));
}
function mytheme_comment($comment, $args, $depth) {
  $GLOBALS['comment'] = $comment;
?>
	<div class="item" id="comment-<?php comment_ID() ?>">
	  <div class="vcard side left">
	    <span class="date"><a href="<?php the_permalink(); ?>#comment-<?php comment_ID() ?>"><?php comment_date('j M Y, g:ia') ?></a></span><br/>
	    by
	    <?php if ($comment->comment_author_url) : ?>
	        <span class="fn"><a class="url" href="<?php comment_author_url(); ?>"><?php comment_author() ?></a></span><br/>
	        <a href="<?php comment_author_url(); ?>"><?php echo get_avatar( $comment, $size = '48', $default = 'identicon' ); ?></a><br/>
	    <?php else : ?>
	        <span class="fn"><?php comment_author() ?></span><br/>
	        <?php echo get_avatar( $comment, $size = '48', $default = 'identicon' ); ?><br/>
	    <?php endif; ?>
	    <?php edit_comment_link('edit', '', ''); ?>
	    <?php comment_reply_link(array_merge( $args, array('reply_text' => 'reply', 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?><br/>
	  </div>
	  <div class="main">
	    <div class="comment<?php if ($comment->user_id == $args['post']->post_author) { echo ' highlight'; }; ?> depth<?php echo $depth; ?>">
	      <?php comment_text() ?>
	    </div>
	  </div>
<?php
}
define('HEADER_TEXTCOLOR', '000000');
define('HEADER_IMAGE', '%s/header.jpg');
define('HEADER_IMAGE_WIDTH', 500);
define('HEADER_IMAGE_HEIGHT', 265);
function header_style() {
?>
<style type="text/css">
div.splash {
	background-image: url('<?php header_image() ?>');
}
</style>
<?php
}
function emptiness_admin_header_style() {
?>
<style type="text/css">
</style>
<?php
}
add_custom_image_header('header_style', 'emptiness_admin_header_style');
?>